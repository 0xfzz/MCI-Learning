@extends('layouts.app')

@section('title', 'Katalog Kursus - MCI Learning')

@section('content')
<!-- Navbar -->
<nav id="navbar" class="fixed top-0 w-full z-50 transition-all duration-300 backdrop-blur-lg border-b [border-color:rgba(2,95,90,0.12)] dark:border-white/10">
    <div class="max-w-7xl mx-auto px-8 py-6 flex items-center justify-between">
        <a href="{{ route('home') }}" class="flex items-center gap-3 cursor-pointer">
            <img src="{{ asset('assets/logo/putih.png') }}" alt="MCI (Majelis Coding Indonesia)" class="h-12 w-auto dark:block hidden">
            <img src="{{ asset('assets/logo/hijau.png') }}" alt="MCI (Majelis Coding Indonesia)" class="h-12 w-auto dark:hidden block">
        </a>

        <div class="hidden md:flex items-center gap-12">
            <a href="{{ route('home') }}" class="text-gray-700 dark:text-gray-300 hover:[color:#025f5a] transition font-medium">Home</a>
            <a href="{{ route('courses.index') }}" class="[color:#025f5a] dark:text-teal-300 transition font-bold">Courses</a>
            <a href="{{ route('blog.index') }}" class="text-gray-700 dark:text-gray-300 hover:[color:#025f5a] transition font-medium">Blog</a>
            <button data-theme-toggle class="w-10 h-10 flex items-center justify-center rounded-full [background:rgba(255,255,255,0.08)] [border:1px_solid_rgba(255,255,255,0.12)] text-gray-300 hover:text-white transition">
                <i class="fa-solid fa-moon block dark:hidden"></i>
                <i class="fa-solid fa-sun hidden dark:block"></i>
            </button>
            @auth
                <a href="{{ route('dashboard.index') }}" class="px-8 py-3.5 [background:linear-gradient(135deg,#06b6d4_0%,#4f46e5_50%,#025f5a_100%)] rounded-full text-white font-semibold shadow-[0_10px_30px_rgba(20,184,166,0.3)] hover:shadow-[0_15px_40px_rgba(20,184,166,0.5)] transition-all hover:-translate-y-1">
                    Dashboard
                </a>
            @else
                <a href="{{ route('register') }}" class="px-8 py-3.5 [background:linear-gradient(135deg,#06b6d4_0%,#4f46e5_50%,#025f5a_100%)] rounded-full text-white font-semibold shadow-[0_10px_30px_rgba(20,184,166,0.3)] hover:shadow-[0_15px_40px_rgba(20,184,166,0.5)] transition-all hover:-translate-y-1">
                    Daftar Gratis
                </a>
            @endauth
        </div>

        <div class="md:hidden flex items-center gap-3">
            <button data-theme-toggle class="w-9 h-9 flex items-center justify-center rounded-full [background:rgba(0,0,0,0.06)] dark:[background:rgba(255,255,255,0.08)] [border:1px_solid_rgba(0,0,0,0.08)] dark:[border:1px_solid_rgba(255,255,255,0.12)] text-gray-700 dark:text-gray-300">
                <i class="fa-solid fa-moon block dark:hidden"></i>
                <i class="fa-solid fa-sun hidden dark:block"></i>
            </button>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="relative pt-40 pb-20 px-8 overflow-hidden [background:linear-gradient(135deg,#f8fafc_0%,#eef2ff_100%)] dark:[background:linear-gradient(135deg,#1e1e28_0%,#0a0a0f_100%)]">
    <!-- Background decorations -->
    <div class="absolute w-[600px] h-[600px] [background:radial-gradient(circle,rgba(2,95,90,0.15)_0%,transparent_70%)] rounded-full -top-64 -right-64 animate-pulse"></div>
    <div class="absolute w-[500px] h-[500px] [background:radial-gradient(circle,rgba(6,182,212,0.12)_0%,transparent_70%)] rounded-full -bottom-48 -left-48 animate-pulse [animation-delay:3s]"></div>

    <div class="max-w-7xl mx-auto relative z-10">
        <div class="text-center max-w-3xl mx-auto mb-12">
            <div class="inline-flex items-center gap-2 px-6 py-2.5 [background:rgba(2,95,90,0.1)] dark:[background:rgba(2,95,90,0.1)] [border:1.5px_solid_rgba(2,95,90,0.3)] rounded-full dark:[color:#5eead4] [color:#025f5a] text-sm font-semibold mb-6">
                <span><i class="fa-solid fa-book"></i></span>
                <span>Katalog Kursus Terlengkap</span>
            </div>
            <h1 class="text-5xl lg:text-6xl font-black mb-6 [color:#025f5a] dark:text-white">Temukan Kursus Impianmu</h1>
            <p class="text-xl [color:#b4b4b4] leading-relaxed mb-8">
                Jelajahi ratusan kursus premium dari mentor berpengalaman. Gunakan pencarian dan filter untuk menemukan kursus yang sesuai dengan kebutuhan Anda.
            </p>
        </div>

        <!-- Search Bar -->
        <form method="GET" class="max-w-2xl mx-auto mb-8">
            <div class="relative">
                <span class="absolute left-6 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500 text-xl">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
                <input
                    type="search"
                    name="q"
                    value="{{ $filters['search'] }}"
                    placeholder="Cari judul atau topik kursus..."
                    class="w-full pl-16 pr-6 py-5 rounded-full border-2 border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-[#025f5a] focus:border-[#025f5a] shadow-[0_10px_40px_rgba(20,184,166,0.1)] text-lg"
                >
            </div>
        </form>
    </div>
