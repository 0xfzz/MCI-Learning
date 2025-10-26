@extends('layouts.app')

@php
    use Illuminate\Support\Str;
@endphp

@section('title', 'MCI Blog - Wawasan Teknologi & Transformasi Karir')

@section('content')
<!-- Navbar -->
<nav id="navbar" class="fixed top-0 w-full z-50 transition-all duration-300 backdrop-blur-lg border-b [border-color:rgba(2,95,90,0.12)] dark:border-white/10">
    <div class="max-w-7xl mx-auto px-6 lg:px-10 py-6 flex items-center justify-between">
        <a href="{{ route('home') }}" class="flex items-center gap-3 cursor-pointer">
            <img src="{{ asset('assets/logo/putih.png') }}" alt="MCI (Majelis Coding Indonesia)" class="h-11 w-auto dark:block hidden">
            <img src="{{ asset('assets/logo/hijau.png') }}" alt="MCI (Majelis Coding Indonesia)" class="h-11 w-auto dark:hidden block">
        </a>

        <div class="hidden md:flex items-center gap-10">
            <a href="{{ route('courses.index') }}" class="text-gray-700 dark:text-gray-300 hover:[color:#025f5a] transition font-medium">Courses</a>
            <a href="#latest" class="text-gray-700 dark:text-gray-300 hover:[color:#025f5a] transition font-medium">Artikel Terbaru</a>
            <a href="#insight" class="text-gray-700 dark:text-gray-300 hover:[color:#025f5a] transition font-medium">Wawasan</a>
            <a href="#newsletter" class="text-gray-700 dark:text-gray-300 hover:[color:#025f5a] transition font-medium">Newsletter</a>
            <button data-theme-toggle class="w-10 h-10 flex items-center justify-center rounded-full [background:rgba(255,255,255,0.08)] [border:1px_solid_rgba(255,255,255,0.12)] text-gray-300 hover:text-white transition">
                <i class="fa-solid fa-moon block dark:hidden"></i>
                <i class="fa-solid fa-sun hidden dark:block"></i>
            </button>
            <a href="#latest" class="px-6 py-3 [background:linear-gradient(135deg,#06b6d4_0%,#4f46e5_50%,#025f5a_100%)] rounded-full text-white font-semibold shadow-[0_8px_25px_rgba(20,184,166,0.3)] hover:shadow-[0_12px_35px_rgba(20,184,166,0.5)] transition-all hover:-translate-y-1">
                Jelajahi Blog
            </a>
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

