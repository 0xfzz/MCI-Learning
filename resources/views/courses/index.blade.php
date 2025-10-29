@extends('layouts.app')

@section('title', 'Katalog Kursus - MCI Learning')

@section('content')
<div class="relative min-h-screen bg-gradient-to-b from-white via-gray-50 to-gray-100 dark:from-gray-900 dark:via-gray-950 dark:to-gray-900">
    <header class="border-b border-gray-200/60 dark:border-gray-800/80 bg-white/80 dark:bg-gray-900/80 backdrop-blur">
        <div class="max-w-7xl mx-auto px-6 lg:px-10 py-6 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="{{ asset('assets/logo/hijau.png') }}" alt="MCI Learning" class="h-10 w-auto dark:hidden">
                <img src="{{ asset('assets/logo/putih.png') }}" alt="MCI Learning" class="h-10 w-auto hidden dark:block">
                <span class="text-lg font-bold text-gray-900 dark:text-white">Katalog Kursus</span>
            </a>
            <nav class="hidden md:flex items-center gap-6 text-sm font-medium text-gray-600 dark:text-gray-300">
                <a href="{{ route('home') }}" class="hover:text-[#025f5a] transition">Beranda</a>
                <a href="{{ route('courses.index') }}" class="text-[#025f5a] dark:text-teal-300">Katalog Kursus</a>
                <a href="{{ route('blog.index') }}" class="hover:text-[#025f5a] transition">Blog</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="text-sm font-semibold px-4 py-2 rounded-full bg-[#025f5a] text-white hover:bg-[#014440] transition">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-semibold px-4 py-2 rounded-full border border-[#025f5a] text-[#025f5a] hover:bg-[#025f5a] hover:text-white transition">Masuk</a>
                @endauth
            </nav>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 lg:px-10 py-16">
        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6 mb-12">
            <div>
                <p class="text-sm uppercase tracking-[0.2em] text-gray-500 dark:text-gray-500 font-semibold">Temukan materi terbaik</p>
                <h1 class="text-4xl lg:text-5xl font-black text-gray-900 dark:text-gray-100 mt-3">Katalog Kursus MCI Learning</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-4 max-w-2xl">Jelajahi ratusan kursus premium dari mentor berpengalaman. Gunakan pencarian dan filter untuk menemukan kursus yang sesuai dengan kebutuhan Anda.</p>
            </div>
            <form method="GET" class="w-full lg:max-w-md">
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input
                        type="search"
                        @extends('layouts.dashboard')

                        @section('title', 'Katalog Kursus - MCI Learning')
                        @section('search-placeholder', 'Cari kursus di katalog...')

                        @section('content')
                        @php
                            $paginationLinks = $courses instanceof \Illuminate\Pagination\AbstractPaginator
                                ? $courses->links()
                                : null;
                        @endphp

                        <div class="space-y-10">
                            <div class="flex flex-col xl:flex-row xl:items-end xl:justify-between gap-6">
                                <div>
                                    <p class="text-sm uppercase tracking-[0.25em] text-gray-500 dark:text-gray-500 font-semibold">Temukan materi terbaik</p>
                                    <h1 class="text-3xl lg:text-4xl font-black text-gray-900 dark:text-gray-100 mt-3">Katalog Kursus MCI Learning</h1>
                                    <p class="text-gray-500 dark:text-gray-400 mt-4 max-w-2xl">Jelajahi kursus dari mentor berpengalaman. Gunakan pencarian dan filter untuk menemukan kelas yang cocok dengan kebutuhan Anda.</p>
                                </div>
                                <form method="GET" class="w-full xl:max-w-md">
                                    <div class="relative">
                                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500">
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                        </span>
                                        <input
                                            type="search"
                                            name="q"
                                            value="{{ $filters['search'] }}"
                                            placeholder="Cari judul atau topik kursus..."
                                            class="w-full pl-12 pr-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-[#025f5a]"
                                        >
                                    </div>
                                </form>
                            </div>

                            <div class="grid lg:grid-cols-[260px_1fr] gap-8">
                                <aside class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-3xl p-6 h-fit">
                                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-6">Filter</h2>

                                    <div class="mb-6">
                                        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Kategori</h3>
                                        <div class="flex flex-wrap gap-2">
                                            <a
                                                href="{{ route('courses.index', array_filter(['q' => $filters['search'], 'level' => $filters['level']], fn ($value) => $value !== null && $value !== '')) }}"
                                                class="px-3 py-1.5 rounded-full text-xs font-semibold border transition {{ $filters['category'] ? 'text-gray-500 border-gray-200 dark:text-gray-400 dark:border-gray-700' : 'text-white bg-[#025f5a] border-[#025f5a]' }}"
                                            >Semua</a>
                                            @foreach ($categories as $category)
                                                <a
                                                    href="{{ route('courses.index', array_filter(['q' => $filters['search'], 'category' => $category->slug, 'level' => $filters['level']], fn ($value) => $value !== null && $value !== '')) }}"
                                                    class="px-3 py-1.5 rounded-full text-xs font-semibold border transition {{ $filters['category'] === $category->slug ? 'text-white bg-[#025f5a] border-[#025f5a]' : 'text-gray-500 border-gray-200 hover:border-[#025f5a] dark:text-gray-400 dark:border-gray-700' }}"
                                                >{{ $category->name }}</a>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div>
                                        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Level</h3>
                                        <div class="flex flex-wrap gap-2">
                                            <a
                                                href="{{ route('courses.index', array_filter(['q' => $filters['search'], 'category' => $filters['category']], fn ($value) => $value !== null && $value !== '')) }}"
                                                class="px-3 py-1.5 rounded-full text-xs font-semibold border transition {{ $filters['level'] ? 'text-gray-500 border-gray-200 dark:text-gray-400 dark:border-gray-700' : 'text-white bg-[#025f5a] border-[#025f5a]' }}"
                                            >Semua</a>
                                            @foreach ($levelOptions as $levelKey => $levelLabel)
                                                <a
                                                    href="{{ route('courses.index', array_filter(['q' => $filters['search'], 'category' => $filters['category'], 'level' => $levelKey], fn ($value) => $value !== null && $value !== '')) }}"
                                                    class="px-3 py-1.5 rounded-full text-xs font-semibold border transition {{ $filters['level'] === $levelKey ? 'text-white bg-[#025f5a] border-[#025f5a]' : 'text-gray-500 border-gray-200 hover:border-[#025f5a] dark:text-gray-400 dark:border-gray-700' }}"
                                                >{{ $levelLabel }}</a>
                                            @endforeach
                                        </div>
                                    </div>
                                </aside>

                                <section>
                                    @if (count($courses) === 0)
                                        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-3xl p-12 text-center">
                                            <div class="w-16 h-16 mx-auto rounded-full bg-[#025f5a]/10 text-[#025f5a] flex items-center justify-center text-2xl mb-5">
                                                <i class="fa-solid fa-search"></i>
                                            </div>
                                            <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-3">Kursus tidak ditemukan</h2>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Coba ubah kata kunci pencarian atau pilih kategori dan level yang berbeda.</p>
                                        </div>
                                    @else
                                        <div class="grid sm:grid-cols-2 xl:grid-cols-3 gap-6">
                                            @foreach ($courses as $course)
                                                <a href="{{ route('courses.show', $course->course_id) }}" class="group bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-3xl overflow-hidden hover:border-[#025f5a] hover:shadow-2xl hover:-translate-y-1 transition">
                                                    <div class="relative h-48">
                                                        @if ($course->thumbnail)
                                                            <img src="{{ asset('storage/'.$course->thumbnail) }}" alt="{{ $course->title }}" class="w-full h-full object-cover">
                                                        @else
                                                            <div class="w-full h-full bg-gradient-to-br from-[#025f5a] to-teal-500 flex items-center justify-center text-white text-5xl font-black">
                                                                {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($course->title, 0, 1)) }}
                                                            </div>
                                                        @endif
                                                        @if ($course->is_paid)
                                                            <span class="absolute top-4 left-4 px-3 py-1 text-xs font-semibold rounded-full bg-white/90 text-[#025f5a]">Premium</span>
                                                        @else
                                                            <span class="absolute top-4 left-4 px-3 py-1 text-xs font-semibold rounded-full bg-white/90 text-emerald-600">Gratis</span>
                                                        @endif
                                                    </div>
                                                    <div class="p-6">
                                                        <div class="flex items-center gap-2 text-xs uppercase tracking-wider text-gray-400 mb-3">
                                                            <span>{{ $course->category->name ?? 'Tanpa Kategori' }}</span>
                                                            @if ($course->level)
                                                                <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                                                <span>{{ $levelOptions[$course->level] ?? ucfirst($course->level) }}</span>
                                                            @endif
                                                        </div>
                                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 group-hover:text-[#025f5a] transition">{{ $course->title }}</h3>
                                                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-3 leading-relaxed">{{ \Illuminate\Support\Str::limit($course->description, 110) }}</p>

                                                        <div class="mt-6 flex items-center justify-between text-sm text-gray-500 dark:text-gray-400">
                                                            <span><i class="fa-solid fa-layer-group mr-2 text-[#025f5a]"></i>{{ $course->lessons_count ?? 0 }} modul</span>
                                                            <span><i class="fa-solid fa-users mr-2 text-[#025f5a]"></i>{{ $course->students_count ?? 0 }} siswa</span>
                                                        </div>

                                                        <div class="mt-5 flex items-center justify-between">
                                                            <div class="text-lg font-bold text-[#025f5a] dark:text-teal-300">
                                                                {{ $course->is_paid ? 'Rp '.number_format($course->getEffectivePrice(), 0, ',', '.') : 'Gratis' }}
                                                            </div>
                                                            <span class="text-xs font-semibold px-3 py-1 rounded-full border border-[#025f5a]/30 text-[#025f5a]">Lihat Detail</span>
                                                        </div>
                                                    </div>
                                                </a>
                                            @endforeach
                                        </div>

                                        @if ($paginationLinks)
                                            <div class="mt-10">
                                                {{ $paginationLinks }}
                                            </div>
                                        @endif
                                    @endif
                                </section>
                            </div>
                        </div>
                        @endsection
