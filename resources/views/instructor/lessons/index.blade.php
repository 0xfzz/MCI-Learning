@extends('layouts.dashboard')

@section('title', 'Kelola Materi Kursus - MCI Learning')

@section('search-placeholder', 'Cari materi atau bagian kursus...')

@section('content')
<div class="mb-8">
    <a href="{{ route('instructor.courses.index') }}" class="text-sm text-gray-500 dark:text-gray-400 hover:text-teal-500">
        <i class="fa-solid fa-arrow-left mr-2"></i>Kembali ke kursus saya
    </a>
</div>

<div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6 mb-8">
    <div>
        <p class="text-sm uppercase tracking-widest text-gray-400 dark:text-gray-500 font-semibold">Instruktur • {{ $course->title }}</p>
        <h1 class="text-3xl font-black text-gray-900 dark:text-gray-100">Struktur Pembelajaran</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Susun urutan materi agar siswa belajar secara terarah.</p>
    </div>
    <div class="flex items-center gap-2">
        <a href="{{ route('instructor.lessons.create', $course) }}" class="inline-flex items-center gap-2 px-4 py-3 rounded-xl bg-[#025f5a] text-white text-sm font-semibold shadow-lg shadow-emerald-500/20 hover:bg-[#014440] transition">
            <i class="fa-solid fa-folder-tree"></i>
            Tambah Bagian
        </a>
        <a href="{{ route('instructor.lessons.create', [$course, 'parent_id' => request('section')]) }}" class="inline-flex items-center gap-2 px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 text-sm text-gray-600 dark:text-gray-300 hover:border-teal-400/60 transition">
            <i class="fa-solid fa-play"></i>
            Tambah Video
        </a>
    </div>
</div>

<div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-3xl p-6">
    @forelse ($sections as $section)
        <div class="mb-6 last:mb-0">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $section->title }}</h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Urutan: {{ $section->order_number }}</p>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('instructor.lessons.edit', [$course, $section]) }}" class="px-3 py-2 text-xs rounded-xl border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 hover:border-teal-400/60 transition">Edit</a>
                    <form method="POST" action="{{ route('instructor.lessons.destroy', [$course, $section]) }}" onsubmit="return confirm('Hapus bagian ini beserta semua materinya?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-3 py-2 text-xs rounded-xl border border-gray-200 dark:border-gray-700 text-rose-500 hover:border-rose-400/60 transition">Hapus</button>
                    </form>
                </div>
            </div>

            @if ($section->children->isNotEmpty())
                <div class="mt-4 border-l-2 border-dashed border-gray-200 dark:border-gray-800 pl-5 space-y-3">
                    @foreach ($section->children as $lesson)
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $lesson->title }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Durasi: {{ $lesson->duration ?? '-' }} • {{ $lesson->is_free ? 'Gratis' : 'Premium' }}</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('instructor.lessons.edit', [$course, $lesson]) }}" class="px-3 py-2 text-xs rounded-xl border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 hover:border-teal-400/60 transition">Edit</a>
                                <form method="POST" action="{{ route('instructor.lessons.destroy', [$course, $lesson]) }}" onsubmit="return confirm('Hapus materi ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-2 text-xs rounded-xl border border-gray-200 dark:border-gray-700 text-rose-500 hover:border-rose-400/60 transition">Hapus</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="mt-4 text-sm text-gray-500 dark:text-gray-400">Belum ada materi dalam bagian ini.</p>
            @endif
        </div>
    @empty
        <p class="text-sm text-gray-500 dark:text-gray-400">Belum ada struktur pembelajaran. Mulai dengan menambahkan bagian pertama.</p>
    @endforelse
</div>
@endsection

@section('right-sidebar')
@endsection
