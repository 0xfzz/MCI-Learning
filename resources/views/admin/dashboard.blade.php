@extends('layouts.dashboard')

@section('title', 'Admin Dashboard - MCI Learning')

@section('search-placeholder', 'Cari data atau pengguna...')

@section('content')
<div class="flex items-center justify-between mb-10">
    <div>
        <p class="text-sm uppercase tracking-widest text-gray-400 dark:text-gray-500 font-semibold">Panel Admin</p>
        <h1 class="text-3xl font-black text-gray-900 dark:text-gray-100">Ringkasan Aktivitas Platform</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Pantau performa platform, kelola konten, dan tindak lanjuti kebutuhan pengguna.</p>
    </div>
    <div class="flex gap-3">
        <a href="#" class="flex items-center gap-2 px-4 py-2 rounded-xl border border-teal-500/40 text-teal-600 dark:text-teal-300 hover:bg-teal-50/80 dark:hover:bg-teal-500/10 transition">
            <i class="fa-solid fa-file-lines"></i>
            Laporan Bulanan
        </a>
        <a href="#" class="flex items-center gap-2 px-4 py-2 rounded-xl [background:linear-gradient(135deg,#06b6d4,#025f5a)] text-white shadow-[0_14px_35px_rgba(2,95,90,0.3)] hover:-translate-y-1 transition">
            <i class="fa-solid fa-plus"></i>
            Buat Konten
        </a>
    </div>
</div>

<!-- Overview Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-10">
    @php
        $overview = [
            ['title' => 'Pengguna Aktif', 'value' => '1.482', 'delta' => '+6.4%', 'icon' => 'fa-users', 'gradient' => 'linear-gradient(135deg,#14b8a6,#0d9488)'],
            ['title' => 'Penjualan Kursus', 'value' => 'Rp 78,4jt', 'delta' => '+12.1%', 'icon' => 'fa-coins', 'gradient' => 'linear-gradient(135deg,#6366f1,#4338ca)'],
            ['title' => 'Tugas Pending', 'value' => '24', 'delta' => '-8.3%', 'icon' => 'fa-clipboard-list', 'gradient' => 'linear-gradient(135deg,#f59e0b,#d97706)'],
            ['title' => 'Pelaporan', 'value' => '5', 'delta' => '+2', 'icon' => 'fa-flag', 'gradient' => 'linear-gradient(135deg,#ef4444,#b91c1c)'],
        ];
    @endphp
    @foreach ($overview as $card)
        <div class="relative overflow-hidden rounded-3xl border border-gray-200 dark:border-gray-800 bg-white/90 dark:bg-gray-900/90 backdrop-blur shadow-[0_20px_45px_rgba(2,95,90,0.08)] hover:shadow-[0_25px_60px_rgba(2,95,90,0.12)] transition">
            <div class="absolute -top-16 -right-12 w-40 h-40 rounded-full opacity-10" style="background: {{ $card['gradient'] }}"></div>
            <div class="p-6 relative z-10">
                <div class="flex items-center justify-between mb-8">
                    <span class="inline-flex items-center justify-center w-12 h-12 rounded-2xl text-white text-xl shadow-lg" style="background: {{ $card['gradient'] }}">
                        <i class="fa-solid {{ $card['icon'] }}"></i>
                    </span>
                    <span class="text-sm font-semibold {{ str_contains($card['delta'], '+') ? 'text-emerald-500' : 'text-rose-500' }}">{{ $card['delta'] }}</span>
                </div>
                <p class="text-sm uppercase tracking-wide text-gray-400 dark:text-gray-500 font-semibold">{{ $card['title'] }}</p>
                <p class="text-3xl font-black text-gray-900 dark:text-gray-100">{{ $card['value'] }}</p>
            </div>
        </div>
    @endforeach
</div>

