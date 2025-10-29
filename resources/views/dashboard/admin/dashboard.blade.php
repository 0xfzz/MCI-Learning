@extends('layouts.dashboard')

@section('title', 'Admin Dashboard - MCI Learning')

@section('search-placeholder', 'Cari data atau pengguna...')

@section('content')
<div class="mb-10">
    <p class="text-sm uppercase tracking-widest text-gray-400 dark:text-gray-500 font-semibold">Panel Admin</p>
    <h1 class="text-3xl font-black text-gray-900 dark:text-gray-100">Ikhtisar Operasional</h1>
    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Pantau metrik inti platform untuk memastikan pengalaman belajar tetap lancar.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mb-10">
    @foreach ($summaryCards as $card)
        <div class="relative overflow-hidden rounded-3xl border border-gray-200 dark:border-gray-800 bg-white/95 dark:bg-gray-900/95 backdrop-blur shadow-[0_20px_45px_rgba(2,95,90,0.08)] hover:shadow-[0_25px_60px_rgba(2,95,90,0.12)] transition">
            <div class="absolute -top-14 -right-10 w-32 h-32 rounded-full opacity-10" style="background: {{ $card['gradient'] }}"></div>
            <div class="p-6 relative z-10">
                <div class="flex items-center gap-3 mb-6">
                    <span class="inline-flex items-center justify-center w-12 h-12 rounded-2xl text-white text-xl shadow-lg" style="background: {{ $card['gradient'] }}">
                        <i class="fa-solid {{ $card['icon'] }}"></i>
                    </span>
                    <div>
                        <p class="text-xs uppercase tracking-wide text-gray-400 dark:text-gray-500 font-semibold">{{ $card['label'] }}</p>
                        <p class="text-3xl font-black text-gray-900 dark:text-gray-100">{{ $card['value'] }}</p>
                    </div>
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $card['sub'] }}</p>
            </div>
        </div>
    @endforeach
</div>

<div class="space-y-10">
    <section class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-3xl p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">Penjualan Kursus</h2>
            <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                <i class="fa-solid fa-calendar"></i>
                30 hari terakhir
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-xs uppercase tracking-wide text-gray-400 dark:text-gray-500 border-b border-gray-100 dark:border-gray-800">
                        <th class="py-3 text-left">Kursus</th>
                        <th class="py-3 text-left">Instruktur</th>
                        <th class="py-3 text-right">Terjual</th>
                        <th class="py-3 text-right">Pendapatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse ($salesSummary as $row)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40 transition">
                            <td class="py-4 pr-4 font-semibold text-gray-900 dark:text-gray-100">{{ $row['course'] }}</td>
                            <td class="py-4 pr-4 text-gray-500 dark:text-gray-400">{{ $row['instructor'] }}</td>
                            <td class="py-4 pr-4 text-right font-semibold text-gray-900 dark:text-gray-100">{{ $row['sold'] }} paket</td>
                            <td class="py-4 text-right font-semibold text-teal-600 dark:text-teal-300">{{ $row['revenue'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-6 text-center text-sm text-gray-500 dark:text-gray-400">
                                Belum ada data penjualan untuk ditampilkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <section class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-3xl p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">Penjualan Perlu Diverifikasi</h2>
            <span class="text-xs font-semibold px-3 py-1 rounded-full bg-amber-500/10 text-amber-500">
                {{ count($pendingPayments) }} transaksi
            </span>
        </div>
        <div class="space-y-4">
            @forelse ($pendingPayments as $payment)
                <div class="p-4 rounded-2xl border border-gray-200 dark:border-gray-800 bg-gray-50/60 dark:bg-gray-800/40">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $payment['user'] }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $payment['course'] }}</p>
                            @if ($payment['needs_clarification'])
                                <span class="mt-2 inline-flex items-center gap-1 text-[11px] font-semibold text-amber-600">
                                    <i class="fa-solid fa-circle-exclamation"></i> Klarifikasi diminta
                                </span>
                            @endif
                        </div>
                        <p class="font-semibold text-teal-600 dark:text-teal-300">{{ $payment['amount'] }}</p>
                    </div>
                    <div class="mt-3 flex items-center justify-between text-xs text-gray-400 dark:text-gray-500">
                        <span>Diunggah {{ $payment['submitted_at'] }}</span>
                        <div class="flex gap-2">
                            <form method="POST" action="{{ route('dashboard.payments.verify', $payment['id']) }}">
                                @csrf
                                <button type="submit" class="px-3 py-1 rounded-lg text-white text-xs font-semibold [background:linear-gradient(135deg,#06b6d4,#025f5a)] hover:-translate-y-0.5 transition">
                                    Verifikasi
                                </button>
                            </form>
                            <form method="POST" action="{{ route('dashboard.payments.clarify', $payment['id']) }}">
                                @csrf
                                <button type="submit" class="px-3 py-1 rounded-lg border border-gray-300 dark:border-gray-700 text-xs font-semibold text-gray-600 dark:text-gray-300 hover:border-amber-400/60 hover:text-amber-500 transition">
                                    Butuh Klarifikasi
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-5 rounded-2xl border border-dashed border-gray-200 dark:border-gray-800 text-center text-sm text-gray-500 dark:text-gray-400">
                    Semua transaksi terbaru telah diverifikasi. Mantap!
                </div>
            @endforelse
        </div>
    </section>
</div>
@endsection
