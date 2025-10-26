@extends('layouts.app')

@php
    use Illuminate\Support\Str;
@endphp

@section('title', $blog->title.' - MCI Blog')

@section('content')
<!-- Navbar -->
<nav id="navbar" class="fixed top-0 w-full z-50 transition-all duration-300 backdrop-blur-lg border-b [border-color:rgba(2,95,90,0.12)] dark:border-white/10">
    <div class="max-w-7xl mx-auto px-6 lg:px-10 py-6 flex items-center justify-between">
        <a href="{{ route('home') }}" class="flex items-center gap-3 cursor-pointer">
            <img src="{{ asset('assets/logo/putih.png') }}" alt="MCI (Majelis Coding Indonesia)" class="h-11 w-auto dark:block hidden">
            <img src="{{ asset('assets/logo/hijau.png') }}" alt="MCI (Majelis Coding Indonesia)" class="h-11 w-auto dark:hidden block">
        </a>

        <div class="hidden md:flex items-center gap-10">
            <a href="{{ route('blog.index') }}" class="text-gray-700 dark:text-gray-300 hover:[color:#025f5a] transition font-medium">Blog</a>
            <a href="{{ route('courses.index') }}" class="text-gray-700 dark:text-gray-300 hover:[color:#025f5a] transition font-medium">Courses</a>
            <a href="#related" class="text-gray-700 dark:text-gray-300 hover:[color:#025f5a] transition font-medium">Artikel Terkait</a>
            <button data-theme-toggle class="w-10 h-10 flex items-center justify-center rounded-full [background:rgba(255,255,255,0.08)] [border:1px_solid_rgba(255,255,255,0.12)] text-gray-300 hover:text-white transition">
                <i class="fa-solid fa-moon block dark:hidden"></i>
                <i class="fa-solid fa-sun hidden dark:block"></i>
            </button>
            <a href="{{ route('blog.index') }}#newsletter" class="px-6 py-3 [background:linear-gradient(135deg,#06b6d4_0%,#4f46e5_50%,#025f5a_100%)] rounded-full text-white font-semibold shadow-[0_8px_25px_rgba(20,184,166,0.3)] hover:shadow-[0_12px_35px_rgba(20,184,166,0.5)] transition-all hover:-translate-y-1">
                Newsletter
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
    <section class="relative overflow-hidden [background:linear-gradient(135deg,#f8fafc_0%,#eef2ff_100%)] dark:[background:linear-gradient(135deg,#1e1e28_0%,#0a0a0f_100%)]">
        <div class="absolute w-[520px] h-[520px] [background:radial-gradient(circle,rgba(2,95,90,0.18)_0%,transparent_70%)] rounded-full -top-40 -left-28 opacity-80"></div>
        <div class="absolute w-[420px] h-[420px] [background:radial-gradient(circle,rgba(6,182,212,0.12)_0%,transparent_70%)] rounded-full -bottom-40 -right-20 opacity-60"></div>

        <div class="relative z-10 max-w-4xl mx-auto px-6 lg:px-10 py-24 lg:py-28">
            <div class="flex items-center gap-4 text-sm text-teal-600 dark:text-teal-300 font-semibold uppercase tracking-widest mb-6">
                <span class="inline-flex items-center gap-2 px-4 py-1 rounded-full bg-teal-500/10 text-teal-600 dark:text-teal-200">
                    <i class="fa-solid fa-book-open"></i>
                    Blog MCI
                </span>
                <span>{{ $blog->created_at?->translatedFormat('d M Y, H:i') ?? '—' }}</span>
            </div>
            <h1 class="text-4xl lg:text-6xl font-black text-gray-900 dark:text-white leading-tight mb-6">
                {{ $blog->title }}
            </h1>
            <div class="flex flex-wrap gap-6 text-sm text-gray-500 dark:text-gray-300">
                <div class="flex items-center gap-3">
                    <span class="w-10 h-10 rounded-full [background:linear-gradient(135deg,#06b6d4,#025f5a)] text-white flex items-center justify-center font-semibold">
                        {{ Str::upper(Str::substr($blog->author ?? 'MCI', 0, 2)) }}
                    </span>
                    <div>
                        <p class="font-semibold text-gray-900 dark:text-white">{{ $blog->author ?? 'Tim MCI' }}</p>
                        <p class="text-xs uppercase tracking-widest text-teal-600 dark:text-teal-300">{{ $blog->reading_time }} baca</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <article class="relative z-10 max-w-5xl mx-auto px-6 lg:px-16 -mt-24">
    <div class="rounded-[2.75rem] border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 p-12 lg:p-20 shadow-[0_28px_80px_rgba(2,95,90,0.14)] space-y-14">
            <div class="prose prose-2xl dark:prose-invert max-w-none prose-headings:[color:#025f5a] dark:prose-headings:text-teal-200 prose-a:text-teal-600 dark:prose-a:text-teal-300 prose-strong:text-gray-900 dark:prose-strong:text-white">
                {!! $blog->content_html !!}
            </div>
        </div>
    </article>

    @if ($related->isNotEmpty())
        <section id="related" class="max-w-7xl mx-auto px-6 lg:px-10 mt-24 mb-24">
            <div class="flex items-center justify-between mb-10">
                <div>
                    <p class="text-xs uppercase tracking-[0.3em] [color:#025f5a] font-semibold">Artikel Terkait</p>
                    <h2 class="text-3xl font-black text-gray-900 dark:text-white mt-2">Baca juga insight lainnya</h2>
                </div>
                <a href="{{ route('blog.index') }}" class="text-sm font-semibold text-teal-600 dark:text-teal-300 hover:text-teal-500">
                    Lihat semua
                </a>
            </div>

            <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-8">
                @foreach ($related as $item)
                    <article class="group rounded-3xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 p-7 hover:-translate-y-2 hover:[border-color:#025f5a] transition">
                        <p class="text-xs uppercase font-semibold text-teal-600 dark:text-teal-300 tracking-widest">Blog MCI</p>
                        <h3 class="mt-4 text-xl font-bold text-gray-900 dark:text-white leading-snug">
                            <a href="{{ route('blog.show', $item->slug) }}" class="group-hover:[color:#025f5a] transition">{{ $item->title }}</a>
                        </h3>
                        <p class="mt-3 text-sm text-gray-500 dark:text-gray-300 leading-relaxed">
                            {{ $item->excerpt }}
                        </p>
                        <div class="mt-6 flex items-center justify-between text-xs text-gray-400">
                            <span>{{ $item->author ?? 'Tim MCI' }}</span>
                            <span>{{ $item->created_at?->translatedFormat('d M Y') ?? '—' }}</span>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    @endif