<main class="pt-28 lg:pt-36 bg-white dark:[background:#0a0a0f]">
    <!-- Hero -->
    <section class="relative overflow-hidden [background:linear-gradient(135deg,#f8fafc_0%,#eef2ff_100%)] dark:[background:linear-gradient(135deg,#1e1e28_0%,#0a0a0f_100%)]">
        <div class="absolute w-[520px] h-[520px] [background:radial-gradient(circle,rgba(2,95,90,0.18)_0%,transparent_70%)] rounded-full -top-40 -left-28 opacity-80"></div>
        <div class="absolute w-[420px] h-[420px] [background:radial-gradient(circle,rgba(6,182,212,0.12)_0%,transparent_70%)] rounded-full -bottom-40 -right-20 opacity-60"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-10 py-24 lg:py-28 grid lg:grid-cols-[1.05fr_0.95fr] gap-14 items-center">
            <div class="space-y-8">
                <span class="inline-flex items-center gap-3 px-6 py-2 [background:rgba(2,95,90,0.12)] dark:[background:rgba(2,95,90,0.2)] [border:1.5px_solid_rgba(2,95,90,0.35)] rounded-full text-sm font-semibold [color:#025f5a] dark:text-teal-200">
                    <i class="fa-solid fa-newspaper"></i>
                    Update Insight Komunitas Tech Indonesia
                </span>
                <h1 class="text-5xl lg:text-6xl font-black leading-tight bg-clip-text text-transparent bg-linear-[135deg,#000_0%,#5eead4_40%,#025f5a_100%] dark:bg-linear-[135deg,#fff_0%,#5eead4_40%,#0ea5e9_100%]">
                    Cerita, Strategi, dan Tren Teknologi Terbaru dari MCI
                </h1>
                <p class="text-lg lg:text-xl [color:#64748b] dark:text-gray-300 leading-relaxed">
                    Jelajahi kurasi artikel yang mengupas tuntas perkembangan teknologi, pengalaman mentor, dan perjalanan alumni. Semua dirancang untuk membantu kamu tumbuh sebagai developer, kreator, dan pemimpin digital.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="#featured" class="px-8 py-4 [background:linear-gradient(135deg,#06b6d4,#025f5a)] rounded-full text-white font-semibold shadow-[0_12px_35px_rgba(20,184,166,0.35)] hover:shadow-[0_18px_45px_rgba(20,184,166,0.45)] transition-all hover:-translate-y-1">
                        Baca Sorotan Utama
                    </a>
                    <a href="#latest" class="px-8 py-4 [border:2px_solid_#025f5a] rounded-full [color:#025f5a] dark:text-teal-200 font-semibold hover:[background:rgba(2,95,90,0.08)] dark:hover:[background:rgba(2,95,90,0.25)] transition-all hover:-translate-y-1">
                        Artikel Terbaru
                    </a>
                </div>
            </div>
            <div class="bg-white/90 dark:bg-gray-900/60 border-2 border-teal-500/30 dark:border-teal-400/30 rounded-3xl p-8 shadow-[0_20px_60px_rgba(20,184,166,0.2)] backdrop-blur-xl space-y-6">
                @if ($heroPost)
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Sorotan Minggu Ini</p>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white line-clamp-2">{{ $heroPost->title }}</h3>
                        </div>
                        <span class="px-4 py-1 rounded-full text-xs font-semibold bg-teal-100 text-teal-700 dark:bg-teal-500/10 dark:text-teal-200">
                            {{ $heroPost->created_at?->translatedFormat('d M Y') ?? '—' }}
                        </span>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                        {{ $heroPost->excerpt }}
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                        <div class="p-4 rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900">
                            <p class="text-xs uppercase text-gray-400 mb-2">Penulis</p>
                            <p class="font-semibold text-gray-900 dark:text-white">{{ $heroPost->author ?? 'Tim MCI' }}</p>
                        </div>
                        <div class="p-4 rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900">
                            <p class="text-xs uppercase text-gray-400 mb-2">Waktu baca</p>
                            <p class="font-semibold text-gray-900 dark:text-white">{{ $heroPost->reading_time }}</p>
                        </div>
                        <div class="p-4 rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900">
                            <p class="text-xs uppercase text-gray-400 mb-2">Dipublikasikan</p>
                            <p class="font-semibold text-gray-900 dark:text-white">{{ $heroPost->created_at?->translatedFormat('d M Y, H:i') ?? '—' }}</p>
                        </div>
                        <div class="p-4 rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 flex items-center justify-between">
                            <p class="text-xs uppercase text-gray-400">Aksi</p>
                            <a href="{{ route('blog.show', $heroPost->slug) }}" class="inline-flex items-center gap-2 text-teal-600 dark:text-teal-200 font-semibold hover:text-teal-500">
                                Baca Selengkapnya
                                <i class="fa-solid fa-arrow-right-long"></i>
                            </a>
                        </div>
                    </div>
                @else
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Topik Hangat</p>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Inside MCI Community</h3>
                        </div>
                        <span class="px-4 py-1 rounded-full text-xs font-semibold bg-teal-100 text-teal-700 dark:bg-teal-500/10 dark:text-teal-200">Edisi Oktober</span>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                        Mentor kami merangkum highlight pembelajaran sepekan, best practice projek open source, dan roadmap karir yang bisa langsung kamu adaptasi.
                    </p>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div class="p-4 rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900">
                            <p class="text-xs uppercase text-gray-400 mb-2">Kategori Populer</p>
                            <p class="font-semibold text-gray-900 dark:text-white">AI & Machine Learning</p>
                        </div>
                        <div class="p-4 rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900">
                            <p class="text-xs uppercase text-gray-400 mb-2">Rata-rata waktu baca</p>
                            <p class="font-semibold text-gray-900 dark:text-white">6 menit</p>
                        </div>
                        <div class="p-4 rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900">
                            <p class="text-xs uppercase text-gray-400 mb-2">Kontributor</p>
                            <p class="font-semibold text-gray-900 dark:text-white">35 mentor aktif</p>
                        </div>
                        <div class="p-4 rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900">
                            <p class="text-xs uppercase text-gray-400 mb-2">Komunitas</p>
                            <p class="font-semibold text-gray-900 dark:text-white">125K pembaca</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Trending Topics -->
    <section class="py-20" id="featured">
        <div class="max-w-7xl mx-auto px-6 lg:px-10">
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6 mb-12">
                <div>
                    <span class="text-sm font-semibold uppercase tracking-[0.3em] [color:#025f5a]">Tagar Pilihan</span>
                    <h2 class="text-4xl lg:text-5xl font-black text-gray-900 dark:text-white mt-4">Topik yang Sedang Dibicarakan</h2>
                </div>
                <p class="max-w-2xl text-gray-500 dark:text-gray-300 text-lg">
                    Tetap relevan dengan mengikuti diskusi utama komunitas: mulai dari pengembangan AI, produktivitas tim engineering, hingga strategi membangun personal branding sebagai developer.
                </p>
            </div>

            @php
                $tags = [
                    ['label' => 'AI Engineering', 'gradient' => 'from-cyan-500 to-teal-500'],
                    ['label' => 'Career Growth', 'gradient' => 'from-indigo-500 to-purple-500'],
                    ['label' => 'Open Source', 'gradient' => 'from-emerald-500 to-teal-400'],
                    ['label' => 'Community Story', 'gradient' => 'from-pink-500 to-rose-500'],
                    ['label' => 'Product Design', 'gradient' => 'from-amber-500 to-orange-500'],
                    ['label' => 'Remote Work', 'gradient' => 'from-blue-500 to-sky-500'],
                    ['label' => 'Tech Leadership', 'gradient' => 'from-slate-500 to-slate-700'],
                    ['label' => 'Dev Productivity', 'gradient' => 'from-violet-500 to-purple-600'],
                ];
            @endphp

            <div class="flex flex-wrap gap-4">
                @foreach ($tags as $tag)
                    <a href="#latest" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r {{ $tag['gradient'] }} text-white rounded-full text-sm font-semibold shadow-[0_10px_25px_rgba(20,184,166,0.2)] hover:-translate-y-1 transition">
                        <i class="fa-solid fa-hashtag text-xs"></i>
                        {{ $tag['label'] }}
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Featured Stories -->
    <section class="py-10">
        <div class="max-w-7xl mx-auto px-6 lg:px-10">
            @if ($heroPost)
                <div class="grid lg:grid-cols-[1.4fr_1fr] gap-10">
                    <article class="relative overflow-hidden rounded-3xl border border-gray-200 dark:border-gray-800 bg-gradient-to-br from-gray-900 via-gray-900 to-gray-800 text-white shadow-[0_22px_55px_rgba(2,95,90,0.25)]">
                        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(94,234,212,0.2),transparent_60%)]"></div>
                        <div class="relative p-10 lg:p-12 flex flex-col min-h-[420px]">
                            <span class="inline-flex items-center gap-2 px-4 py-2 bg-white/15 rounded-full text-xs font-semibold uppercase tracking-widest">
                                Sorotan Utama
                            </span>
                            <a href="{{ route('blog.show', $heroPost->slug) }}" class="mt-6 text-3xl lg:text-4xl font-black leading-tight text-white hover:text-teal-200 transition">
                                {{ $heroPost->title }}
                            </a>
                            <p class="mt-4 text-gray-200 text-base leading-relaxed">
                                {{ $heroPost->excerpt }}
                            </p>
                            <div class="mt-8 flex items-center justify-between text-sm text-gray-200">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-white/15 flex items-center justify-center font-semibold">
                                        {{ Str::upper(Str::substr($heroPost->author ?? 'MCI', 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold">{{ $heroPost->author ?? 'Tim MCI' }}</p>
                                        <p class="text-xs text-gray-300">{{ $heroPost->created_at?->translatedFormat('d M Y, H:i') ?? '—' }}</p>
                                    </div>
                                </div>
                                <div class="text-xs uppercase tracking-widest">{{ $heroPost->reading_time }}</div>
                            </div>
                            <a href="{{ route('blog.show', $heroPost->slug) }}" class="mt-6 inline-flex items-center gap-3 text-sm font-semibold text-white hover:text-teal-200 transition">
                                Baca Selengkapnya
                                <i class="fa-solid fa-arrow-right-long"></i>
                            </a>
                        </div>
                    </article>

                    <div class="space-y-6">
                        @forelse ($secondaryFeatured as $featured)
                            <article class="group p-8 rounded-3xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 hover:-translate-y-1 hover:[border-color:#025f5a] transition-all">
                                <span class="inline-flex items-center gap-2 px-3 py-1 bg-teal-100 dark:bg-teal-500/10 text-teal-700 dark:text-teal-200 text-xs font-bold uppercase tracking-widest">Sorotan Blog</span>
                                <a href="{{ route('blog.show', $featured->slug) }}" class="mt-4 block text-2xl font-bold text-gray-900 dark:text-white group-hover:text-teal-500">
                                    {{ $featured->title }}
                                </a>
                                <p class="mt-3 text-gray-500 dark:text-gray-300 leading-relaxed">{{ $featured->excerpt }}</p>
                                <div class="mt-6 flex items-center justify-between text-sm text-gray-400">
                                    <span>{{ $featured->reading_time }}</span>
                                    <span>Dipublikasikan {{ $featured->created_at?->translatedFormat('d M Y') ?? '—' }}</span>
                                </div>
                            </article>
                        @empty
                            <article class="group p-8 rounded-3xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900">
                                <span class="inline-flex items-center gap-2 px-3 py-1 bg-teal-100 dark:bg-teal-500/10 text-teal-700 dark:text-teal-200 text-xs font-bold uppercase tracking-widest">Community Story</span>
                                <h3 class="mt-4 text-2xl font-bold text-gray-900 dark:text-white">Bangun Portofolio Open Source yang Memikat Rekruter Global</h3>
                                <p class="mt-3 text-gray-500 dark:text-gray-300 leading-relaxed">Strategi alumni MCI membawa projek komunitas menjadi bukti kompetensi saat proses hiring di perusahaan unicorn Asia Tenggara.</p>
                                <div class="mt-6 flex items-center justify-between text-sm text-gray-400">
                                    <span>5 menit baca</span>
                                    <span>Dipublikasikan 18 Okt 2025</span>
                                </div>
                            </article>
                            <article class="group p-8 rounded-3xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900">
                                <span class="inline-flex items-center gap-2 px-3 py-1 bg-purple-100 dark:bg-purple-500/10 text-purple-700 dark:text-purple-200 text-xs font-bold uppercase tracking-widest">Leadership</span>
                                <h3 class="mt-4 text-2xl font-bold text-gray-900 dark:text-white">Mendesain Ritual Tech Sync yang Efektif untuk Tim Remote</h3>
                                <p class="mt-3 text-gray-500 dark:text-gray-300 leading-relaxed">Checklist fasilitasi pertemuan mingguan agar alignment produk dan engineering tetap solid meski tim tersebar lintas zona waktu.</p>
                                <div class="mt-6 flex items-center justify-between text-sm text-gray-400">
                                    <span>7 menit baca</span>
                                    <span>Dipublikasikan 16 Okt 2025</span>
                                </div>
                            </article>
                        @endforelse
                    </div>
                </div>
            @else
                <div class="grid lg:grid-cols-[1.4fr_1fr] gap-10">
                    <article class="relative overflow-hidden rounded-3xl border border-gray-200 dark:border-gray-800 bg-gray-900 text-white shadow-[0_22px_55px_rgba(2,95,90,0.25)]">
                        <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/40 to-transparent"></div>
                        <img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=1400&q=80" alt="AI collaboration" class="w-full h-full object-cover opacity-60">
                        <div class="relative p-10 lg:p-12 flex flex-col justify-end min-h-[420px]">
                            <span class="inline-flex items-center gap-2 px-4 py-2 bg-white/15 rounded-full text-xs font-semibold uppercase tracking-widest">
                                Future of Work
                            </span>
                            <h3 class="mt-6 text-3xl lg:text-4xl font-black leading-tight">
                                Menggabungkan AI Copilot dengan Workflow Tim Engineering: Panduan Praktis dari Mentor MCI
                            </h3>
                            <p class="mt-4 text-gray-200 text-base leading-relaxed">
                                Temukan framework kolaborasi manusia dan mesin yang terbukti mempercepat delivery produk tanpa mengorbankan kualitas kode ataupun keamanan.
                            </p>
                            <div class="mt-8 flex items-center justify-between text-sm text-gray-200">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center font-semibold">AR</div>
                                    <div>
                                        <p class="font-semibold">Ayu Rahmadani</p>
                                        <p class="text-xs text-gray-300">Lead Mentor Machine Learning</p>
                                    </div>
                                </div>
                                <div class="text-xs uppercase tracking-widest">12 menit baca</div>
                            </div>
                        </div>
                    </article>

                    <div class="space-y-6">
                        <article class="group p-8 rounded-3xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 hover:-translate-y-1 hover:[border-color:#025f5a] transition-all">
                            <span class="inline-flex items-center gap-2 px-3 py-1 bg-teal-100 dark:bg-teal-500/10 text-teal-700 dark:text-teal-200 text-xs font-bold uppercase tracking-widest">Community Story</span>
                            <h3 class="mt-4 text-2xl font-bold text-gray-900 dark:text-white group-hover:text-teal-500">Bangun Portofolio Open Source yang Memikat Rekruter Global</h3>
                            <p class="mt-3 text-gray-500 dark:text-gray-300 leading-relaxed">Strategi alumni MCI membawa projek komunitas menjadi bukti kompetensi saat proses hiring di perusahaan unicorn Asia Tenggara.</p>
                            <div class="mt-6 flex items-center justify-between text-sm text-gray-400">
                                <span>5 menit baca</span>
                                <span>Dipublikasikan 18 Okt 2025</span>
                            </div>
                        </article>
                        <article class="group p-8 rounded-3xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 hover:-translate-y-1 hover:[border-color:#025f5a] transition-all">
                            <span class="inline-flex items-center gap-2 px-3 py-1 bg-purple-100 dark:bg-purple-500/10 text-purple-700 dark:text-purple-200 text-xs font-bold uppercase tracking-widest">Leadership</span>
                            <h3 class="mt-4 text-2xl font-bold text-gray-900 dark:text-white group-hover:text-purple-500">Mendesain Ritual Tech Sync yang Efektif untuk Tim Remote</h3>
                            <p class="mt-3 text-gray-500 dark:text-gray-300 leading-relaxed">Checklist fasilitasi pertemuan mingguan agar alignment produk dan engineering tetap solid meski tim tersebar lintas zona waktu.</p>
                            <div class="mt-6 flex items-center justify-between text-sm text-gray-400">
                                <span>7 menit baca</span>
                                <span>Dipublikasikan 16 Okt 2025</span>
                            </div>
                        </article>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <!-- Latest Articles -->
    <section class="py-20 [background:linear-gradient(135deg,#f8fafc_0%,#eef2ff_100%)] dark:[background:linear-gradient(135deg,#1e1e28_0%,#12121c_100%)]" id="latest">
        <div class="max-w-7xl mx-auto px-6 lg:px-10">
            <div class="flex items-center justify-between gap-6 mb-12">
                <div>
                    <span class="text-sm font-semibold uppercase tracking-[0.3em] [color:#025f5a]">Artikel Terbaru</span>
                    <h2 class="text-4xl font-black text-gray-900 dark:text-white mt-4">Insight Segar untuk Level-up Skillmu</h2>
                </div>
                <a href="#newsletter" class="hidden md:inline-flex items-center gap-2 px-6 py-3 rounded-full text-sm font-semibold [color:#025f5a] border border-teal-500/40 hover:[background:rgba(2,95,90,0.08)] transition">
                    Langganan update
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            @php
                $gradients = [
                    'from-slate-900 via-slate-800 to-slate-900',
                    'from-indigo-500 via-purple-500 to-pink-500',
                    'from-cyan-500 via-teal-500 to-emerald-500',
                    'from-orange-500 via-amber-500 to-yellow-400',
                    'from-blue-600 via-sky-500 to-cyan-500',
                    'from-fuchsia-500 via-rose-500 to-red-500',
                ];
            @endphp

            @if (count($articles))
                <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-8">
                    @foreach ($articles as $article)
                        <article class="group relative rounded-3xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 overflow-hidden hover:-translate-y-2 transition-all">
                            <div class="h-44 bg-gradient-to-br {{ $gradients[$loop->index % count($gradients)] }} relative">
                                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,rgba(255,255,255,0.25),transparent_60%)]"></div>
                                <div class="absolute top-5 left-5 px-4 py-2 rounded-full bg-white/15 text-white text-xs font-semibold uppercase tracking-widest">
                                    Blog MCI
                                </div>
                            </div>
                            <div class="p-8 space-y-4">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white leading-snug">
                                    <a href="{{ route('blog.show', $article->slug) }}" class="group-hover:[color:#025f5a] transition">
                                        {{ $article->title }}
                                    </a>
                                </h3>
                                <p class="text-gray-500 dark:text-gray-300 text-sm leading-relaxed">
                                    {{ $article->excerpt }}
                                </p>
                                <div class="flex items-center justify-between text-xs text-gray-400">
                                    <div>
                                        <p class="font-semibold text-gray-700 dark:text-gray-200">{{ $article->author ?? 'Tim MCI' }}</p>
                                        <p class="mt-1 uppercase tracking-widest text-teal-500 dark:text-teal-300">{{ $article->reading_time }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p>{{ $article->created_at?->translatedFormat('d M Y') ?? '—' }}</p>
                                        <p class="mt-1 uppercase tracking-widest">{{ $article->created_at?->translatedFormat('H:i') ?? '' }}</p>
                                    </div>
                                </div>
                                <div class="flex justify-end">
                                    <a href="{{ route('blog.show', $article->slug) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-teal-600 dark:text-teal-200 hover:text-teal-500">
                                        Baca Selengkapnya
                                        <i class="fa-solid fa-arrow-right-long"></i>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                @php
                    $blogPaginator = is_object($articles) ? $articles : null;
                @endphp

                @if ($blogPaginator)
                    <div class="mt-10">
                        {{ $blogPaginator->links() }}
                    </div>
                @endif
            @else
                <div class="rounded-3xl border border-dashed border-gray-300 dark:border-gray-700 p-16 text-center text-gray-500 dark:text-gray-400">
                    Belum ada artikel yang dipublikasikan. Nantikan update terbaru dari tim MCI.
                </div>
            @endif
        </div>
    </section>

    <!-- Insight & Resources -->
    <section class="py-20" id="insight">
        <div class="max-w-7xl mx-auto px-6 lg:px-10 grid lg:grid-cols-[1.1fr_0.9fr] gap-10">
            <div class="p-10 rounded-3xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 shadow-[0_20px_40px_rgba(15,118,110,0.1)]">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-sm font-semibold uppercase tracking-[0.3em] [color:#025f5a]">Wawasan Mentor</span>
                        <h3 class="text-3xl font-bold text-gray-900 dark:text-white mt-3">Podcast & Video Highlight</h3>
                    </div>
                    <span class="px-4 py-1 rounded-full text-xs font-semibold bg-teal-500/10 text-teal-500">New</span>
                </div>
                <p class="mt-6 text-gray-500 dark:text-gray-300 leading-relaxed">
                    Dengarkan diskusi eksklusif bersama mentor seputar automation, karir tech, dan membangun komunitas yang inklusif. Semua bisa kamu akses kapan saja.
                </p>
                <div class="mt-8 space-y-5">
                    @php
                        $episodes = [
                            ['title' => 'Growth Mindset untuk Founder Tech', 'duration' => '28 menit', 'icon' => 'fa-solid fa-microphone'],
                            ['title' => 'Cara Membangun Tim Data dari Nol', 'duration' => '34 menit', 'icon' => 'fa-solid fa-waveform-lines'],
                            ['title' => 'Framework Latihan Problem Solving Harian', 'duration' => '22 menit', 'icon' => 'fa-solid fa-podcast'],
                        ];
                    @endphp
                    @foreach ($episodes as $episode)
                        <div class="flex items-center gap-4 p-4 rounded-2xl border border-gray-200 dark:border-gray-800 hover:[border-color:#025f5a] transition">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-teal-500 to-cyan-500 text-white flex items-center justify-center text-lg">
                                <i class="{{ $episode['icon'] }}"></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-900 dark:text-white">{{ $episode['title'] }}</p>
                                <p class="text-xs text-gray-400 uppercase tracking-widest mt-1">{{ $episode['duration'] }}</p>
                            </div>
                            <button class="px-4 py-2 text-sm font-semibold rounded-full [color:#025f5a] dark:text-teal-200 border border-teal-500/40 hover:[background:rgba(2,95,90,0.08)] transition">Putar</button>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="p-10 rounded-3xl border border-gray-200 dark:border-gray-800 bg-gray-900 text-white relative overflow-hidden">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,rgba(94,234,212,0.35),transparent_60%)]"></div>
                <div class="relative">
                    <span class="text-sm font-semibold uppercase tracking-[0.3em] text-teal-200">Toolkit</span>
                    <h3 class="text-3xl font-bold mt-3">Panduan Premium untuk Anggota</h3>
                    <p class="mt-5 text-gray-200 leading-relaxed">Download materi eksklusif berupa template, cheat sheet, dan playbook untuk mendukung produktivitasmu.</p>

                    <div class="mt-8 space-y-5">
                        <div class="p-5 rounded-2xl bg-white/10 border border-white/20">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-semibold">Checklist Implementasi AI di Startup</p>
                                    <p class="text-xs text-teal-200 uppercase tracking-widest mt-1">PDF · 18 halaman</p>
                                </div>
                                <i class="fa-solid fa-cloud-arrow-down text-2xl"></i>
                            </div>
                        </div>
                        <div class="p-5 rounded-2xl bg-white/10 border border-white/20">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-semibold">Template Retro Sprint Hybrid Team</p>
                                    <p class="text-xs text-teal-200 uppercase tracking-widest mt-1">Miro · 4 board</p>
                                </div>
                                <i class="fa-solid fa-file-arrow-down text-2xl"></i>
                            </div>
                        </div>
                        <div class="p-5 rounded-2xl bg-white/10 border border-white/20">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-semibold">Playbook Kolaborasi Designer & Engineer</p>
                                    <p class="text-xs text-teal-200 uppercase tracking-widest mt-1">Notion · 6 template</p>
                                </div>
                                <i class="fa-solid fa-box-open text-2xl"></i>
                            </div>
                        </div>
                    </div>

                    <button class="mt-8 w-full px-6 py-4 rounded-full font-semibold bg-white text-gray-900 hover:bg-gray-100 transition">Akses Toolkit</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter CTA -->
    <section id="newsletter" class="py-24 [background:linear-gradient(135deg,#06b6d4_0%,#4f46e5_50%,#025f5a_100%)] text-white relative overflow-hidden">
        <div class="absolute w-[460px] h-[460px] [background:radial-gradient(circle,rgba(255,255,255,0.18)_0%,transparent_70%)] rounded-full -top-24 -right-20"></div>
        <div class="absolute w-[380px] h-[380px] [background:radial-gradient(circle,rgba(255,255,255,0.12)_0%,transparent_70%)] rounded-full -bottom-24 -left-12"></div>

        <div class="relative z-10 max-w-4xl mx-auto px-6 lg:px-10 text-center">
            <h2 class="text-4xl lg:text-5xl font-black leading-tight">Langganan Newsletter MCI Blog</h2>
            <p class="mt-6 text-lg text-white/80 leading-relaxed">
                Dapatkan insight mingguan seputar teknologi, produktivitas, dan kisah komunitas langsung di inbox kamu. Tanpa spam, hanya konten bernilai.
            </p>
            <form class="mt-10 max-w-3xl mx-auto flex flex-col sm:flex-row gap-4">
                <input type="email" class="flex-1 px-6 py-4 rounded-full text-gray-900 focus:outline-none focus:ring-4 focus:ring-white/40" placeholder="Masukkan email terbaikmu">
                <button type="submit" class="px-8 py-4 rounded-full font-semibold bg-white text-gray-900 hover:bg-gray-100 transition">Gabung Sekarang</button>
            </form>
            <p class="mt-4 text-sm text-white/70">Lebih dari 50.000 anggota komunitas sudah berlangganan.</p>
        </div>
    </section>
</main>

<!-- Footer -->
<footer class="bg-white dark:[background:#0a0a0f] py-16 px-6 lg:px-10 [border-top:1px_solid_rgba(0,0,0,0.06)] dark:[border-top:1px_solid_rgba(255,255,255,0.05)]">
    <div class="max-w-7xl mx-auto grid md:grid-cols-2 lg:grid-cols-4 gap-14">
        <div>
            <h3 class="text-2xl font-black mb-5" style="background: linear-gradient(135deg, #06b6d4, #025f5a); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                MCI Blog
            </h3>
            <p class="text-gray-500 dark:text-gray-300 leading-relaxed mb-5">
                Platform konten dari MCI (Majelis Coding Indonesia) yang menyajikan insight terkini dunia teknologi, karir digital, dan perjalanan komunitas kami.
            </p>
            <div class="flex gap-4">
                <a href="#" aria-label="YouTube" class="w-10 h-10 rounded-full [background:rgba(2,95,90,0.08)] [border:1px_solid_rgba(2,95,90,0.25)] flex items-center justify-center text-[#025f5a] hover:[background:linear-gradient(135deg,#06b6d4,#025f5a)] hover:text-white transition">
                    <i class="fa-brands fa-youtube"></i>
                </a>
                <a href="#" aria-label="Spotify" class="w-10 h-10 rounded-full [background:rgba(2,95,90,0.08)] [border:1px_solid_rgba(2,95,90,0.25)] flex items-center justify-center text-[#025f5a] hover:[background:linear-gradient(135deg,#06b6d4,#025f5a)] hover:text-white transition">
                    <i class="fa-brands fa-spotify"></i>
                </a>
                <a href="#" aria-label="LinkedIn" class="w-10 h-10 rounded-full [background:rgba(2,95,90,0.08)] [border:1px_solid_rgba(2,95,90,0.25)] flex items-center justify-center text-[#025f5a] hover:[background:linear-gradient(135deg,#06b6d4,#025f5a)] hover:text-white transition">
                    <i class="fa-brands fa-linkedin-in"></i>
                </a>
                <a href="#" aria-label="X" class="w-10 h-10 rounded-full [background:rgba(2,95,90,0.08)] [border:1px_solid_rgba(2,95,90,0.25)] flex items-center justify-center text-[#025f5a] hover:[background:linear-gradient(135deg,#06b6d4,#025f5a)] hover:text-white transition">
                    <i class="fa-brands fa-x-twitter"></i>
                </a>
            </div>
        </div>

        <div>
            <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-5">Kategori</h4>
            <ul class="space-y-3 text-gray-500 dark:text-gray-300">
                @foreach (['Engineering Insights', 'Career Stories', 'Product Design', 'Community Update', 'Remote Work'] as $item)
                    <li><a href="#latest" class="hover:[color:#025f5a] dark:hover:text-teal-200 transition">{{ $item }}</a></li>
                @endforeach
            </ul>
        </div>

        <div>
            <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-5">Sumber Daya</h4>
            <ul class="space-y-3 text-gray-500 dark:text-gray-300">
                @foreach (['Playbook Mentoring', 'Template Produktivitas', 'Roadmap Karir', 'Event & Webinar', 'Podcast Series'] as $item)
                    <li><a href="#insight" class="hover:[color:#025f5a] dark:hover:text-teal-200 transition">{{ $item }}</a></li>
                @endforeach
            </ul>
        </div>

        <div>
            <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-5">Hubungi Kami</h4>
            <ul class="space-y-3 text-gray-500 dark:text-gray-300">
                <li>Email: <a href="mailto:hello@majeliscoding.id" class="hover:[color:#025f5a] dark:hover:text-teal-200 transition">hello@majeliscoding.id</a></li>
                <li>Komunitas Discord</li>
                <li>MCI Tech Space, Jakarta</li>
                <li>WhatsApp Support: +62 811-2233-4455</li>
            </ul>
        </div>
    </div>
    <div class="mt-12 pt-8 text-center text-sm text-gray-500 dark:text-gray-400 [border-top:1px_solid_rgba(0,0,0,0.06)] dark:[border-top:1px_solid_rgba(255,255,255,0.05)]">
        <p>&copy; 2025 MCI (Majelis Coding Indonesia). Dibuat dengan semangat berbagi ilmu.</p>
    </div>
</footer>
@endsection

@push('scripts')
<script>
    const blogNavbar = document.getElementById('navbar');
    if (blogNavbar) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 40) {
                blogNavbar.classList.add('bg-white/80', 'dark:bg-gray-950/70', 'shadow-[0_10px_30px_rgba(2,95,90,0.15)]');
            } else {
                blogNavbar.classList.remove('bg-white/80', 'dark:bg-gray-950/70', 'shadow-[0_10px_30px_rgba(2,95,90,0.15)]');
            }
        });
    }

    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', (event) => {
            const targetId = anchor.getAttribute('href');
            if (targetId.length <= 1) {
                return;
            }

            const target = document.querySelector(targetId);
            if (!target) {
                return;
            }

            event.preventDefault();
            window.scrollTo({
                top: target.offsetTop - 80,
                behavior: 'smooth'
            });
        });
    });
</script>
@endpush
