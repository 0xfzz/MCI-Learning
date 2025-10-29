@extends('layouts.dashboard')

@section('title', 'Tambah Materi Baru - MCI Learning')

@section('search-placeholder', 'Cari materi...')

@section('content')
<div class="mb-8">
    <a href="{{ route('dashboard.courses.lessons.index', $course) }}" class="text-sm text-gray-500 dark:text-gray-400 hover:text-teal-500">
        <i class="fa-solid fa-arrow-left mr-2"></i>Kembali ke struktur
    </a>
</div>

<div class="flex items-start justify-between mb-8">
    <div>
        <p class="text-sm uppercase tracking-widest text-gray-400 dark:text-gray-500 font-semibold">Instruktur • {{ $course->title }}</p>
        <h1 class="text-3xl font-black text-gray-900 dark:text-gray-100">Tambah Materi</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Buat bagian baru atau unggah video pembelajaran.</p>
    </div>
</div>

<form method="POST" action="{{ route('dashboard.courses.lessons.store', $course) }}" class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-3xl p-6 space-y-6">
    @csrf
    @include('dashboard.instructor.lessons.form', ['lesson' => null])
    <div class="flex items-center justify-end gap-3 pt-4 border-t border-dashed border-gray-200 dark:border-gray-800">
        <a href="{{ route('dashboard.courses.lessons.index', $course) }}" class="px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 text-sm text-gray-600 dark:text-gray-300 hover:border-teal-400/60 transition">Batal</a>
        <button type="submit" class="px-4 py-3 rounded-xl bg-[#025f5a] text-white text-sm font-semibold shadow-lg shadow-emerald-500/20 hover:bg-[#014440] transition">Simpan Materi</button>
    </div>
</form>
@endsection

@section('right-sidebar')
@endsection