<!-- Content & Users -->
<div class="grid grid-cols-1 xl:grid-cols-[2fr_1fr] gap-8 mb-10">
    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-3xl p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">Kursus Perlu Tinjauan</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Periksa konten sebelum dipublikasikan ke peserta.</p>
            </div>
            <a href="#" class="text-sm font-semibold text-teal-600 dark:text-teal-300 hover:text-teal-500">Lihat semua</a>
        </div>
        <div class="space-y-4">
            @php
                $pendingCourses = [
                    ['title' => 'Membangun REST API dengan Laravel', 'instructor' => 'Ayu Pratiwi', 'submitted' => '2 jam lalu', 'status' => 'Menunggu Review'],
                    ['title' => 'UI/UX Research Fundamentals', 'instructor' => 'Yoga Pranata', 'submitted' => '5 jam lalu', 'status' => 'Revisi Diminta'],
                    ['title' => 'Mastering Tailwind CSS v4', 'instructor' => 'Ricky Maulana', 'submitted' => 'Kemarin', 'status' => 'Menunggu Review'],
                ];
            @endphp
            @foreach ($pendingCourses as $course)
                <div class="p-5 rounded-2xl border border-gray-200 dark:border-gray-800 bg-gray-50/60 dark:bg-gray-800/40 hover:border-teal-400/60 transition">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:text-gray-100">{{ $course['title'] }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Instruktur: {{ $course['instructor'] }}</p>
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Diunggah {{ $course['submitted'] }}</p>
                        </div>
                        <span class="inline-flex items-center gap-2 px-3 py-1 text-xs font-semibold rounded-full
                            {{ $course['status'] === 'Revisi Diminta'
                                ? 'bg-rose-100/40 text-rose-500 dark:bg-rose-500/10 dark:text-rose-300'
                                : 'bg-teal-100/60 text-teal-600 dark:bg-teal-500/10 dark:text-teal-300' }}">
                            <i class="fa-solid fa-exclamation-circle"></i>
                            {{ $course['status'] }}
                        </span>
                    </div>
                    <div class="mt-4 flex items-center gap-3">
                        <button class="px-4 py-2 text-xs font-semibold rounded-lg text-white [background:linear-gradient(135deg,#06b6d4,#025f5a)] hover:-translate-y-0.5 transition">
                            Setujui
                        </button>
                        <button class="px-4 py-2 text-xs font-semibold rounded-lg border border-gray-300 dark:border-gray-700 text-gray-600 dark:text-gray-300 hover:border-teal-400/60 hover:text-teal-500 transition">
                            Minta Revisi
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-3xl p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">Aktivitas Pengguna</h2>
            <a href="#" class="text-sm font-semibold text-teal-600 dark:text-teal-300 hover:text-teal-500">Detail</a>
        </div>
        <div class="space-y-4">
            @php
                $activities = [
                    ['user' => 'Dewi Putri', 'action' => 'Mendaftar kursus "Laravel Advanced"', 'time' => '15 menit lalu'],
                    ['user' => 'Joko Santoso', 'action' => 'Meninggalkan ulasan baru', 'time' => '1 jam lalu'],
                    ['user' => 'Sari Lestari', 'action' => 'Mengupload bukti pembayaran', 'time' => '3 jam lalu'],
                    ['user' => 'Indra Wijaya', 'action' => 'Menyelesaikan course "Vue 3 Composition API"', 'time' => 'Kemarin'],
                ];
            @endphp
            @foreach ($activities as $activity)
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-2xl [background:linear-gradient(135deg,#06b6d4,#025f5a)] text-white flex items-center justify-center">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $activity['user'] }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $activity['action'] }}</p>
                        <span class="text-xs text-gray-400 dark:text-gray-500">{{ $activity['time'] }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- System Health & Tasks -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-3xl p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">Kesehatan Sistem</h2>
            <span class="text-xs inline-flex items-center gap-1 px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-500">
                <i class="fa-solid fa-circle-check"></i>
                Stabil
            </span>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            @php
                $health = [
                    ['label' => 'Response Time', 'value' => '182ms', 'icon' => 'fa-gauge-high'],
                    ['label' => 'Error Rate', 'value' => '0.24%', 'icon' => 'fa-triangle-exclamation'],
                    ['label' => 'Worker Queue', 'value' => '12 jobs', 'icon' => 'fa-list-check'],
                    ['label' => 'Server Load', 'value' => '63%', 'icon' => 'fa-server'],
                ];
            @endphp
            @foreach ($health as $item)
                <div class="p-4 rounded-2xl border border-gray-200 dark:border-gray-800 bg-gray-50/70 dark:bg-gray-800/40">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="inline-flex w-10 h-10 items-center justify-center rounded-xl text-white" style="background: linear-gradient(135deg,#06b6d4,#025f5a)">
                            <i class="fa-solid {{ $item['icon'] }}"></i>
                        </span>
                        <span class="text-xs uppercase font-semibold text-gray-400 dark:text-gray-500">{{ $item['label'] }}</span>
                    </div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $item['value'] }}</p>
                </div>
            @endforeach
        </div>
    </div>

    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-3xl p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">Tugas Tim</h2>
            <a href="#" class="text-sm font-semibold text-teal-600 dark:text-teal-300 hover:text-teal-500">Kelola</a>
        </div>
        <ul class="space-y-4">
            @php
                $tasks = [
                    ['title' => 'Review konten baru dari Yoga Pranata', 'progress' => 72],
                    ['title' => 'Balas tiket support prioritas', 'progress' => 38],
                    ['title' => 'Verifikasi data pembayaran manual', 'progress' => 54],
                    ['title' => 'Audit kualitas materi minggu ini', 'progress' => 10],
                ];
            @endphp
            @foreach ($tasks as $task)
                <li class="p-4 border border-gray-200 dark:border-gray-800 rounded-2xl bg-gray-50/60 dark:bg-gray-800/40">
                    <p class="text-sm font-semibold text-gray-900 dark:text-gray-100 mb-2">{{ $task['title'] }}</p>
                    <div class="h-2 rounded-full bg-gray-200 dark:bg-gray-700 overflow-hidden">
                        <span class="block h-full rounded-full" style="width: {{ $task['progress'] }}%; background: linear-gradient(135deg,#06b6d4,#025f5a);"></span>
                    </div>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-2">Progress {{ $task['progress'] }}%</p>
                </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection

@section('right-sidebar')
<aside class="p-6 space-y-6">
    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-3xl p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-bold text-gray-900 dark:text-gray-100">Antrian Moderasi</h3>
            <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-rose-500/10 text-rose-500">3 baru</span>
        </div>
        <ul class="space-y-3 text-sm text-gray-600 dark:text-gray-300">
            <li class="flex items-start gap-3">
                <span class="mt-1 text-rose-500"><i class="fa-solid fa-circle-exclamation"></i></span>
                <div>
                    <p>Forum diskusi "Laravel 11" dilaporkan oleh 4 pengguna.</p>
                    <span class="text-xs text-gray-400">5 menit lalu</span>
                </div>
            </li>
            <li class="flex items-start gap-3">
                <span class="mt-1 text-amber-500"><i class="fa-solid fa-circle-info"></i></span>
                <div>
                    <p>Permintaan upgrade role instruktur oleh <strong class="font-semibold">Budi Setia</strong>.</p>
                    <span class="text-xs text-gray-400">23 menit lalu</span>
                </div>
            </li>
            <li class="flex items-start gap-3">
                <span class="mt-1 text-teal-500"><i class="fa-solid fa-circle-check"></i></span>
                <div>
                    <p>Bukti pembayaran manual siap diverifikasi.</p>
                    <span class="text-xs text-gray-400">1 jam lalu</span>
                </div>
            </li>
        </ul>
    </div>

    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-3xl p-6">
        <h3 class="font-bold text-gray-900 dark:text-gray-100 mb-4">Agenda Hari Ini</h3>
        <ul class="space-y-3 text-sm text-gray-600 dark:text-gray-300">
            <li>
                <div class="flex items-center justify-between">
                    <span>Rapat strategi konten Q4</span>
                    <span class="text-xs text-gray-400">10.00 WIB</span>
                </div>
                <p class="text-xs text-gray-400">Meeting Room A · 60 menit</p>
            </li>
            <li>
                <div class="flex items-center justify-between">
                    <span>Sync tim support dan moderator</span>
                    <span class="text-xs text-gray-400">13.30 WIB</span>
                </div>
                <p class="text-xs text-gray-400">Google Meet · 45 menit</p>
            </li>
            <li>
                <div class="flex items-center justify-between">
                    <span>Review hasil survey kepuasan</span>
                    <span class="text-xs text-gray-400">16.00 WIB</span>
                </div>
                <p class="text-xs text-gray-400">Dashboard Insight · 30 menit</p>
            </li>
        </ul>
    </div>
</aside>
@endsection
