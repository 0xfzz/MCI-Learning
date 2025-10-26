@extends('layouts.dashboard')

@section('title', 'Tambah Artikel Blog - MCI Admin')

@section('search-placeholder', 'Cari artikel blog...')

@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <p class="text-xs uppercase tracking-[0.3em] text-gray-400 dark:text-gray-500 font-semibold">Artikel Baru</p>
        <h1 class="text-3xl font-black text-gray-900 dark:text-gray-100">Tulis Artikel Blog</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Bagikan wawasan terbaru untuk komunitas Majelis Coding Indonesia.</p>
    </div>
    <a href="{{ route('admin.blogs.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-gray-300 dark:border-gray-700 text-gray-600 dark:text-gray-300 hover:border-teal-500/50 hover:text-teal-500 transition">
        <i class="fa-solid fa-arrow-left"></i>
        Kembali
    </a>
</div>

@if (session('error'))
    <div class="mb-6 p-4 rounded-xl border border-rose-400/40 bg-rose-50/80 text-rose-600 dark:bg-rose-500/10 dark:text-rose-200">
        {{ session('error') }}
    </div>
@endif

@include('admin.blogs.form', [
    'blog' => $blog,
    'action' => route('admin.blogs.store'),
    'method' => 'POST',
    'submitLabel' => 'Simpan Artikel',
])
@endsection
