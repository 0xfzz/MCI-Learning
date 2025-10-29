@extends('layouts.dashboard')

@section('title', 'Kelola Artikel Blog - MCI Admin')

@section('search-placeholder', 'Cari artikel blog...')

@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <p class="text-xs uppercase tracking-[0.3em] text-gray-400 dark:text-gray-500 font-semibold">Manajemen Konten</p>
        <h1 class="text-3xl font-black text-gray-900 dark:text-gray-100">Artikel Blog MCI</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Kelola artikel blog untuk komunitas Majelis Coding Indonesia.</p>
    </div>
    <a href="{{ route('dashboard.blogs.create') }}" class="inline-flex items-center gap-2 px-5 py-3 rounded-xl [background:linear-gradient(135deg,#06b6d4,#025f5a)] text-white font-semibold shadow-[0_12px_30px_rgba(2,95,90,0.25)] hover:-translate-y-1 transition">
        <i class="fa-solid fa-plus"></i>
        Artikel Baru
    </a>
</div>

@if (session('success'))
    <div class="mb-6 p-4 rounded-xl border border-emerald-400/40 bg-emerald-50/80 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-200">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="mb-6 p-4 rounded-xl border border-rose-400/40 bg-rose-50/80 text-rose-600 dark:bg-rose-500/10 dark:text-rose-200">
        {{ session('error') }}
    </div>
@endif

<div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-3xl overflow-hidden shadow-[0_18px_40px_rgba(2,95,90,0.08)]">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800">
            <thead class="bg-gray-50/70 dark:bg-gray-800/60">
                <tr>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold tracking-wider uppercase text-gray-500 dark:text-gray-400">Judul</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold tracking-wider uppercase text-gray-500 dark:text-gray-400">Penulis</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold tracking-wider uppercase text-gray-500 dark:text-gray-400">Status</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold tracking-wider uppercase text-gray-500 dark:text-gray-400">Dibuat</th>
                    <th scope="col" class="px-6 py-4 text-right text-xs font-semibold tracking-wider uppercase text-gray-500 dark:text-gray-400">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-800">
                @forelse ($blogs as $blog)
                    <tr class="hover:bg-gray-50/70 dark:hover:bg-gray-800/40 transition">
                        <td class="px-6 py-5 align-top">
                            <div class="font-semibold text-gray-900 dark:text-gray-100">{{ $blog->title }}</div>
                            <div class="text-xs text-gray-400 dark:text-gray-500">{{ $blog->slug }}</div>
                        </td>
                        <td class="px-6 py-5 align-top text-sm text-gray-600 dark:text-gray-300">
                            {{ $blog->author ?? '—' }}
                        </td>
                        <td class="px-6 py-5 align-top">
                            <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-semibold
                                {{ $blog->status === 'published'
                                    ? 'bg-emerald-500/10 text-emerald-500'
                                    : 'bg-amber-500/10 text-amber-500' }}">
                                <span class="w-2 h-2 rounded-full {{ $blog->status === 'published' ? 'bg-emerald-500' : 'bg-amber-500' }}"></span>
                                {{ ucfirst($blog->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-5 align-top text-sm text-gray-500 dark:text-gray-400">
                            {{ $blog->created_at?->translatedFormat('d M Y, H:i') ?? '—' }}
                        </td>
                        <td class="px-6 py-5 align-top">
                            <div class="flex items-center justify-end gap-2">
                                @if ($blog->status === 'published')
                                    <a href="{{ route('blog.show', $blog->slug) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-sky-500/40 text-sky-600 dark:text-sky-300 hover:bg-sky-50/70 dark:hover:bg-sky-500/10 transition text-sm font-semibold">
                                        <i class="fa-solid fa-up-right-from-square"></i>
                                        Lihat
                                    </a>
                                @endif
                                <a href="{{ route('dashboard.blogs.edit', $blog) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-teal-500/40 text-teal-600 dark:text-teal-300 hover:bg-teal-50/70 dark:hover:bg-teal-500/10 transition text-sm font-semibold">
                                    <i class="fa-solid fa-pen"></i>
                                    Edit
                                </a>
                                <form action="{{ route('dashboard.blogs.destroy', $blog) }}" method="POST" onsubmit="return confirm('Hapus artikel ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-rose-500/40 text-rose-500 hover:bg-rose-50/80 dark:border-rose-500/30 dark:text-rose-300 dark:hover:bg-rose-500/10 transition text-sm font-semibold">
                                        <i class="fa-solid fa-trash"></i>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-sm text-gray-500 dark:text-gray-400">
                            Belum ada artikel blog. Mulai dengan membuat artikel pertama Anda.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($blogs instanceof \Illuminate\Pagination\LengthAwarePaginator && $blogs->hasPages())
        <div class="px-6 py-5 border-t border-gray-200 dark:border-gray-800">
            {{ $blogs->withQueryString()->links() }}
        </div>
    @endif
</div>
@endsection
