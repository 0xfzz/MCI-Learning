<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class TransactionVerificationController extends Controller
{
    /**
     * Show the list of transactions awaiting verification.
     */
    public function index(Request $request)
    {
        $filters = $this->resolveFilters($request);

        $summaryCards = $this->buildSummaryCards();
        $pendingTransactions = $this->buildPendingTransactions();
        $history = $this->buildHistory($filters);

        return view('dashboard.admin.transactions', compact(
            'summaryCards',
            'pendingTransactions',
            'history',
            'filters'
        ));
    }

    private function buildSummaryCards(): array
    {
        $pendingCount = Payment::pending()->count();
        $verifiedCount = Payment::success()->count();
        $needsClarification = Payment::needsClarification()->count();

        return [
            [
                'label' => 'Menunggu Verifikasi',
                'value' => $this->formatNumber($pendingCount).' transaksi',
                'accent' => 'text-amber-500',
                'bg' => 'bg-amber-500/10',
            ],
            [
                'label' => 'Telah Diverifikasi',
                'value' => $this->formatNumber($verifiedCount).' transaksi',
                'accent' => 'text-emerald-500',
                'bg' => 'bg-emerald-500/10',
            ],
            [
                'label' => 'Perlu Klarifikasi',
                'value' => $this->formatNumber($needsClarification).' transaksi',
                'accent' => 'text-rose-500',
                'bg' => 'bg-rose-500/10',
            ],
        ];
    }

    private function buildPendingTransactions(): Collection
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
                    'invoice' => sprintf('#PAY-%05d', $payment->payment_id),
                    'user' => $payment->user?->name ?? $payment->user?->username ?? 'Pengguna',
                    'course' => $payment->course?->title ?? 'Kursus tidak tersedia',
                    'amount' => $this->formatCurrency((int) ($payment->amount ?? 0)),
                    'submitted' => optional($payment->created_at)?->diffForHumans() ?? '-',
                    'needs_clarification' => (bool) $payment->clarification_requested_at,
                    'bukti_transfer' => $payment->bukti_transfer,
                    'payment_method' => $payment->payment_method,
                ];
            });
    }

    private function buildHistory(array $filters): Collection
    {
        $query = Payment::query()->latest('created_at');

        if ($filters['status'] === 'clarification') {
            $query->needsClarification();
        } elseif ($filters['status'] !== 'all') {
            $query->where('status', $filters['status']);
        }

        return $query
            ->with([
                'user:user_id,name,username',
                'course:course_id,title',
            ])
            ->limit(8)
            ->get()
            ->map(function (Payment $payment) {
                return [
                    'id' => $payment->payment_id,
                    'invoice' => sprintf('#PAY-%05d', $payment->payment_id),
                    'user' => $payment->user?->name ?? $payment->user?->username ?? 'Pengguna',
                    'course' => $payment->course?->title ?? 'Kursus tidak tersedia',
                    'status' => $payment->status,
                    'time' => optional($payment->created_at)?->diffForHumans() ?? '-',
                    'clarification_requested' => (bool) $payment->clarification_requested_at,
                    'bukti_transfer' => $payment->bukti_transfer,
                    'payment_method' => $payment->payment_method,
                ];
            });
    }

    private function resolveFilters(Request $request): array
    {
        $status = $request->query('status', 'all');
        $allowed = ['all', 'pending', 'success', 'failed', 'clarification'];
        if (!in_array($status, $allowed, true)) {
            $status = 'all';
        }

        return [
            'status' => $status,
        ];
    }

    private function formatNumber(int $value): string
    {
        return number_format($value, 0, ',', '.');
    }

    private function formatCurrency(int $amount): string
    {
        return 'Rp '.number_format($amount, 0, ',', '.');
    }
}
