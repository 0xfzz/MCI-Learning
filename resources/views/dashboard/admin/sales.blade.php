@extends('layouts.dashboard')

@section('title', 'Performa Penjualan - MCI Learning')

@section('search-placeholder', 'Cari kursus atau laporan penjualan...')

@section('content')
<div class="mb-10">
    <p class="text-sm uppercase tracking-widest text-gray-400 dark:text-gray-500 font-semibold">Panel Admin</p>
    <h1 class="text-3xl font-black text-gray-900 dark:text-gray-100">Performa Penjualan</h1>
    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Analisa tren pendapatan dan identifikasi kursus dengan performa terbaik.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
    @forelse ($highlights as $item)
        @php
            $deltaClass = str_starts_with($item['delta'], '-') ? 'text-rose-500' : (str_starts_with($item['delta'], '0') ? 'text-gray-400' : 'text-emerald-500');
        @endphp
        <div class="rounded-3xl border border-gray-200 dark:border-gray-800 bg-white/95 dark:bg-gray-900/95 backdrop-blur p-6 shadow-[0_20px_45px_rgba(2,95,90,0.08)]">
            <p class="text-xs uppercase tracking-wide text-gray-400 dark:text-gray-500 font-semibold mb-3">{{ $item['label'] }}</p>
            <p class="text-3xl font-black text-gray-900 dark:text-gray-100 mb-2">{{ $item['value'] }}</p>
            <p class="text-sm font-semibold {{ $deltaClass }}">{{ $item['delta'] }} <span class="text-gray-400 font-normal">{{ $item['caption'] }}</span></p>
        </div>
    @empty
        <div class="col-span-full rounded-3xl border border-dashed border-gray-200 dark:border-gray-800 p-6 text-center text-sm text-gray-500 dark:text-gray-400">
            Belum ada data penjualan.
        </div>
    @endforelse
</div>

<div class="grid grid-cols-1 xl:grid-cols-[2fr_1fr] gap-8">
    <section class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-3xl p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">Top 5 Kursus</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Daftar kursus dengan penjualan tertinggi bulan ini.</p>
            </div>
            <a href="{{ route('dashboard.sales.export', ['type' => 'top_courses', 'period' => $filters['period'] ?? 30, 'status' => $filters['status'] ?? 'all']) }}" class="text-sm font-semibold text-teal-600 dark:text-teal-300 hover:text-teal-500">Unduh CSV</a>
        </div>
        <div class="space-y-4">
            @forelse ($topCourses as $course)
                <div class="p-4 rounded-2xl border border-gray-200 dark:border-gray-800 bg-gray-50/60 dark:bg-gray-800/40 hover:border-teal-400/60 transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $course['course'] }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Instruktur: {{ $course['instructor'] }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $course['sold'] }} paket</p>
                            <p class="text-xs text-teal-600 dark:text-teal-300">{{ $course['revenue'] }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-500 dark:text-gray-400">Belum ada kursus dengan penjualan.</p>
            @endforelse
        </div>
    </section>

    <section class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-3xl p-6">
        <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-6">Status Pembayaran</h2>
        <div class="space-y-5 text-sm">
            @forelse ($statusBreakdown as $channel)
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <div>
                            <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $channel['name'] }}</p>
                            <span class="text-xs text-gray-400 dark:text-gray-500">{{ $channel['revenue'] }}</span>
                        </div>
                        <span class="font-semibold text-gray-600 dark:text-gray-300">{{ $channel['percentage'] }}%</span>
                    </div>
                    <div class="h-2 rounded-full bg-gray-200 dark:bg-gray-800 overflow-hidden">
                        <span class="block h-full rounded-full" style="width: {{ $channel['percentage'] }}%; background: linear-gradient(135deg,#06b6d4,#025f5a);"></span>
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-500 dark:text-gray-400">Belum ada transaksi tercatat.</p>
            @endforelse
        </div>
    </section>
</div>

<section class="mt-10 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-3xl p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">Riwayat Penjualan</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Pantau detail transaksi untuk audit dan pencocokan.</p>
        </div>
        @php
            $periodOptions = [7 => '7 hari', 30 => '30 hari', 90 => '90 hari', 365 => '1 tahun'];
            $statusOptions = ['all' => 'Semua Status', 'success' => 'Terverifikasi', 'pending' => 'Menunggu', 'failed' => 'Ditolak'];
        @endphp
        <div class="flex flex-wrap items-center gap-2">
            <form method="GET" action="{{ route('dashboard.sales.index') }}" class="flex items-center gap-2">
                <label for="period" class="sr-only">Periode</label>
                <select id="period" name="period" class="px-3 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm text-gray-600 dark:text-gray-300 focus:ring-2 focus:ring-teal-500 focus:outline-none">
                    @foreach ($periodOptions as $value => $label)
                        <option value="{{ $value }}" @selected(($filters['period'] ?? 30) == $value)>{{ $label }}</option>
                    @endforeach
                </select>

                <label for="status" class="sr-only">Status</label>
                <select id="status" name="status" class="px-3 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm text-gray-600 dark:text-gray-300 focus:ring-2 focus:ring-teal-500 focus:outline-none">
                    @foreach ($statusOptions as $value => $label)
                        <option value="{{ $value }}" @selected(($filters['status'] ?? 'all') === $value)>{{ $label }}</option>
                    @endforeach
                </select>

                <button type="submit" class="px-4 py-2 text-sm rounded-xl border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 hover:border-teal-400/60 transition">Filter</button>
            </form>

            <a href="{{ route('dashboard.sales.export', ['type' => 'history', 'period' => $filters['period'] ?? 30, 'status' => $filters['status'] ?? 'all']) }}" class="px-4 py-2 text-sm rounded-xl [background:linear-gradient(135deg,#06b6d4,#025f5a)] text-white shadow-[0_14px_35px_rgba(2,95,90,0.3)]">Ekspor</a>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-xs uppercase tracking-wide text-gray-400 dark:text-gray-500 border-b border-gray-100 dark:border-gray-800">
                    <th class="py-3 text-left">Invoice</th>
                    <th class="py-3 text-left">Pengguna</th>
                    <th class="py-3 text-left">Kursus</th>
                    <th class="py-3 text-right">Jumlah</th>
                    <th class="py-3 text-right">Tanggal</th>
                    <th class="py-3 text-right">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                @forelse ($history as $row)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40 transition">
                        <td class="py-4 pr-4 font-semibold text-gray-900 dark:text-gray-100">{{ $row['invoice'] }}</td>
                        <td class="py-4 pr-4 text-gray-500 dark:text-gray-400">{{ $row['user'] }}</td>
                        <td class="py-4 pr-4 text-gray-500 dark:text-gray-400">{{ $row['course'] }}</td>
                        <td class="py-4 pr-4 text-right font-semibold text-gray-900 dark:text-gray-100">{{ $row['amount'] }}</td>
                        <td class="py-4 text-right text-gray-500 dark:text-gray-400">{{ $row['date'] }}</td>
                        <td class="py-4 text-right text-gray-500 dark:text-gray-400">
                            @php
                                $statusLabels = ['success' => 'Terverifikasi', 'pending' => 'Menunggu', 'failed' => 'Ditolak'];
                            @endphp
                            {{ $statusLabels[$row['status']] ?? ucfirst($row['status']) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-6 text-center text-sm text-gray-500 dark:text-gray-400">Belum ada riwayat transaksi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection

