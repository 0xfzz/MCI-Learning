@extends('layouts.dashboard')

@section('title', 'Moderasi Ulasan - MCI Learning')

@section('search-placeholder', 'Cari ulasan mahasiswa...')

@section('content')
<div class="mb-10">
    <p class="text-sm uppercase tracking-widest text-gray-400 dark:text-gray-500 font-semibold">Panel Admin</p>
    <h1 class="text-3xl font-black text-gray-900 dark:text-gray-100">Moderasi Ulasan Kursus</h1>
    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Tinjau testimoni mahasiswa sebelum ditampilkan ke publik.</p>
</div>

@php
    $statusCards = [
        'all' => [
            'label' => 'Total Ulasan',
            'value' => number_format($stats['all'] ?? 0),
            'accent' => 'from-teal-500 to-emerald-500',
        ],
        'pending' => [
            'label' => 'Menunggu Tinjauan',
            'value' => number_format($stats['pending'] ?? 0),
            'accent' => 'from-amber-500 to-orange-500',
        ],
        'approved' => [
            'label' => 'Sudah Disetujui',
            'value' => number_format($stats['approved'] ?? 0),
            'accent' => 'from-emerald-500 to-teal-500',
        ],
        'rejected' => [
            'label' => 'Ditolak',
            'value' => number_format($stats['rejected'] ?? 0),
            'accent' => 'from-rose-500 to-red-500',
        ],
    ];
@endphp

<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-10">
    @foreach ($statusCards as $key => $card)
        <div class="relative overflow-hidden rounded-3xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 shadow-[0_18px_35px_rgba(2,95,90,0.06)]">
            <div class="absolute -top-10 -right-12 w-28 h-28 rounded-full opacity-20 bg-gradient-to-br {{ $card['accent'] }}"></div>
            <div class="p-6 relative z-10">
                <p class="text-xs uppercase tracking-wide text-gray-400 dark:text-gray-500 font-semibold">{{ $card['label'] }}</p>
                <p class="text-3xl font-black text-gray-900 dark:text-gray-100 mt-2">{{ $card['value'] }}</p>
            </div>
        </div>
    @endforeach
</div>

<div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-3xl p-6">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">Daftar Ulasan Mahasiswa</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Setujui hanya ulasan berkualitas untuk menjaga kredibilitas.</p>
        </div>
        @php
            $filterOptions = [
                'all' => 'Semua',
                'pending' => 'Pending',
                'approved' => 'Approved',
                'rejected' => 'Rejected',
            ];
        @endphp
        <div class="flex flex-wrap items-center gap-2">
            @foreach ($filterOptions as $value => $label)
                @php
                    $isActive = $statusFilter === $value;
                @endphp
                <a
                    href="{{ route('dashboard.reviews.index', ['status' => $value]) }}"
                    class="px-4 py-2 text-sm rounded-xl border {{ $isActive ? 'border-[#025f5a] bg-[#025f5a] text-white' : 'border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 hover:border-[#025f5a]/40' }} transition"
                >
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </div>

    @if (session('status'))
        <div class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 rounded-2xl px-4 py-3 mb-6">
            <i class="fa-solid fa-circle-check mr-2"></i>{{ session('status') }}
        </div>
    @endif

    <div class="space-y-5">
        @forelse ($reviews as $review)
            @php
                $statusBadge = [
                    'pending' => 'bg-amber-500/10 text-amber-500',
                    'approved' => 'bg-emerald-500/10 text-emerald-500',
                    'rejected' => 'bg-rose-500/10 text-rose-500',
                ][$review->status] ?? 'bg-gray-200 text-gray-500';
            @endphp
            <div class="border border-gray-200 dark:border-gray-800 rounded-2xl p-5 bg-white/70 dark:bg-gray-900/70">
                <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <div>
                                <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $review->user->name ?? $review->user->username ?? 'Mahasiswa' }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ optional($review->created_at)->format('d M Y') }} · {{ $review->course->title ?? 'Kursus tidak tersedia' }}</p>
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusBadge }} capitalize">{{ $review->status }}</span>
                        </div>
                        <div class="flex items-center gap-1 mb-3">
                            @for ($star = 1; $star <= 5; $star++)
                                <i class="fa-solid fa-star text-sm {{ $review->rating >= $star ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}"></i>
                            @endfor
                        </div>
                        <p class="text-sm text-gray-700 dark:text-gray-200 whitespace-pre-line">{{ $review->comment }}</p>
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 space-y-1">
                        <p>Diserahkan: {{ optional($review->created_at)->format('d M Y, H:i') }}</p>
                        @if($review->approved_at)
                            <p>Disetujui: {{ $review->approved_at->format('d M Y, H:i') }}</p>
                        @endif
                        @if($review->approvedBy)
                            <p>Oleh: {{ $review->approvedBy->name ?? $review->approvedBy->username }}</p>
                        @endif
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-3 mt-5">
                    @if($review->status !== 'approved')
                        <form method="POST" action="{{ route('dashboard.reviews.approve', $review) }}">
                            @csrf
                            <button type="submit" class="px-4 py-2 text-xs font-semibold rounded-xl bg-emerald-500 text-white hover:bg-emerald-600 transition">
                                <i class="fa-solid fa-check mr-2"></i>Setujui
                            </button>
                        </form>
                    @endif
                    @if($review->status !== 'rejected')
                        <form method="POST" action="{{ route('dashboard.reviews.reject', $review) }}" onsubmit="return confirm('Tolak ulasan ini?');">
                            @csrf
                            <button type="submit" class="px-4 py-2 text-xs font-semibold rounded-xl border border-rose-400 text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-900/20 transition">
                                <i class="fa-solid fa-xmark mr-2"></i>Tolak
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <div class="border border-dashed border-gray-200 dark:border-gray-800 rounded-2xl p-8 text-center text-sm text-gray-500 dark:text-gray-400">
                Belum ada ulasan pada kategori ini.
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $reviews->onEachSide(1)->links() }}
    </div>
</div>
@endsection
