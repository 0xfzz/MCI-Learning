@extends('layouts.app')

@section('title', 'Daftar Akun Baru')

@section('content')
<div class="min-h-screen flex items-center justify-center px-6 py-16">
    <div class="max-w-2xl w-full bg-white dark:bg-gray-900 border border-teal-500/20 dark:border-teal-400/20 rounded-3xl shadow-[0_25px_60px_rgba(20,184,166,0.18)] p-10">
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl [background:linear-gradient(135deg,#06b6d4,#025f5a)] text-white text-3xl mb-6">
                <i class="fa-solid fa-user-plus"></i>
            </div>
            <h1 class="text-3xl font-bold [color:#025f5a] dark:text-teal-200 mb-2">Buat Akun MCI Learning</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Mulai belajar dengan mendaftar sebagai peserta.</p>
        </div>

        @if ($errors->any())
            <div class="mb-6 rounded-2xl border border-rose-500/30 bg-rose-500/10 px-5 py-4 text-sm text-rose-500 dark:text-rose-300">
                <strong class="block mb-2">Mohon periksa lagi:</strong>
                <ul class="space-y-1 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register.store') }}" class="grid grid-cols-1 gap-6">
            @csrf

            <div class="grid gap-6 sm:grid-cols-2">
                <div class="space-y-2">
                    <label for="username" class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Username</label>
                    <input
                        type="text"
                        id="username"
                        name="username"
                        value="{{ old('username') }}"
                        required
                        class="w-full rounded-2xl border border-teal-500/30 bg-white/80 dark:bg-gray-950/60 px-4 py-3 text-sm text-gray-900 dark:text-gray-100 focus:border-teal-500 focus:outline-none focus:ring-2 focus:ring-teal-500/40"
                        placeholder="mciusername"
                    >
                </div>

                <div class="space-y-2">
                    <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Nama Lengkap (opsional)</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        class="w-full rounded-2xl border border-teal-500/30 bg-white/80 dark:bg-gray-950/60 px-4 py-3 text-sm text-gray-900 dark:text-gray-100 focus:border-teal-500 focus:outline-none focus:ring-2 focus:ring-teal-500/40"
                        placeholder="Nama sesuai identitas"
                    >
                </div>
            </div>

            <div class="space-y-2">
                <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    class="w-full rounded-2xl border border-teal-500/30 bg-white/80 dark:bg-gray-950/60 px-4 py-3 text-sm text-gray-900 dark:text-gray-100 focus:border-teal-500 focus:outline-none focus:ring-2 focus:ring-teal-500/40"
                    placeholder="belajar@mci.id"
                >
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div class="space-y-2">
                    <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Kata Sandi</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                        class="w-full rounded-2xl border border-teal-500/30 bg-white/80 dark:bg-gray-950/60 px-4 py-3 text-sm text-gray-900 dark:text-gray-100 focus:border-teal-500 focus:outline-none focus:ring-2 focus:ring-teal-500/40"
                        placeholder="Minimal 8 karakter"
                    >
                </div>

                <div class="space-y-2">
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Konfirmasi Kata Sandi</label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        required
                        class="w-full rounded-2xl border border-teal-500/30 bg-white/80 dark:bg-gray-950/60 px-4 py-3 text-sm text-gray-900 dark:text-gray-100 focus:border-teal-500 focus:outline-none focus:ring-2 focus:ring-teal-500/40"
                        placeholder="Ulangi kata sandi"
                    >
                </div>
            </div>

            <button
                type="submit"
                class="w-full flex items-center justify-center gap-2 rounded-2xl px-5 py-3.5 text-white text-sm font-semibold [background:linear-gradient(135deg,#06b6d4,#025f5a)] shadow-[0_20px_45px_rgba(2,95,90,0.3)] transition-all hover:-translate-y-1 hover:shadow-[0_25px_60px_rgba(2,95,90,0.35)]"
            >
                <i class="fa-solid fa-user-check"></i>
                <span>Daftar Sekarang</span>
            </button>
        </form>

        <p class="mt-8 text-center text-xs text-gray-500 dark:text-gray-400">
            Sudah punya akun? <a href="{{ route('login') }}" class="font-semibold text-teal-600 dark:text-teal-300 hover:text-teal-500">Masuk di sini</a>.
        </p>

        <div class="mt-6 text-center">
            <a href="{{ route('home') }}" class="text-sm font-semibold text-teal-600 dark:text-teal-300 hover:text-teal-500">
                &larr; Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection
