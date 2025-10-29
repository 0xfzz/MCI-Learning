@extends('layouts.app')

@section('title', 'MCI (Majelis Coding Indonesia) - Transform Your Future with Knowledge')

@section('content')
<!-- Navbar -->
<nav id="navbar" class="fixed top-0 w-full z-50 transition-all duration-300 backdrop-blur-lg border-b [border-color:rgba(2,95,90,0.12)] dark:border-white/10">
    <div class="max-w-7xl mx-auto px-8 py-6 flex items-center justify-between">
        <a href="#home" class="flex items-center gap-3 cursor-pointer">
            <!-- Logo image with light/dark mode support -->
            <img src="{{ asset('assets/logo/putih.png') }}" alt="MCI (Majelis Coding Indonesia)" class="h-12 w-auto dark:block hidden">
            <img src="{{ asset('assets/logo/hijau.png') }}" alt="MCI (Majelis Coding Indonesia)" class="h-12 w-auto dark:hidden block">
        </a>

        <div class="hidden md:flex items-center gap-12">
            <a href="#home" class="text-gray-700 dark:text-gray-300 hover:[color:#025f5a] transition font-medium">Home</a>
            <a href="#features" class="text-gray-700 dark:text-gray-300 hover:[color:#025f5a] transition font-medium">Features</a>
            <a href="#courses" class="text-gray-700 dark:text-gray-300 hover:[color:#025f5a] transition font-medium">Courses</a>
            <a href="#testimonials" class="text-gray-700 dark:text-gray-300 hover:[color:#025f5a] transition font-medium">Testimonials</a>
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
            <div class="flex flex-col gap-1.5 cursor-pointer">
                <span class="w-6 h-0.5 [background:#025f5a] rounded"></span>
                <span class="w-6 h-0.5 [background:#025f5a] rounded"></span>
                <span class="w-6 h-0.5 [background:#025f5a] rounded"></span>
            </div>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section id="home" class="min-h-screen flex items-center justify-between px-8 lg:px-16 pt-32 pb-20 relative overflow-hidden [background:linear-gradient(135deg,#f8fafc_0%,#eef2ff_100%)] dark:[background:linear-gradient(135deg,#1e1e28_0%,#0a0a0f_100%)]">
    <!-- Background decorations -->
    <div class="absolute w-[600px] h-[600px] [background:radial-gradient(circle,rgba(2,95,90,0.15)_0%,transparent_70%)] rounded-full -top-64 -right-64 animate-pulse"></div>
    <div class="absolute w-[500px] h-[500px] [background:radial-gradient(circle,rgba(6,182,212,0.12)_0%,transparent_70%)] rounded-full -bottom-48 -left-48 animate-pulse [animation-delay:3s]"></div>

    <div class="max-w-7xl mx-auto grid lg:grid-cols-2 gap-16 items-center relative z-10">
        <!-- Hero Content -->
        <div class="space-y-8 animate-fade-in">
            <div class="inline-flex items-center gap-2 px-6 py-2.5 [background:rgba(2,95,90,0.1)] dark:[background:rgba(2,95,90,0.1)] [border:1.5px_solid_rgba(2,95,90,0.3)] rounded-full dark:[color:#5eead4] [color:#ffbf00] text-sm font-semibold">
                <span><i class="fa-solid fa-wand-magic-sparkles"></i></span>
                <span>Platform Pembelajaran #1 di Indonesia</span>
            </div>

            <h1 class="bg-clip-text text-transparent text-6xl lg:text-7xl font-black leading-tight bg-linear-[135deg,#000_0%,#5eead4_40%,#025f5a_100%] dark:bg-linear-[135deg,#fff_0%,#5eead4_40%,#025f5a_100%]">
                Wujudkan Potensi Terbaikmu Bersama Kami
            </h1>

            <p class="text-xl [color:#b4b4b4] leading-relaxed">
                Bergabunglah dengan {{ number_format($stats['total_students']) }}+ pembelajar yang telah mengubah karir mereka. Akses {{ $stats['total_courses'] }}+ course premium, mentor berpengalaman, dan komunitas yang supportif untuk mencapai kesuksesan.
            </p>

            <div class="flex flex-wrap gap-5">
                <a href="{{ route('register') }}" class="px-11 py-5 [background:linear-gradient(135deg,#06b6d4_0%,#025f5a_100%)] rounded-full text-white text-lg font-bold shadow-[0_15px_40px_rgba(20,184,166,0.3)] hover:shadow-[0_20px_50px_rgba(20,184,166,0.5)] transition-all hover:-translate-y-1 flex items-center gap-3">
                    <span><i class="fa-solid fa-rocket"></i></span>
                    <span>Mulai Belajar Gratis</span>
                </a>
                <a href="#courses" class="px-11 py-5 [border:2px_solid_#025f5a] rounded-full [color:#025f5a] dark:text-white text-lg font-bold [background:transparent] hover:[background:rgba(2,95,90,0.1)] transition-all hover:-translate-y-1 flex items-center gap-3">
                    <span><i class="fa-solid fa-play"></i></span>
                    <span>Lihat Course</span>
                </a>
            </div>

            <!-- Stats Section -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 pt-8">
                <div class="text-center">
                    <div class="text-4xl font-black [color:#025f5a] dark:text-white mb-2">{{ number_format($stats['total_students']) }}+</div>
                    <div class="text-sm [color:#8b8b8b]">Siswa Aktif</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-black [color:#025f5a] dark:text-white mb-2">{{ $stats['total_courses'] }}+</div>
                    <div class="text-sm [color:#8b8b8b]">Course Premium</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-black [color:#025f5a] dark:text-white mb-2">{{ $stats['total_instructors'] }}+</div>
                    <div class="text-sm [color:#8b8b8b]">Instruktur Expert</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-black [color:#025f5a] dark:text-white mb-2">{{ $stats['average_rating'] }}<i class="fa-solid fa-star text-yellow-400 text-2xl ml-2"></i></div>
                    <div class="text-sm [color:#8b8b8b]">Rating Rata-rata</div>
                </div>
            </div>
        </div>

        <!-- Hero Image -->
        <div class="flex justify-center items-center animate-fade-in-right hidden md:block">
            <div class="w-full max-w-2xl h-[500px] bg-gradient-to-br from-white to-gray-50 dark:from-gray-950 dark:to-gray-900 rounded-3xl p-8 backdrop-blur-xl border-2 border-teal-500/30 dark:border-teal-400/30 shadow-[0_20px_50px_rgba(20,184,166,0.15)] dark:shadow-[0_20px_50px_rgba(20,184,166,0.25)] hover:shadow-[0_25px_60px_rgba(20,184,166,0.3)] transition-all duration-500 hover:-translate-y-3 hover:rotate-1 relative overflow-hidden group">
                <!-- Animated glow effect -->
                <div class="absolute inset-0 bg-gradient-to-r from-cyan-500/0 via-teal-500/5 dark:via-teal-500/10 to-cyan-500/0 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

                <!-- Browser-like header -->
                <div class="flex gap-2 mb-6 relative z-10">
                    <div class="w-3 h-3 rounded-full bg-red-500 animate-pulse"></div>
                    <div class="w-3 h-3 rounded-full bg-yellow-500 animate-pulse" style="animation-delay: 0.1s;"></div>
                    <div class="w-3 h-3 rounded-full bg-green-500 animate-pulse" style="animation-delay: 0.2s;"></div>
                </div>

                <!-- Dashboard mockup content -->
                <div class="relative z-10 h-[calc(100%-40px)]">
                    <div class="grid grid-cols-2 gap-5 h-full">
                        <!-- Card 1 - Stats with icon -->
                        <div class="bg-gradient-to-br from-cyan-50 to-teal-50 dark:from-cyan-500/30 dark:to-teal-500/30 rounded-2xl border-2 border-cyan-400/40 dark:border-cyan-400/30 p-6 flex flex-col justify-between hover:scale-105 transition-transform duration-300 cursor-pointer shadow-[0_8px_30px_rgba(20,184,166,0.12)]">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-cyan-500 to-teal-500 rounded-xl flex items-center justify-center shadow-[0_4px_20px_rgba(20,184,166,0.3)]">
                                    <i class="fa-solid fa-users text-white text-xl"></i>
                                </div>
                                <span class="text-cyan-600 dark:text-cyan-400 text-sm font-bold bg-cyan-100 dark:bg-cyan-900/30 px-3 py-1 rounded-full">+12%</span>
                            </div>
                            <div>
                                <div class="h-2 bg-gray-200 dark:bg-white/20 rounded-full mb-2">
                                    <div class="h-full w-3/4 bg-gradient-to-r from-cyan-500 to-teal-500 rounded-full animate-pulse shadow-[0_2px_10px_rgba(20,184,166,0.4)]"></div>
                                </div>
                                <div class="h-2 bg-gray-200 dark:bg-white/20 rounded-full w-2/3"></div>
                            </div>
                        </div>

                        <!-- Card 2 - Chart -->
                        <div class="bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-indigo-500/30 dark:to-purple-500/30 rounded-2xl border-2 border-indigo-400/40 dark:border-indigo-400/30 p-6 flex flex-col justify-end hover:scale-105 transition-transform duration-300 cursor-pointer shadow-[0_8px_30px_rgba(20,184,166,0.12)]" style="animation-delay: 0.2s;">
                            <div class="flex items-end justify-around h-24 gap-2">
                                <div class="w-full bg-gradient-to-t from-indigo-500 to-purple-500 rounded-t-lg animate-pulse shadow-[0_4px_15px_rgba(20,184,166,0.2)]" style="height: 45%; animation-delay: 0.3s;"></div>
                                <div class="w-full bg-gradient-to-t from-indigo-500 to-purple-500 rounded-t-lg animate-pulse shadow-[0_4px_15px_rgba(20,184,166,0.2)]" style="height: 75%; animation-delay: 0.4s;"></div>
                                <div class="w-full bg-gradient-to-t from-indigo-500 to-purple-500 rounded-t-lg animate-pulse shadow-[0_4px_15px_rgba(20,184,166,0.2)]" style="height: 60%; animation-delay: 0.5s;"></div>
                                <div class="w-full bg-gradient-to-t from-indigo-500 to-purple-500 rounded-t-lg animate-pulse shadow-[0_4px_15px_rgba(20,184,166,0.2)]" style="height: 90%; animation-delay: 0.6s;"></div>
                            </div>
                        </div>

                        <!-- Card 3 - Progress circles -->
                        <div class="bg-gradient-to-br from-amber-50 to-orange-50 dark:from-amber-500/30 dark:to-orange-500/30 rounded-2xl border-2 border-amber-400/40 dark:border-amber-400/30 p-6 flex items-center justify-center hover:scale-105 transition-transform duration-300 cursor-pointer shadow-[0_8px_30px_rgba(20,184,166,0.12)]" style="animation-delay: 0.4s;">
                            <div class="relative w-24 h-24">
                                <svg class="transform -rotate-90" viewBox="0 0 100 100">
                                    <circle cx="50" cy="50" r="40" class="stroke-gray-200 dark:stroke-amber-400/20" stroke-width="8" fill="none"></circle>
                                    <circle cx="50" cy="50" r="40" stroke="url(#gradient)" stroke-width="8" fill="none" stroke-dasharray="251.2" stroke-dashoffset="75.36" class="transition-all duration-1000" stroke-linecap="round">
                                        <animate attributeName="stroke-dashoffset" from="251.2" to="75.36" dur="2s" repeatCount="indefinite" />
                                    </circle>
                                    <defs>
                                        <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                            <stop offset="0%" style="stop-color:#f59e0b" />
                                            <stop offset="100%" style="stop-color:#f97316" />
                                        </linearGradient>
                                    </defs>
                                </svg>
                                <div class="absolute inset-0 flex items-center justify-center text-amber-600 dark:text-amber-400 font-bold text-xl">70%</div>
                            </div>
                        </div>

                        <!-- Card 4 - Activity list -->
                        <div class="bg-gradient-to-br from-emerald-50 to-teal-50 dark:from-emerald-500/30 dark:to-teal-500/30 rounded-2xl border-2 border-emerald-400/40 dark:border-emerald-400/30 p-6 flex flex-col gap-3 hover:scale-105 transition-transform duration-300 cursor-pointer shadow-[0_8px_30px_rgba(20,184,166,0.12)]" style="animation-delay: 0.6s;">
                            <div class="flex items-center gap-3">
                                <div class="w-2 h-2 rounded-full bg-emerald-500 dark:bg-emerald-400 animate-pulse"></div>
                                <div class="h-2 bg-gray-200 dark:bg-white/30 rounded-full flex-1"></div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-2 h-2 rounded-full bg-teal-500 dark:bg-teal-400 animate-pulse" style="animation-delay: 0.2s;"></div>
                                <div class="h-2 bg-gray-200 dark:bg-white/30 rounded-full flex-1 w-4/5"></div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-2 h-2 rounded-full bg-cyan-500 dark:bg-cyan-400 animate-pulse" style="animation-delay: 0.4s;"></div>
                                <div class="h-2 bg-gray-200 dark:bg-white/30 rounded-full flex-1 w-3/5"></div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-2 h-2 rounded-full bg-emerald-400 dark:bg-emerald-300 animate-pulse" style="animation-delay: 0.6s;"></div>
                                <div class="h-2 bg-gray-200 dark:bg-white/30 rounded-full flex-1 w-2/3"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Floating particles for extra effect -->
                <div class="absolute top-20 right-20 w-3 h-3 rounded-full bg-cyan-500 dark:bg-cyan-400 animate-float opacity-60 shadow-[0_4px_20px_rgba(20,184,166,0.4)]"></div>
                <div class="absolute bottom-32 left-16 w-2 h-2 rounded-full bg-teal-500 dark:bg-teal-400 animate-float opacity-40 shadow-[0_4px_20px_rgba(20,184,166,0.4)]" style="animation-delay: 1s;"></div>
                <div class="absolute top-40 left-32 w-2 h-2 rounded-full bg-purple-500 dark:bg-purple-400 animate-float opacity-50 shadow-[0_4px_20px_rgba(20,184,166,0.4)]" style="animation-delay: 1.5s;"></div>
            </div>
        </div>
    </div>
</section>


<!-- Features Section -->
<section id="features" class="py-32 px-8 relative bg-white dark:[background:#0a0a0f]">
    <div class="max-w-7xl mx-auto">
        <div class="text-center max-w-3xl mx-auto mb-20">
            <div class="[color:#025f5a] text-sm font-bold uppercase tracking-widest mb-4">✨ Keunggulan Kami</div>
            <h2 class="text-5xl lg:text-6xl font-black mb-6 [color:#025f5a] dark:text-white">Mengapa MCI (Majelis Coding Indonesia) Pilihan Terbaik?</h2>
            <p class="text-xl [color:#b4b4b4] leading-relaxed">
                Platform pembelajaran online yang dirancang khusus untuk memaksimalkan potensi Anda dengan teknologi terkini dan metode pembelajaran yang efektif.
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @php
                $features = [
                    ['icon' => 'fa-graduation-cap', 'title' => 'Kurikulum Premium', 'desc' => 'Materi pembelajaran yang disusun oleh para ahli industri dengan pengalaman puluhan tahun. Setiap course dirancang untuk memberikan skill praktis yang langsung applicable.', 'grad' => 'linear-gradient(135deg,#14b8a6,#06b6d4)'],
                    ['icon' => 'fa-bolt', 'title' => 'Belajar Fleksibel', 'desc' => 'Akses materi 24/7 dari perangkat apa saja. Belajar sesuai pace Anda sendiri tanpa batasan waktu dengan lifetime access untuk setiap course yang dibeli.', 'grad' => 'linear-gradient(135deg,#6366f1,#7c3aed)'],
                    ['icon' => 'fa-chalkboard-user', 'title' => 'Mentor Berpengalaman', 'desc' => 'Didukung oleh 500+ mentor profesional yang siap membimbing perjalanan belajar Anda. Live mentoring session setiap minggu untuk menjawab pertanyaan Anda.', 'grad' => 'linear-gradient(135deg,#10b981,#14b8a6)'],
                    ['icon' => 'fa-globe', 'title' => 'Komunitas Global', 'desc' => 'Bergabung dengan komunitas pembelajar dari 50+ negara. Networking, kolaborasi, dan berbagi pengalaman dengan sesama learners di seluruh dunia.', 'grad' => 'linear-gradient(135deg,#06b6d4,#2563eb)'],
                    ['icon' => 'fa-trophy', 'title' => 'Sertifikat Terverifikasi', 'desc' => 'Dapatkan sertifikat yang diakui oleh lebih dari 1000+ perusahaan global. Tingkatkan CV dan LinkedIn Anda dengan kredensial yang valuable.', 'grad' => 'linear-gradient(135deg,#f59e0b,#f97316)'],
                    ['icon' => 'fa-bullseye', 'title' => 'Project-Based Learning', 'desc' => 'Belajar sambil praktek dengan real-world projects. Bangun portofolio yang impressive untuk meningkatkan peluang karir Anda.', 'grad' => 'linear-gradient(135deg,#a855f7,#f43f5e)'],
                ];
            @endphp

            @foreach($features as $feature)
                <div class="dark:[background:rgba(30,30,40,0.5)] p-11 rounded-3xl [border:2px] border-teal-400/30 hover:[border-color:rgba(2,95,90,0.3)] shadow-[0_10px_40px_rgba(20,184,166,0.1)] hover:shadow-[0_25px_50px_rgba(20,184,166,0.25)] transition-all duration-300 hover:-translate-y-3 cursor-pointer group">
                    <div class="w-[70px] h-[70px] rounded-2xl flex items-center justify-center text-4xl mb-6 shadow-[0_10px_30px_rgba(20,184,166,0.3)] group-hover:scale-110 transition-transform" style="background: {{ $feature['grad'] }}">
                        <i class="fa-solid text-white {{ $feature['icon'] }}"></i>
                    </div>
                    <h3 class="text-2xl font-bold [color:#025f5a] dark:text-white mb-4">{{ $feature['title'] }}</h3>
                    <p class="[color:#b4b4b4] leading-relaxed">{{ $feature['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Courses Section -->
<section id="courses" class="py-32 px-8 [background:linear-gradient(135deg,#f8fafc_0%,#eef2ff_100%)] dark:[background:linear-gradient(135deg,#1e1e28_0%,#0a0a0f_100%)]">
    <div class="max-w-7xl mx-auto">
        <div class="text-center max-w-3xl mx-auto mb-20">
            <div class="[color:#025f5a] text-sm font-bold uppercase tracking-widest mb-4"><i class="fa-solid fa-book"></i> Course Populer</div>
            <h2 class="text-5xl lg:text-6xl font-black mb-6 [color:#025f5a] dark:text-white">Temukan Course yang Tepat untuk Anda</h2>
            <p class="text-xl [color:#b4b4b4] leading-relaxed">
                Pilihan course terlengkap dalam berbagai kategori dari teknologi, bisnis, design, hingga personal development.
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @php
                // Gradient mappings for categories
                $categoryGradients = [
                    'Web Development' => 'linear-gradient(135deg,#14b8a6,#06b6d4)',
                    'Mobile Development' => 'linear-gradient(135deg,#10b981,#14b8a6)',
                    'Data Science' => 'linear-gradient(135deg,#4f46e5,#06b6d4)',
                    'UI/UX Design' => 'linear-gradient(135deg,#a855f7,#f43f5e)',
                    'Digital Marketing' => 'linear-gradient(135deg,#f59e0b,#f97316)',
                    'Cybersecurity' => 'linear-gradient(135deg,#06b6d4,#025f5a)',
                ];

                // Icon mappings for categories
                $categoryIcons = [
                    'Web Development' => 'fa-laptop-code',
                    'Mobile Development' => 'fa-mobile-screen-button',
                    'Data Science' => 'fa-robot',
                    'UI/UX Design' => 'fa-paintbrush',
                    'Digital Marketing' => 'fa-chart-line',
                    'Cybersecurity' => 'fa-shield-halved',
                ];

                $defaultGradient = 'linear-gradient(135deg,#06b6d4,#025f5a)';
                $defaultIcon = 'fa-book';
            @endphp

            @forelse($featuredCourses as $course)
                @php
                    $gradient = $categoryGradients[$course['category']] ?? $defaultGradient;
                    $icon = $categoryIcons[$course['category']] ?? $defaultIcon;
                    $studentsFormatted = $course['students_count'] >= 1000
                        ? number_format($course['students_count'] / 1000, 1) . 'K'
                        : $course['students_count'];
                @endphp
                <a href="{{ route('courses.index') }}" class="block [background:rgba(30,30,40,0.6)] rounded-3xl overflow-hidden [border:2px_solid_rgba(255,255,255,0.08)] hover:[border-color:rgba(2,95,90,0.4)] shadow-[0_10px_40px_rgba(20,184,166,0.15)] hover:shadow-[0_25px_50px_rgba(20,184,166,0.3)] transition-all duration-300 hover:-translate-y-3 cursor-pointer">
                    @if($course['thumbnail'])
                        <div class="h-48 bg-cover bg-center relative" style="background-image: url('{{ asset('storage/' . $course['thumbnail']) }}')">
                            <div class="absolute inset-0" style="background: {{ $gradient }}; opacity: 0.7;"></div>
                            <div class="absolute inset-0 flex items-center justify-center text-6xl text-white">
                                <i class="fa-solid {{ $icon }}"></i>
                            </div>
                        </div>
                    @else
                        <div class="h-48 flex items-center justify-center text-6xl relative text-white" style="background: {{ $gradient }}">
                            <i class="fa-solid {{ $icon }}"></i>
                        </div>
                    @endif
                    <div class="p-8">
                        <span class="inline-block px-4 py-1.5 [background:rgba(2,95,90,0.15)] rounded-full text-xs font-semibold [color:#5eead4] mb-4">
                            {{ $course['category'] }}
                        </span>
                        <h3 class="text-xl font-bold text-white mb-3">{{ $course['title'] }}</h3>
                        <p class="[color:#b4b4b4] text-sm mb-5 leading-relaxed line-clamp-2">
                            {{ Str::limit($course['description'], 100) }}
                        </p>
                        <div class="flex items-center justify-between pt-5 [border-top:1px_solid_rgba(255,255,255,0.05)]">
                            <div class="flex items-center gap-2 [color:#fbbf24] font-semibold">
                                <span><i class="fa-solid fa-star"></i></span>
                                <span>{{ $course['average_rating'] ?: 'New' }}</span>
                                @if($course['reviews_count'] > 0)
                                    <span class="[color:#8b8b8b] text-sm">({{ number_format($course['reviews_count']) }})</span>
                                @endif
                            </div>
                            <div class="[color:#8b8b8b] text-sm">{{ $studentsFormatted }} siswa</div>
                        </div>
                    </div>
                </a>
            @empty
                <!-- Fallback to default courses if no data -->
                @php
                    $defaultCourses = [
                        ['icon' => 'fa-laptop-code', 'category' => 'Web Development', 'title' => 'Full Stack Web Development Masterclass', 'desc' => 'Pelajari HTML, CSS, JavaScript, React, Node.js dan bangun 10+ real-world projects profesional.', 'rating' => '4.9', 'reviews' => '12,543', 'students' => '45K', 'grad' => 'linear-gradient(135deg,#14b8a6,#06b6d4)'],
                        ['icon' => 'fa-paintbrush', 'category' => 'UI/UX Design', 'title' => 'UI/UX Design Complete Guide', 'desc' => 'Master Figma, design principles, user research, dan create stunning interfaces yang user-friendly.', 'rating' => '4.8', 'reviews' => '8,932', 'students' => '32K', 'grad' => 'linear-gradient(135deg,#a855f7,#f43f5e)'],
                        ['icon' => 'fa-robot', 'category' => 'Data Science', 'title' => 'Data Science & Machine Learning A-Z', 'desc' => 'Python, Pandas, Scikit-learn, TensorFlow - dari basic hingga advanced AI applications.', 'rating' => '4.9', 'reviews' => '15,234', 'students' => '56K', 'grad' => 'linear-gradient(135deg,#4f46e5,#06b6d4)'],
                    ];
                @endphp
                @foreach($defaultCourses as $course)
                    <div class="[background:rgba(30,30,40,0.6)] rounded-3xl overflow-hidden [border:2px_solid_rgba(255,255,255,0.08)] hover:[border-color:rgba(2,95,90,0.4)] shadow-[0_10px_40px_rgba(20,184,166,0.15)] hover:shadow-[0_25px_50px_rgba(20,184,166,0.3)] transition-all duration-300 hover:-translate-y-3 cursor-pointer">
                        <div class="h-48 flex items-center justify-center text-6xl relative text-white" style="background: {{ $course['grad'] }}">
                            <i class="fa-solid {{ $course['icon'] }}"></i>
                        </div>
                        <div class="p-8">
                            <span class="inline-block px-4 py-1.5 [background:rgba(2,95,90,0.15)] rounded-full text-xs font-semibold [color:#5eead4] mb-4">
                                {{ $course['category'] }}
                            </span>
                            <h3 class="text-xl font-bold text-white mb-3">{{ $course['title'] }}</h3>
                            <p class="[color:#b4b4b4] text-sm mb-5 leading-relaxed">{{ $course['desc'] }}</p>
                            <div class="flex items-center justify-between pt-5 [border-top:1px_solid_rgba(255,255,255,0.05)]">
                                <div class="flex items-center gap-2 [color:#fbbf24] font-semibold">
                                    <span><i class="fa-solid fa-star"></i></span>
                                    <span>{{ $course['rating'] }}</span>
                                    <span class="[color:#8b8b8b] text-sm">({{ $course['reviews'] }})</span>
                                </div>
                                <div class="[color:#8b8b8b] text-sm">{{ $course['students'] }} siswa</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endforelse
        </div>

        <!-- View All Courses Button -->
        <div class="text-center mt-16">
            <a href="{{ route('courses.index') }}" class="inline-flex items-center gap-3 px-11 py-5 [border:2px_solid_#025f5a] rounded-full [color:#025f5a] dark:text-white text-lg font-bold [background:transparent] hover:[background:rgba(2,95,90,0.1)] transition-all hover:-translate-y-1">
                <span>Lihat Semua Course</span>
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section id="testimonials" class="py-32 px-8 bg-white dark:[background:#0a0a0f]">
    <div class="max-w-7xl mx-auto">
        <div class="text-center max-w-3xl mx-auto mb-20">
            <div class="[color:#025f5a] text-sm font-bold uppercase tracking-widest mb-4"><i class="fa-solid fa-comment-dots"></i> Testimoni</div>
            <h2 class="text-5xl lg:text-6xl font-black mb-6 [color:#025f5a] dark:text-white">Apa Kata Mereka tentang MCI (Majelis Coding Indonesia)?</h2>
            <p class="text-xl [color:#b4b4b4] leading-relaxed">
                Ribuan siswa telah merasakan transformasi karir dan skill mereka bersama kami.
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($testimonials as $testimonial)
                <div class="[background:rgba(30,30,40,0.5)] p-10 rounded-3xl [border:2px_solid_rgba(255,255,255,0.05)] hover:[border-color:rgba(2,95,90,0.3)] shadow-[0_10px_40px_rgba(20,184,166,0.12)] hover:shadow-[0_20px_45px_rgba(20,184,166,0.25)] transition-all duration-300 hover:-translate-y-2 relative">
                    <div class="absolute top-5 left-8 text-8xl [color:rgba(2,95,90,0.15)] font-black leading-none">"</div>
                    <p class="[color:#d4d4d4] leading-relaxed mb-6 relative z-10">{{ $testimonial['text'] }}</p>
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-full [background:linear-gradient(135deg,#06b6d4,#025f5a)] flex items-center justify-center text-white font-bold text-xl">
                            {{ $testimonial['avatar'] }}
                        </div>
                        <div>
                            <h4 class="font-bold text-white">{{ $testimonial['name'] }}</h4>
                            <p class="[color:#8b8b8b] text-sm">{{ $testimonial['role'] }}</p>
                            @if($testimonial['course'])
                                <p class="[color:#5eead4] text-xs mt-1">{{ $testimonial['course'] }}</p>
                            @endif
                        </div>
                    </div>
                    <!-- Star rating -->
                    <div class="flex gap-1 mt-4">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fa-solid fa-star {{ $i <= $testimonial['rating'] ? 'text-yellow-400' : 'text-gray-600' }} text-sm"></i>
                        @endfor
                    </div>
                </div>
            @empty
                <!-- Fallback to default testimonials if no reviews -->
                @php
                    $defaultTestimonials = [
                        ['name' => 'Budi Wirawan', 'role' => 'Full Stack Developer', 'avatar' => 'BW', 'text' => 'MCI (Majelis Coding Indonesia) benar-benar mengubah karir saya! Dari yang tadinya tidak tahu coding sama sekali, sekarang saya sudah bekerja sebagai Full Stack Developer di perusahaan tech startup. Materinya sangat lengkap dan mentornya super helpful!'],
                        ['name' => 'Sarah Rahmawati', 'role' => 'Senior UI/UX Designer', 'avatar' => 'SR', 'text' => 'Sebagai UI/UX Designer, saya selalu perlu update skill. MCI (Majelis Coding Indonesia) menyediakan course yang selalu up-to-date dengan trend terbaru. Project-based learning nya juga sangat membantu build portofolio saya.'],
                        ['name' => 'Ahmad Pratama', 'role' => 'Data Scientist', 'avatar' => 'AP', 'text' => 'Investasi terbaik untuk career development! Saya ambil course Data Science dan dalam 6 bulan sudah dapat job offer dengan salary 2x lipat. Komunitasnya juga sangat supportive dan active.'],
                    ];
                @endphp
                @foreach($defaultTestimonials as $testimonial)
                    <div class="[background:rgba(30,30,40,0.5)] p-10 rounded-3xl [border:2px_solid_rgba(255,255,255,0.05)] hover:[border-color:rgba(2,95,90,0.3)] shadow-[0_10px_40px_rgba(20,184,166,0.12)] hover:shadow-[0_20px_45px_rgba(20,184,166,0.25)] transition-all duration-300 hover:-translate-y-2 relative">
                        <div class="absolute top-5 left-8 text-8xl [color:rgba(2,95,90,0.15)] font-black leading-none">"</div>
                        <p class="[color:#d4d4d4] leading-relaxed mb-6 relative z-10">{{ $testimonial['text'] }}</p>
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-full [background:linear-gradient(135deg,#06b6d4,#025f5a)] flex items-center justify-center text-white font-bold text-xl">
                                {{ $testimonial['avatar'] }}
                            </div>
                            <div>
                                <h4 class="font-bold text-white">{{ $testimonial['name'] }}</h4>
                                <p class="[color:#8b8b8b] text-sm">{{ $testimonial['role'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endforelse
        </div>
    </div>
</section>


<!-- CTA Section -->
<section class="py-32 px-8 [background:linear-gradient(135deg,#f8fafc_0%,#eef2ff_100%)] dark:[background:linear-gradient(135deg,#1e1e28_0%,#0a0a0f_100%)] text-center relative overflow-hidden [border-top:1px_solid_rgba(2,95,90,0.2)] [border-bottom:1px_solid_rgba(2,95,90,0.2)]">
    <div class="absolute w-96 h-96 [background:radial-gradient(circle,rgba(2,95,90,0.15)_0%,transparent_70%)] rounded-full -top-48 -right-48 animate-spin-slow"></div>
    <div class="absolute w-80 h-80 [background:radial-gradient(circle,rgba(6,182,212,0.1)_0%,transparent_70%)] rounded-full -bottom-40 -left-40 animate-spin-slow [animation-direction:reverse]"></div>

    <div class="max-w-4xl mx-auto relative z-10">
        <h2 class="text-5xl lg:text-6xl font-black mb-6 bg-clip-text text-transparent bg-linear-[135deg,#000_0%,#5eead4_40%,#025f5a_100%] dark:bg-linear-[135deg,#fff_0%,#5eead4_40%,#025f5a_100%]">
            Siap Memulai Perjalanan Belajar Anda?
        </h2>
        <p class="text-2xl [color:#b4b4b4] mb-11 leading-relaxed">
            Bergabunglah dengan ribuan pelajar lainnya dan raih kesuksesan Anda hari ini!
        </p>
        @auth
            <a href="{{ route('dashboard.index') }}" class="px-14 py-6 [background:linear-gradient(135deg,#06b6d4,#4f46e5,#025f5a)] rounded-full text-white text-xl font-bold shadow-[0_10px_30px_rgba(20,184,166,0.3)] hover:shadow-[0_20px_50px_rgba(20,184,166,0.5)] transition-all hover:-translate-y-2 inline-flex items-center gap-3">
                <span><i class="fa-solid fa-rocket"></i></span>
                <span>Ke Dashboard</span>
            </a>
        @else
            <a href="{{ route('register') }}" class="px-14 py-6 [background:linear-gradient(135deg,#06b6d4,#4f46e5,#025f5a)] rounded-full text-white text-xl font-bold shadow-[0_10px_30px_rgba(20,184,166,0.3)] hover:shadow-[0_20px_50px_rgba(20,184,166,0.5)] transition-all hover:-translate-y-2 inline-flex items-center gap-3">
                <span><i class="fa-solid fa-rocket"></i></span>
                <span>Daftar Gratis Sekarang</span>
            </a>
        @endauth
    </div>
</section>

<!-- Footer -->
<footer class="bg-white dark:[background:#0a0a0f] py-20 px-8 [border-top:1px_solid_rgba(0,0,0,0.06)] dark:[border-top:1px_solid_rgba(255,255,255,0.05)]">
    <div class="max-w-7xl mx-auto">
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-16 mb-16">
            <div>
                <h3 class="text-3xl font-extrabold mb-5" style="background: linear-gradient(135deg, #06b6d4, #025f5a); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                    MCI (Majelis Coding Indonesia)
                </h3>
                <p class="[color:#8b8b8b] leading-relaxed mb-6">
                    Platform pembelajaran online terlengkap dan terpercaya untuk mengembangkan skill Anda. Raih impian karir bersama mentor terbaik dan komunitas yang supportif.
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
                <h4 class="text-lg font-bold [color:#025f5a] mb-6">Course</h4>
                <ul class="space-y-4">
                    @foreach(['Web Development', 'UI/UX Design', 'Data Science', 'Digital Marketing', 'Mobile Development'] as $link)
                        <li><a href="#" class="[color:#8b8b8b] hover:[color:#025f5a] hover:pl-2 transition-all">{{ $link }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h4 class="text-lg font-bold [color:#025f5a] mb-6">Company</h4>
                <ul class="space-y-4">
                    @foreach(['About Us', 'Careers', 'Blog', 'Press', 'Partners'] as $link)
                        <li><a href="#" class="[color:#8b8b8b] hover:[color:#025f5a] hover:pl-2 transition-all">{{ $link }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h4 class="text-lg font-bold [color:#025f5a] mb-6">Support</h4>
                <ul class="space-y-4">
                    @foreach(['Help Center', 'Terms of Service', 'Privacy Policy', 'Contact Us', 'FAQ'] as $link)
                        <li><a href="#" class="[color:#8b8b8b] hover:[color:#025f5a] hover:pl-2 transition-all">{{ $link }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="text-center pt-8 [border-top:1px_solid_rgba(255,255,255,0.05)] [color:#666]">
            <p>&copy; 2025 MCI (Majelis Coding Indonesia). All rights reserved. Made with <i class="fa-solid fa-heart" style="color:#10b981"></i> in Indonesia</p>
        </div>
    </div>
</footer>

<!-- Scroll to top button -->
<button id="scrollTop" class="fixed bottom-10 right-10 w-14 h-14 [background:linear-gradient(135deg,#06b6d4,#025f5a)] rounded-full flex items-center justify-center text-white text-2xl opacity-0 translate-y-24 transition-all duration-300 shadow-[0_10px_30px_rgba(20,184,166,0.4)] hover:-translate-y-1 hover:shadow-[0_20px_50px_rgba(20,184,166,0.6)] z-50" aria-label="Scroll to top">
    <i class="fa-solid fa-arrow-up"></i>
</button>

@push('scripts')
<script>
    // Navbar scroll effect
    window.addEventListener('scroll', () => {
        const nav = document.getElementById('navbar');

        // Scroll to top button
        const scrollTop = document.getElementById('scrollTop');
        if (window.scrollY > 500) {
            scrollTop.classList.remove('opacity-0', 'translate-y-24');
        } else {
            scrollTop.classList.add('opacity-0', 'translate-y-24');
        }
    });

    // Smooth scroll
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    // Scroll to top functionality
    document.getElementById('scrollTop').addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
</script>
@endpush
@endsection
