<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
// Removed unused import of Carbon
// use Carbon\Carbon;
use App\Models\Course;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    /**
     * Show the admin dashboard with aggregated insights.
     */
    public function __invoke()
    {
        $summaryCards = $this->buildSummaryCards();
        $salesSummary = $this->buildSalesSummary();
        $pendingPayments = $this->buildPendingPayments();

        return view('admin.dashboard', compact(
            'summaryCards',
            'salesSummary',
            'pendingPayments'
        ));
    }

    /**
     * Build card metrics for the dashboard hero section.
     */
    private function buildSummaryCards(): array
    {
        $totalUsers = User::count();
        $newUsersThisMonth = User::where('created_at', '>=', now()->startOfMonth())->count();

        $totalSuccessfulPayments = (int) Payment::success()->sum('amount');
        $successfulTransactionsLast30Days = Payment::success()
            ->where('created_at', '>=', now()->subDays(30))
            ->count();

        $pendingPaymentsCount = Payment::pending()->count();
        $pendingPaymentsValue = (int) Payment::pending()->sum('amount');

        return [
            [
                'label' => 'Total Pengguna',
                'value' => number_format($totalUsers),
                'sub' => $newUsersThisMonth > 0
                    ? number_format($newUsersThisMonth).' pengguna baru bulan ini'
                    : 'Belum ada pengguna baru bulan ini',
                'icon' => 'fa-users',
                'gradient' => 'linear-gradient(135deg,#14b8a6,#0d9488)',
            ],
            [
                'label' => 'Total Penjualan Kursus',
                'value' => $this->formatCurrency($totalSuccessfulPayments),
                'sub' => $successfulTransactionsLast30Days.' transaksi sukses 30 hari terakhir',
                'icon' => 'fa-coins',
                'gradient' => 'linear-gradient(135deg,#6366f1,#4338ca)',
            ],
            [
                'label' => 'Penjualan Perlu Diverifikasi',
                'value' => number_format($pendingPaymentsCount).' transaksi',
                'sub' => $pendingPaymentsCount > 0
                    ? 'Menunggu verifikasi senilai '.$this->formatCurrency($pendingPaymentsValue)
                    : 'Tidak ada transaksi menunggu verifikasi',
                'icon' => 'fa-file-circle-question',
                'gradient' => 'linear-gradient(135deg,#f59e0b,#d97706)',
            ],
        ];
    }

    /**
     * Build sales leaderboard data.
     */
    private function buildSalesSummary(): Collection
    {
        $sales = Course::query()
            ->join('users', 'users.user_id', '=', 'courses.instructor_id')
            ->leftJoin('payments', function ($join) {
                $join->on('payments.course_id', '=', 'courses.course_id')
                    ->where('payments.status', '=', 'success');
            })
            ->select([
                'courses.course_id',
                'courses.title',
                DB::raw('COALESCE(users.name, users.username) as instructor_name'),
                DB::raw('COUNT(payments.payment_id) as total_sold'),
                DB::raw('COALESCE(SUM(payments.amount), 0) as total_revenue'),
            ])
            ->groupBy('courses.course_id', 'courses.title', 'instructor_name')
            ->orderByDesc('total_revenue')
            ->limit(5)
            ->get();

        return $sales->map(function ($course) {
            return [
                'course' => $course->title,
                'instructor' => $course->instructor_name,
                'sold' => (int) $course->total_sold,
                'revenue' => $this->formatCurrency((int) $course->total_revenue),
            ];
        });
    }

    /**
     * Build pending payment list for verification.
     */
    private function buildPendingPayments(): Collection
    {
        return Payment::pending()
            ->with([
                'user:user_id,name,username',
                'course:course_id,title',
            ])
            ->latest('created_at')
            ->limit(5)
            ->get()
            ->map(function (Payment $payment) {
                return [
                    'id' => $payment->payment_id,
                    'user' => $payment->user?->name ?? $payment->user?->username ?? 'Pengguna',
                    'course' => $payment->course?->title ?? 'Kursus tidak tersedia',
                    'amount' => $this->formatCurrency((int) ($payment->amount ?? 0)),
                    'submitted_at' => optional($payment->created_at)->diffForHumans() ?? '-',
                    'needs_clarification' => (bool) $payment->clarification_requested_at,
                ];
            });
    }

    /**
     * Format integer into Indonesian Rupiah currency notation.
     */
    private function formatCurrency(int $amount): string
    {
        return 'Rp '.number_format($amount, 0, ',', '.');
    }
}