</main>

<!-- Footer -->
<footer class="bg-white dark:[background:#0a0a0f] py-16 px-6 lg:px-10 [border-top:1px_solid_rgba(0,0,0,0.06)] dark:[border-top:1px_solid_rgba(255,255,255,0.05)]">
    <div class="max-w-7xl mx-auto grid md:grid-cols-2 lg:grid-cols-4 gap-14">
        <div>
            <h3 class="text-2xl font-black mb-5" style="background: linear-gradient(135deg, #06b6d4, #025f5a); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                MCI Blog
            </h3>
            <p class="text-gray-500 dark:text-gray-300 leading-relaxed mb-5">
                Insight teknologi, perjalanan karir, dan kisah komunitas dari Majelis Coding Indonesia.
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
                    <li><a href="{{ route('blog.index') }}#latest" class="hover:[color:#025f5a] dark:hover:text-teal-200 transition">{{ $item }}</a></li>
                @endforeach
            </ul>
        </div>

        <div>
            <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-5">Sumber Daya</h4>
            <ul class="space-y-3 text-gray-500 dark:text-gray-300">
                @foreach (['Playbook Mentoring', 'Template Produktivitas', 'Roadmap Karir', 'Event & Webinar', 'Podcast Series'] as $item)
                    <li><a href="{{ route('blog.index') }}#insight" class="hover:[color:#025f5a] dark:hover:text-teal-200 transition">{{ $item }}</a></li>
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

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css" integrity="sha512-03QMGsOs9TPdppbjVBQnYQSgIbJ79uS2MzJ9eCA6T8P06X6BkUJzudkG+Ud+SKKTgwyzmDQIDKD5sCYJBPuXHw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .code-block-wrapper {
            position: relative;
            border-radius: 1.25rem;
            overflow: hidden;
        }

        .copy-snippet-button {
            position: absolute;
            top: 0.8rem;
            right: 0.8rem;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.45rem 0.85rem;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 600;
            background: rgba(15, 118, 110, 0.08);
            color: #0f766e;
            border: 1px solid rgba(15, 118, 110, 0.22);
            cursor: pointer;
            transition: all 0.2s;
            backdrop-filter: blur(6px);
        }

        .dark .copy-snippet-button {
            background: rgba(45, 212, 191, 0.12);
            border-color: rgba(45, 212, 191, 0.3);
            color: #5eead4;
        }

        .copy-snippet-button:hover {
            transform: translateY(-1px);
            box-shadow: 0 12px 28px rgba(15, 118, 110, 0.18);
        }

        .prose pre {
            border-radius: 1.25rem;
            border: 1px solid rgba(148, 163, 184, 0.15);
            background: rgba(15, 23, 42, 0.95);
            padding: 2.6rem 1.6rem 1.6rem 1.6rem;
            position: relative;
        }

        .dark .prose pre {
            border-color: rgba(94, 234, 212, 0.18);
            background: rgba(10, 12, 16, 0.95);
        }

        .prose pre code {
            font-size: 0.95rem;
            line-height: 1.7;
        }
    </style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js" integrity="sha512-4MtBtGIIDLHSdZ7ejUmCUjT85JXQBu9yc9uCLPrk3d2MGDbqzPo8SufbTFDeDRrP/Cdqfv9lv7kXgxIiofQcpg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
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

        document.querySelectorAll('pre code').forEach((block) => {
            if (typeof hljs !== 'undefined') {
                hljs.highlightElement(block);
            }

            const wrapper = block.parentElement;
            if (!wrapper.classList.contains('code-block-wrapper')) {
                wrapper.classList.add('code-block-wrapper');
            }

            if (!wrapper.querySelector('.copy-snippet-button')) {
                const button = document.createElement('button');
                button.className = 'copy-snippet-button';
                button.innerHTML = '<i class="fa-solid fa-copy"></i> Salin kode';
                button.addEventListener('click', () => {
                    navigator.clipboard.writeText(block.textContent).then(() => {
                        const original = button.innerHTML;
                        button.innerHTML = '<i class="fa-solid fa-check"></i> Disalin';
                        setTimeout(() => {
                            button.innerHTML = original;
                        }, 2000);
                    }).catch(() => {
                        button.innerHTML = '<i class="fa-solid fa-circle-exclamation"></i> Gagal';
                        setTimeout(() => {
                            button.innerHTML = '<i class="fa-solid fa-copy"></i> Salin kode';
                        }, 2000);
                    });
                });

                wrapper.insertBefore(button, wrapper.firstChild);
            }
        });
    });
</script>
@endpush
