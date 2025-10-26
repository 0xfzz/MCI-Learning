@extends('layouts.dashboard')

@section('title', 'Verifikasi Transaksi - MCI Learning')

@section('search-placeholder', 'Cari transaksi atau invoice...')

@section('content')
<div class="mb-10">
    <p class="text-sm uppercase tracking-widest text-gray-400 dark:text-gray-500 font-semibold">Panel Admin</p>
    <h1 class="text-3xl font-black text-gray-900 dark:text-gray-100">Verifikasi Transaksi</h1>
    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Pastikan seluruh pembayaran terverifikasi tepat waktu untuk menjaga kepercayaan peserta.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
    @forelse ($summaryCards as $item)
        <div class="rounded-3xl border border-gray-200 dark:border-gray-800 bg-white/95 dark:bg-gray-900/95 backdrop-blur p-6">
            <p class="text-xs uppercase tracking-wide text-gray-400 dark:text-gray-500 font-semibold mb-3">{{ $item['label'] }}</p>
            @php
                $valueClass = $item['accent'] ?? 'text-gray-900 dark:text-gray-100';
            @endphp
            <p class="text-3xl font-black mb-2"><span class="{{ $valueClass }}">{{ $item['value'] }}</span></p>
        </div>
    @empty
        <div class="col-span-full rounded-3xl border border-dashed border-gray-200 dark:border-gray-800 p-6 text-center text-sm text-gray-500 dark:text-gray-400">
            Belum ada data verifikasi pembayaran.
        </div>
    @endforelse
</div>

<section class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-3xl p-6 mb-10">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">Antrian Verifikasi</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Tinjau bukti pembayaran dan selesaikan verifikasi.</p>
        </div>
        <div class="flex gap-2">
            <form method="GET" action="{{ route('admin.transactions') }}" class="flex items-center gap-2">
                <label for="status" class="sr-only">Status</label>
                <select id="status" name="status" class="px-3 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm text-gray-600 dark:text-gray-300 focus:ring-2 focus:ring-teal-500 focus:outline-none">
                    <option value="all" @selected(($filters['status'] ?? 'all') === 'all')>Semua Status</option>
                    <option value="pending" @selected(($filters['status'] ?? 'all') === 'pending')>Menunggu</option>
                    <option value="success" @selected(($filters['status'] ?? 'all') === 'success')>Terverifikasi</option>
                    <option value="failed" @selected(($filters['status'] ?? 'all') === 'failed')>Ditolak</option>
                    <option value="clarification" @selected(($filters['status'] ?? 'all') === 'clarification')>Perlu Klarifikasi</option>
                </select>
                <button type="submit" class="px-4 py-2 text-sm rounded-xl border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 hover:border-teal-400/60 transition">Filter</button>
            </form>
            <form method="POST" action="{{ route('admin.payments.bulk-complete') }}">
                @csrf
                <button type="submit" class="px-4 py-2 text-sm rounded-xl [background:linear-gradient(135deg,#06b6d4,#025f5a)] text-white shadow-[0_14px_35px_rgba(2,95,90,0.3)]">Tandai Selesai</button>
            </form>
        </div>
    </div>
    <div class="space-y-4">
        @forelse ($pendingTransactions as $transaction)
            <div class="p-4 rounded-2xl border border-gray-200 dark:border-gray-800 bg-gray-50/60 dark:bg-gray-800/40">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $transaction['invoice'] }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $transaction['user'] }} • {{ $transaction['course'] }}</p>
                        @if ($transaction['needs_clarification'])
                            <span class="mt-2 inline-flex items-center gap-1 text-[11px] font-semibold text-amber-600">
                                <i class="fa-solid fa-circle-exclamation"></i> Klarifikasi diminta
                            </span>
                        @endif
                    </div>
                    <p class="font-semibold text-teal-600 dark:text-teal-300">{{ $transaction['amount'] }}</p>
                </div>
                <div class="mt-3 flex items-center justify-between text-xs text-gray-400 dark:text-gray-500">
                    <span>Diunggah {{ $transaction['submitted'] }}</span>
                    <div class="flex gap-2">
                        <form method="POST" action="{{ route('admin.payments.verify', $transaction['id']) }}">
                            @csrf
                            <button type="submit" class="px-3 py-1 rounded-lg text-white font-semibold [background:linear-gradient(135deg,#06b6d4,#025f5a)]">Verifikasi</button>
                        </form>
                        <form method="POST" action="{{ route('admin.payments.clarify', $transaction['id']) }}">
                            @csrf
                            <button type="submit" class="px-3 py-1 rounded-lg border border-gray-300 dark:border-gray-700 text-gray-600 dark:text-gray-300 hover:border-amber-400/60 hover:text-amber-500 transition">Minta Klarifikasi</button>
                        </form>
                        <form method="POST" action="{{ route('admin.payments.reject', $transaction['id']) }}">
                            @csrf
                            <button type="submit" class="px-3 py-1 rounded-lg border border-gray-300 dark:border-gray-700 text-gray-600 dark:text-gray-300 hover:border-rose-400/60 hover:text-rose-500 transition">Tolak</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-sm text-gray-500 dark:text-gray-400">Tidak ada transaksi yang menunggu verifikasi.</p>
        @endforelse
    </div>
</section>

<section class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-3xl p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">Riwayat Verifikasi</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Catatan transaksi yang telah diproses.</p>
        </div>
    <a href="{{ route('admin.transactions', ['status' => 'all']) }}" class="text-sm font-semibold text-teal-600 dark:text-teal-300 hover:text-teal-500">Lihat semua</a>
    </div>
    @php
        $statusLabels = [
            'success' => 'Terverifikasi',
            'failed' => 'Ditolak',
            'pending' => 'Menunggu Verifikasi',
        ];
        $statusColors = [
            'success' => 'bg-emerald-500/10 text-emerald-500',
            'failed' => 'bg-rose-500/10 text-rose-500',
            'pending' => 'bg-amber-500/10 text-amber-500',
            'clarification' => 'bg-amber-500/10 text-amber-500',
        ];
    @endphp
    <div class="divide-y divide-gray-100 dark:divide-gray-800 text-sm">
        @forelse ($history as $row)
            <div class="py-4 flex items-center justify-between">
                <div>
                    <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $row['invoice'] }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $row['user'] }} • {{ $row['course'] }}</p>
                </div>
                <div class="flex items-center gap-4">
                    @php
                        $statusKey = $row['clarification_requested'] ? 'clarification' : $row['status'];
                        $statusLabel = $row['clarification_requested'] ? 'Klarifikasi Diminta' : ($statusLabels[$row['status']] ?? ucfirst($row['status']));
                        $statusClass = $statusColors[$statusKey] ?? 'bg-gray-200 text-gray-600';
                    @endphp
                    <span class="px-3 py-1 rounded-lg text-xs font-semibold {{ $statusClass }}">{{ $statusLabel }}</span>
                    <span class="text-xs text-gray-400 dark:text-gray-500">{{ $row['time'] }}</span>
                </div>
            </div>
        @empty
            <p class="py-6 text-center text-sm text-gray-500 dark:text-gray-400">Belum ada riwayat verifikasi.</p>
        @endforelse
    </div>
</section>
@endsection

@section('right-sidebar')
@endsection
