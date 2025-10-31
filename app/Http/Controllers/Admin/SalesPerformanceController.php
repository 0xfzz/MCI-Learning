<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SalesPerformanceController extends Controller
{
    /**
     * Display sales performance insights for admins.
     */
    public function index(Request $request)
    {
        $filters = $this->resolveFilters($request);

        $highlights = $this->buildHighlights($filters);
        $topCourses = $this->buildTopCourses($filters);
        $statusBreakdown = $this->buildStatusBreakdown($filters);
        $history = $this->buildSalesHistory($filters);

        return view('dashboard.admin.sales', compact(
            'highlights',
            'topCourses',
            'statusBreakdown',
            'history',
            'filters'
        ));
    }

    /**
     * Export sales data to CSV format.
     */
    public function export(Request $request): StreamedResponse
    {
        $filters = $this->resolveFilters($request);
        $type = $request->query('type', 'history');

        if ($type === 'top_courses') {
            $headers = ['Kursus', 'Instruktur', 'Terjual', 'Pendapatan'];
            $filename = 'laporan-top-kursus.csv';
            $rows = $this->buildTopCourses($filters, null)->map(function ($course) {
                return [
                    $course['course'],
                    $course['instructor'],
                    $course['sold'],
                    $course['revenue'],
                ];
            });
        } else {
            $headers = ['Invoice', 'Pengguna', 'Kursus', 'Jumlah', 'Tanggal', 'Status'];
            $filename = 'riwayat-penjualan.csv';
            $rows = $this->buildSalesHistory($filters, null)->map(function ($row) {
                return [
                    $row['invoice'],
                    $row['user'],
                    $row['course'],
                    $row['amount'],
                    $row['date'] ?? '-',
                    ucfirst($row['status']),
                ];
            });
        }

        return response()->streamDownload(function () use ($headers, $rows) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, $headers);

            foreach ($rows as $row) {
                fputcsv($handle, $row);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    private function resolveFilters(Request $request): array
    {
        $period = (int) $request->query('period', 30);
        $allowedPeriods = [7, 30, 90, 365];
        if (!in_array($period, $allowedPeriods, true)) {
            $period = 30;
        }

        $status = $request->query('status', 'all');
        $allowedStatus = ['all', 'success', 'pending', 'failed'];
        if (!in_array($status, $allowedStatus, true)) {
            $status = 'all';
        }

        $rangeEnd = now()->endOfDay();
        $rangeStart = $rangeEnd->copy()->subDays(max($period - 1, 0))->startOfDay();
        $previousRangeEnd = $rangeStart->copy()->subSecond();
        $previousRangeStart = $previousRangeEnd->copy()->subDays(max($period - 1, 0))->startOfDay();

        return [
            'period' => $period,
            'status' => $status,
            'range_start' => $rangeStart,
            'range_end' => $rangeEnd,
            'previous_range_start' => $previousRangeStart,
            'previous_range_end' => $previousRangeEnd,
        ];
    }

    private function buildHighlights(array $filters): array
    {
        $currentSuccess = Payment::success()
            ->whereBetween('created_at', [$filters['range_start'], $filters['range_end']]);
        $previousSuccess = Payment::success()
            ->whereBetween('created_at', [$filters['previous_range_start'], $filters['previous_range_end']]);

        $totalRevenue = (int) (clone $currentSuccess)->sum('amount');
        $revenueLastPeriod = (int) (clone $previousSuccess)->sum('amount');

        $ordersCurrent = (clone $currentSuccess)->count();
        $ordersLastPeriod = (clone $previousSuccess)->count();

        $averageCurrent = $ordersCurrent > 0 ? (int) round($totalRevenue / $ordersCurrent) : 0;
        $averageLast = $ordersLastPeriod > 0 ? (int) round($revenueLastPeriod / $ordersLastPeriod) : 0;

        return [
            [
                'label' => 'Total Pendapatan',
                'value' => $this->formatCurrency($totalRevenue),
                'delta' => $this->formatChange($totalRevenue, $revenueLastPeriod),
                'caption' => sprintf('periode %d hari terakhir', $filters['period']),
            ],
            [
                'label' => 'Kursus Terjual',
                'value' => $this->formatNumber($ordersCurrent).' paket',
                'delta' => $this->formatChange($ordersCurrent, $ordersLastPeriod),
                'caption' => sprintf('%d hari terakhir', $filters['period']),
            ],
            [
                'label' => 'Rata-rata Nilai Order',
                'value' => $this->formatCurrency($averageCurrent),
                'delta' => $this->formatChange($averageCurrent, $averageLast),
                'caption' => 'per transaksi',
            ],
        ];
    }

    private function buildTopCourses(array $filters, ?int $limit = 5): Collection
    {
        $query = Course::query()
            ->join('users', 'users.user_id', '=', 'courses.instructor_id')
            ->leftJoin('payments', function ($join) use ($filters) {
                $join->on('payments.course_id', '=', 'courses.course_id')
                    ->where('payments.status', '=', 'success')
                    ->whereBetween('payments.created_at', [$filters['range_start'], $filters['range_end']]);
            })
            ->select([
                'courses.course_id',
                'courses.title',
                DB::raw('COALESCE(users.name, users.username) as instructor_name'),
                DB::raw('COUNT(payments.payment_id) as total_sold'),
                DB::raw('COALESCE(SUM(payments.amount), 0) as total_revenue'),
            ])
            ->groupBy('courses.course_id', 'courses.title', 'instructor_name')
            ->orderByDesc('total_revenue');

        if (!is_null($limit)) {
            $query->limit($limit);
        }

        return $query->get()->map(function ($course) {
            return [
                'course' => $course->title,
                'instructor' => $course->instructor_name,
                'sold' => (int) $course->total_sold,
                'revenue' => $this->formatCurrency((int) $course->total_revenue),
            ];
        });
    }

    private function buildStatusBreakdown(array $filters): Collection
    {
        $totals = Payment::query()
            ->whereBetween('created_at', [$filters['range_start'], $filters['range_end']])
            ->selectRaw('status, COUNT(*) as total_orders, COALESCE(SUM(amount), 0) as total_amount')
            ->groupBy('status')
            ->get();

        $totalAmount = (int) $totals->sum('total_amount');
        $totalOrders = (int) $totals->sum('total_orders');
        $useAmountBasis = $totalAmount > 0;
        $denominator = $useAmountBasis ? $totalAmount : max(1, $totalOrders);

        return $totals->map(function ($row) use ($useAmountBasis, $denominator) {
            $basis = $useAmountBasis ? (int) $row->total_amount : (int) $row->total_orders;
            $percentage = $denominator > 0 ? (int) round(($basis / $denominator) * 100) : 0;
            $percentage = max(0, min(100, $percentage));

            return [
                'name' => ucfirst($row->status),
                'percentage' => $percentage,
                'revenue' => $this->formatCurrency((int) $row->total_amount),
            ];
        });
    }

    private function buildSalesHistory(array $filters, ?int $limit = 10): Collection
    {
        $query = Payment::query()
            ->with([
                'user:user_id,name,username',
                'course:course_id,title',
            ])
            ->whereBetween('created_at', [$filters['range_start'], $filters['range_end']])
            ->latest('created_at');

        if ($filters['status'] !== 'all') {
            $query->where('status', $filters['status']);
        }

        if (!is_null($limit)) {
            $query->limit($limit);
        }

        return $query->get()->map(function (Payment $payment) {
            return [
                'invoice' => sprintf('#PAY-%05d', $payment->payment_id),
                'user' => $payment->user?->name ?? $payment->user?->username ?? 'Pengguna',
                'course' => $payment->course?->title ?? 'Kursus tidak tersedia',
                'amount' => $this->formatCurrency((int) ($payment->amount ?? 0)),
                'date' => optional($payment->created_at)?->format('d M Y') ?? '-',
                'status' => $payment->status,
            ];
        });
    }

    private function formatCurrency(int $amount): string
    {
        return 'Rp '.number_format($amount, 0, ',', '.');
    }

    private function formatNumber(int $value): string
    {
        return number_format($value, 0, ',', '.');
    }

    private function formatChange(float $current, float $previous): string
    {
        if ($previous <= 0) {
            return $current > 0 ? '+100%' : '0%';
        }

        $change = (($current - $previous) / $previous) * 100;

        return sprintf('%s%.1f%%', $change >= 0 ? '+' : '-', abs($change));
    }
}