</section>

<!-- Courses Section -->
<section class="py-20 px-8 bg-white dark:[background:#0a0a0f]">
    <div class="max-w-7xl mx-auto">

<!-- Courses Section -->
<section class="py-20 px-8 bg-white dark:[background:#0a0a0f]">
    <div class="max-w-7xl mx-auto">
        <div class="grid lg:grid-cols-[320px_1fr] gap-8">
            <!-- Sidebar Filters -->
            <aside class="dark:[background:rgba(30,30,40,0.5)] rounded-3xl p-8 [border:2px_solid_rgba(255,255,255,0.05)] hover:[border-color:rgba(2,95,90,0.3)] shadow-[0_10px_40px_rgba(20,184,166,0.12)] h-fit sticky top-24">
                <h2 class="text-2xl font-bold [color:#025f5a] dark:text-white mb-8 flex items-center gap-2">
                    <i class="fa-solid fa-filter"></i>
                    <span>Filter</span>
                </h2>

                <!-- Category Filter -->
                <div class="mb-8">
                    <h3 class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-4">Kategori</h3>
                    <div class="flex flex-col gap-2">
                        <a
                            href="{{ route('courses.index', array_filter(['q' => $filters['search'], 'level' => $filters['level']], fn ($value) => $value !== null && $value !== '')) }}"
                            class="px-4 py-2.5 rounded-xl text-sm font-semibold transition {{ $filters['category'] ? 'text-gray-600 dark:text-gray-400 hover:[background:rgba(2,95,90,0.1)]' : 'text-white [background:linear-gradient(135deg,#06b6d4,#025f5a)] shadow-[0_4px_15px_rgba(20,184,166,0.3)]' }}"
                        >
                            <i class="fa-solid fa-th mr-2"></i>Semua Kategori
                        </a>
                        @foreach ($categories as $category)
                            <a
                                href="{{ route('courses.index', array_filter(['q' => $filters['search'], 'category' => $category->slug, 'level' => $filters['level']], fn ($value) => $value !== null && $value !== '')) }}"
                                class="px-4 py-2.5 rounded-xl text-sm font-semibold transition {{ $filters['category'] === $category->slug ? 'text-white [background:linear-gradient(135deg,#06b6d4,#025f5a)] shadow-[0_4px_15px_rgba(20,184,166,0.3)]' : 'text-gray-600 dark:text-gray-400 hover:[background:rgba(2,95,90,0.1)]' }}"
                            >
                                <i class="fa-solid fa-folder mr-2"></i>{{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Level Filter -->
                <div>
                    <h3 class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-4">Level</h3>
                    <div class="flex flex-col gap-2">
                        <a
                            href="{{ route('courses.index', array_filter(['q' => $filters['search'], 'category' => $filters['category']], fn ($value) => $value !== null && $value !== '')) }}"
                            class="px-4 py-2.5 rounded-xl text-sm font-semibold transition {{ $filters['level'] ? 'text-gray-600 dark:text-gray-400 hover:[background:rgba(2,95,90,0.1)]' : 'text-white [background:linear-gradient(135deg,#06b6d4,#025f5a)] shadow-[0_4px_15px_rgba(20,184,166,0.3)]' }}"
                        >
                            <i class="fa-solid fa-signal mr-2"></i>Semua Level
                        </a>
                        @foreach ($levelOptions as $levelKey => $levelLabel)
                            <a
                                href="{{ route('courses.index', array_filter(['q' => $filters['search'], 'category' => $filters['category'], 'level' => $levelKey], fn ($value) => $value !== null && $value !== '')) }}"
                                class="px-4 py-2.5 rounded-xl text-sm font-semibold transition {{ $filters['level'] === $levelKey ? 'text-white [background:linear-gradient(135deg,#06b6d4,#025f5a)] shadow-[0_4px_15px_rgba(20,184,166,0.3)]' : 'text-gray-600 dark:text-gray-400 hover:[background:rgba(2,95,90,0.1)]' }}"
                            >
                                <i class="fa-solid fa-chart-line mr-2"></i>{{ $levelLabel }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </aside>

            <!-- Courses Grid -->
            <section>
                @if (count($courses) === 0)
                    <div class="dark:[background:rgba(30,30,40,0.5)] rounded-3xl p-16 text-center [border:2px_solid_rgba(255,255,255,0.05)]">
                        <div class="w-24 h-24 mx-auto rounded-full [background:rgba(2,95,90,0.1)] text-[#025f5a] flex items-center justify-center text-4xl mb-6">
                            <i class="fa-solid fa-search"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">Kursus tidak ditemukan</h2>
                        <p class="text-lg [color:#b4b4b4]">Coba ubah kata kunci pencarian atau pilih kategori dan level yang berbeda.</p>
                    </div>
                @else
                    <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-6">
                        @php
                            $gradients = [
                                'linear-gradient(135deg,#14b8a6,#06b6d4)',
                                'linear-gradient(135deg,#a855f7,#f43f5e)',
                                'linear-gradient(135deg,#4f46e5,#06b6d4)',
                                'linear-gradient(135deg,#10b981,#14b8a6)',
                                'linear-gradient(135deg,#f59e0b,#f97316)',
                                'linear-gradient(135deg,#06b6d4,#025f5a)',
                            ];
                        @endphp

                        @foreach ($courses as $index => $course)
                            @php
                                $gradient = $gradients[$index % count($gradients)];
                            @endphp
                            <div class="group [background:rgba(30,30,40,0.6)] rounded-3xl overflow-hidden [border:2px_solid_rgba(255,255,255,0.08)] hover:[border-color:rgba(2,95,90,0.4)] shadow-[0_10px_40px_rgba(20,184,166,0.15)] hover:shadow-[0_25px_50px_rgba(20,184,166,0.3)] transition-all duration-300 hover:-translate-y-3 cursor-pointer">
                                <div class="relative h-48">
                                    @if ($course->thumbnail)
                                        <img src="{{ asset('storage/'.$course->thumbnail) }}" alt="{{ $course->title }}" class="w-full h-full object-cover">
                                        <div class="absolute inset-0" style="background: {{ $gradient }}; opacity: 0.3;"></div>
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-6xl text-white" style="background: {{ $gradient }}">
                                            <i class="fa-solid fa-book"></i>
                                        </div>
                                    @endif
                                    @if ($course->is_paid)
                                        <span class="absolute top-4 right-4 px-4 py-2 text-xs font-bold rounded-full bg-white/95 text-[#025f5a] shadow-lg">
                                            <i class="fa-solid fa-crown mr-1"></i>Premium
                                        </span>
                                    @else
                                        <span class="absolute top-4 right-4 px-4 py-2 text-xs font-bold rounded-full bg-emerald-500/95 text-white shadow-lg">
                                            <i class="fa-solid fa-check mr-1"></i>Gratis
                                        </span>
                                    @endif
                                </div>
                                <div class="p-8">
                                    <span class="inline-block px-4 py-1.5 [background:rgba(2,95,90,0.15)] rounded-full text-xs font-semibold [color:#5eead4] mb-4">
                                        {{ $course->category->name ?? 'Uncategorized' }}
                                        @if ($course->level)
                                            • {{ $levelOptions[$course->level] ?? ucfirst($course->level) }}
                                        @endif
                                    </span>
                                    <h3 class="text-xl font-bold text-white mb-3 group-hover:text-teal-300 transition">{{ $course->title }}</h3>
                                    <p class="[color:#b4b4b4] text-sm mb-5 leading-relaxed line-clamp-2">
                                        {{ \Illuminate\Support\Str::limit($course->description, 100) }}
                                    </p>

                                    <div class="flex items-center gap-4 mb-5 text-sm [color:#8b8b8b]">
                                        <span><i class="fa-solid fa-layer-group mr-1 text-[#5eead4]"></i>{{ $course->lessons_count ?? 0 }} modul</span>
                                        <span><i class="fa-solid fa-users mr-1 text-[#5eead4]"></i>{{ $course->students_count ?? 0 }} siswa</span>
                                    </div>

                                    <div class="flex items-center justify-between pt-5 [border-top:1px_solid_rgba(255,255,255,0.05)]">
                                        <div class="text-2xl font-bold text-white">
                                            {{ $course->is_paid ? 'Rp '.number_format($course->getEffectivePrice(), 0, ',', '.') : 'Gratis' }}
                                        </div>
                                        @auth
                                            <a href="{{ route('dashboard.my-courses.index') }}" class="px-5 py-2.5 rounded-full [background:rgba(2,95,90,0.2)] border-2 border-[#025f5a] text-white font-semibold hover:[background:linear-gradient(135deg,#06b6d4,#025f5a)] transition-all hover:shadow-[0_8px_25px_rgba(20,184,166,0.4)]">
                                                Lihat Detail
                                            </a>
                                        @else
                                            <a href="{{ route('login') }}" class="px-5 py-2.5 rounded-full [background:rgba(2,95,90,0.2)] border-2 border-[#025f5a] text-white font-semibold hover:[background:linear-gradient(135deg,#06b6d4,#025f5a)] transition-all hover:shadow-[0_8px_25px_rgba(20,184,166,0.4)]">
                                                Daftar
                                            </a>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if ($courses instanceof \Illuminate\Pagination\AbstractPaginator)
                        <div class="mt-12">
                            {{ $courses->links() }}
                        </div>
                    @endif
                @endif
            </section>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-white dark:[background:#0a0a0f] py-20 px-8 [border-top:1px_solid_rgba(0,0,0,0.06)] dark:[border-top:1px_solid_rgba(255,255,255,0.05)]">
    <div class="max-w-7xl mx-auto">
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-16 mb-16">
            <div>
                <h3 class="text-3xl font-extrabold mb-5" style="background: linear-gradient(135deg, #06b6d4, #025f5a); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                    MCI Learning
                </h3>
                <p class="[color:#8b8b8b] leading-relaxed mb-6">
                    Platform pembelajaran online terlengkap dan terpercaya untuk mengembangkan skill Anda.
                </p>
                <div class="flex gap-4">
                    <a href="#" aria-label="Facebook" class="w-11 h-11 rounded-full [background:rgba(2,95,90,0.1)] [border:1px_solid_rgba(2,95,90,0.3)] flex items-center justify-center [color:#025f5a] hover:[background:linear-gradient(135deg,#06b6d4,#025f5a)] hover:text-white transition-all hover:-translate-y-1">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                    <a href="#" aria-label="Twitter" class="w-11 h-11 rounded-full [background:rgba(2,95,90,0.1)] [border:1px_solid_rgba(2,95,90,0.3)] flex items-center justify-center [color:#025f5a] hover:[background:linear-gradient(135deg,#06b6d4,#025f5a)] hover:text-white transition-all hover:-translate-y-1">
                        <i class="fa-brands fa-x-twitter"></i>
                    </a>
                    <a href="#" aria-label="LinkedIn" class="w-11 h-11 rounded-full [background:rgba(2,95,90,0.1)] [border:1px_solid_rgba(2,95,90,0.3)] flex items-center justify-center [color:#025f5a] hover:[background:linear-gradient(135deg,#06b6d4,#025f5a)] hover:text-white transition-all hover:-translate-y-1">
                        <i class="fa-brands fa-linkedin-in"></i>
                    </a>
                    <a href="#" aria-label="Instagram" class="w-11 h-11 rounded-full [background:rgba(2,95,90,0.1)] [border:1px_solid_rgba(2,95,90,0.3)] flex items-center justify-center [color:#025f5a] hover:[background:linear-gradient(135deg,#06b6d4,#025f5a)] hover:text-white transition-all hover:-translate-y-1">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                </div>
            </div>

            <div>
                <h4 class="text-lg font-bold [color:#025f5a] mb-6">Pelajari</h4>
                <ul class="space-y-4">
                    @foreach(['Semua Kursus', 'Kategori', 'Instruktur', 'Blog'] as $link)
                        <li><a href="#" class="[color:#8b8b8b] hover:[color:#025f5a] hover:pl-2 transition-all">{{ $link }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h4 class="text-lg font-bold [color:#025f5a] mb-6">Perusahaan</h4>
                <ul class="space-y-4">
                    @foreach(['Tentang Kami', 'Karir', 'Press', 'Partner'] as $link)
                        <li><a href="#" class="[color:#8b8b8b] hover:[color:#025f5a] hover:pl-2 transition-all">{{ $link }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h4 class="text-lg font-bold [color:#025f5a] mb-6">Bantuan</h4>
                <ul class="space-y-4">
                    @foreach(['Help Center', 'Syarat & Ketentuan', 'Kebijakan Privasi', 'Hubungi Kami'] as $link)
                        <li><a href="#" class="[color:#8b8b8b] hover:[color:#025f5a] hover:pl-2 transition-all">{{ $link }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="text-center pt-8 [border-top:1px_solid_rgba(255,255,255,0.05)] [color:#666]">
            <p>&copy; {{ date('Y') }} MCI Learning. All rights reserved. Made with <i class="fa-solid fa-heart" style="color:#10b981"></i> in Indonesia</p>
        </div>
    </div>
</footer>

<!-- Scroll to top button -->
<button id="scrollTop" class="fixed bottom-10 right-10 w-14 h-14 [background:linear-gradient(135deg,#06b6d4,#025f5a)] rounded-full flex items-center justify-center text-white text-2xl opacity-0 translate-y-24 transition-all duration-300 shadow-[0_10px_30px_rgba(20,184,166,0.4)] hover:-translate-y-1 hover:shadow-[0_20px_50px_rgba(20,184,166,0.6)] z-50" aria-label="Scroll to top">
    <i class="fa-solid fa-arrow-up"></i>
</button>

@push('scripts')
<script>
    // Scroll to top button
    window.addEventListener('scroll', () => {
        const scrollTop = document.getElementById('scrollTop');
        if (window.scrollY > 500) {
            scrollTop.classList.remove('opacity-0', 'translate-y-24');
        } else {
            scrollTop.classList.add('opacity-0', 'translate-y-24');
        }
    });

    // Scroll to top functionality
    document.getElementById('scrollTop').addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
</script>
@endpush
@endsection
