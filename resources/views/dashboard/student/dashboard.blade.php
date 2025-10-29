@extends('layouts.dashboard')

@section('title', 'Dashboard Siswa - MCI Learning')

@section('search-placeholder', 'Cari kursus atau materi...')

@section('content')
<div class="mb-10">
    <p class="text-sm uppercase tracking-widest text-gray-400 dark:text-gray-500 font-semibold">Selamat datang kembali</p>
    <h1 class="text-3xl font-black text-gray-900 dark:text-gray-100">Halo, {{ $student->name ?? $student->username }}</h1>
    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Lanjutkan perjalanan belajar Anda dan capai tujuan baru hari ini.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-10">
    <x-student.dashboard-metric label="Total Kursus" :value="$metrics['total_courses']" icon="fa-solid fa-layer-group" color="bg-[#025f5a]" />
    <x-student.dashboard-metric label="Sedang Dipelajari" :value="$metrics['active_courses']" icon="fa-solid fa-rocket" color="bg-indigo-600" />
    <x-student.dashboard-metric label="Selesai" :value="$metrics['completed_courses']" icon="fa-solid fa-flag-checkered" color="bg-emerald-600" />
    <x-student.dashboard-metric label="Total Investasi" :value="'Rp ' . number_format($metrics['total_spent'], 0, ',', '.')" icon="fa-solid fa-wallet" color="bg-amber-500" />
</div>

<div class="grid grid-cols-1 xl:grid-cols-[2fr_1fr] gap-8">
    <section class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-3xl p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">Kursus Aktif</h2>
            <a href="#" class="text-sm font-semibold text-teal-600 dark:text-teal-300 hover:text-teal-500">Lihat Semua</a>
        </div>
        <div class="space-y-4">
            @forelse ($activeEnrollments as $enrollment)
                <article class="p-4 rounded-2xl border border-gray-200 dark:border-gray-800 hover:border-teal-500/60 transition">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $enrollment->course->title }}</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Instruktur: {{ $enrollment->course->instructor->name ?? $enrollment->course->instructor->username }}</p>
                        </div>
                        <span class="text-xs font-semibold px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-600">Aktif</span>
                    </div>
                    <div class="mt-4">
                        @php
                            $progress = $enrollment->progressPercentage();
                        @endphp
                        <div class="flex items-center justify-between text-xs text-gray-400 dark:text-gray-500 mb-1">
                            <span>{{ $progress }}% selesai</span>
                        </div>
                        <div class="h-2 rounded-full bg-gray-200 dark:bg-gray-800 overflow-hidden">
                            <span class="block h-full rounded-full bg-gradient-to-r from-[#025f5a] to-[#04b5a5]" style="width: {{ $progress }}%"></span>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('dashboard.my-courses.learn', $enrollment->course->course_id) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-[#025f5a] dark:text-teal-300 hover:text-[#024842] dark:hover:text-teal-400 transition">
                            <span>Lanjutkan Belajar</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </article>
            @empty
                <p class="text-sm text-gray-500 dark:text-gray-400 text-center py-6">Belum ada kursus aktif. Mulai belajar dengan mendaftar kursus.</p>
            @endforelse
        </div>
    </section>

    <aside class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-3xl p-6">
        <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-6">Kursus Rekomendasi</h2>
        <div class="space-y-4">
            @forelse ($recommendedCourses as $course)
                <div class="rounded-2xl border border-gray-200 dark:border-gray-800 p-4">
                    <h3 class="font-semibold text-gray-900 dark:text-gray-100">{{ $course->title }}</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Instruktur: {{ $course->instructor->name ?? $course->instructor->username }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-3">{{ \Illuminate\Support\Str::limit($course->description, 80) }}</p>
                    <div class="mt-4 flex items-center justify-between">
                        <span class="text-sm font-semibold text-teal-600 dark:text-teal-300">
                            {{ $course->is_paid ? 'Rp ' . number_format($course->getEffectivePrice(), 0, ',', '.') : 'Gratis' }}
                        </span>
                        <form method="POST" action="{{ route('dashboard.my-courses.enroll', $course) }}" class="flex items-center gap-2">
                            @csrf
                            <input type="hidden" name="payment_method" value="{{ $course->is_paid ? 'manual-transfer' : 'free' }}">
                            <button type="submit" class="px-3 py-1.5 text-xs rounded-xl bg-[#025f5a] text-white font-semibold hover:bg-[#014440] transition">
                                {{ $course->is_paid ? 'Ajukan Pembayaran' : 'Mulai Belajar' }}
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-500 dark:text-gray-400">Semua kursus sudah diikuti. Nantikan kursus baru segera!</p>
            @endforelse
        </div>

        @if ($pendingPayments->isNotEmpty())
            <div class="mt-8 pt-6 border-t border-dashed border-gray-200 dark:border-gray-800">
                <h2 class="text-sm font-semibold text-gray-900 dark:text-gray-100 mb-4">Pembayaran Menunggu Verifikasi</h2>
                <div class="space-y-3">
                    @foreach ($pendingPayments as $payment)
                        <div class="rounded-2xl border border-gray-200 dark:border-gray-800 p-4 bg-teal-50/50 dark:bg-teal-500/10">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $payment->course->title ?? 'Kursus tidak tersedia' }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Nominal: Rp {{ number_format($payment->amount ?? 0, 0, ',', '.') }}</p>
                                </div>
                                @if ($payment->clarification_requested_at)
                                    <span class="text-xs font-semibold px-3 py-1 rounded-full bg-rose-500/10 text-rose-600">Perlu Klarifikasi</span>
                                @else
                                    <span class="text-xs font-semibold px-3 py-1 rounded-full bg-amber-500/10 text-amber-600">Menunggu</span>
                                @endif
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-3">
                                Diajukan {{ optional($payment->created_at)->diffForHumans() ?? '-' }}.
                                @if ($payment->clarification_requested_at)
                                    Mohon unggah ulang bukti transfer sesuai arahan admin.
                                @else
                                    Silakan unggah bukti transfer jika belum dilakukan.
                                @endif
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </aside>
</div>

@if ($completedEnrollments->isNotEmpty())
    <section class="mt-10 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-3xl p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">Riwayat Kursus Selesai</h2>
            <a href="#" class="text-sm font-semibold text-teal-600 dark:text-teal-300 hover:text-teal-500">Unduh Sertifikat</a>
        </div>
        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            @foreach ($completedEnrollments as $enrollment)
                <div class="rounded-2xl border border-gray-200 dark:border-gray-800 p-4">
                    <h3 class="font-semibold text-gray-900 dark:text-gray-100">{{ $enrollment->course->title }}</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Selesai pada {{ optional($enrollment->completed_at)->format('d M Y') }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Instruktur: {{ $enrollment->course->instructor->name ?? $enrollment->course->instructor->username }}</p>
                    <span class="mt-4 inline-flex items-center gap-2 text-xs font-semibold text-emerald-600">
                        <i class="fa-solid fa-badge-check"></i>
                        Sertifikat tersedia
                    </span>
                </div>
            @endforeach
        </div>
    </section>
@endif
@endsection
