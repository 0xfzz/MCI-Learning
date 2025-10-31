@extends('layouts.dashboard')

@section('title', 'Reset Password - MCI Learning')

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-4">
        <a href="{{ route('dashboard.index') }}" class="hover:text-[#025f5a] transition">Dashboard</a>
        <i class="fa-solid fa-chevron-right text-xs"></i>
        <span class="text-gray-900 dark:text-white font-medium">Reset Password</span>
    </div>
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Reset Password</h1>
            <p class="text-gray-500 dark:text-gray-400">Ubah password Anda untuk keamanan akun</p>
        </div>
        <a href="{{ route('dashboard.profile.edit') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl transition text-sm font-medium">
            <i class="fa-solid fa-arrow-left mr-2"></i>Kembali ke Profil
        </a>
    </div>
</div>

<div class="grid lg:grid-cols-[1fr_400px] gap-6">
    <!-- Update Password Form -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-8 shadow-sm">
        <div class="flex items-center gap-4 pb-6 mb-6 border-b border-gray-200 dark:border-gray-700">
            <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-orange-400 to-red-500 flex items-center justify-center text-white shadow-lg shadow-orange-500/30">
                <i class="fa-solid fa-key text-2xl"></i>
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">Ubah Password</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Pastikan akun Anda menggunakan password yang kuat</p>
            </div>
        </div>

        <form method="POST" action="{{ route('dashboard.profile.password.update') }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="current_password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    <i class="fa-solid fa-lock text-gray-400 mr-2"></i>Password Saat Ini
                </label>
                <input
                    type="password"
                    id="current_password"
                    name="current_password"
                    required
                    autocomplete="current-password"
                    class="w-full px-4 py-3 border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 rounded-xl focus:outline-none focus:ring-2 [focus:ring-color:#025f5a] focus:border-transparent"
                    placeholder="Masukkan password saat ini"
                >
                @error('current_password')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">
                        <i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    <i class="fa-solid fa-key text-gray-400 mr-2"></i>Password Baru
                </label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                    autocomplete="new-password"
                    class="w-full px-4 py-3 border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 rounded-xl focus:outline-none focus:ring-2 [focus:ring-color:#025f5a] focus:border-transparent"
                    placeholder="Masukkan password baru"
                >
                @error('password')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">
                        <i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}
                    </p>
                @enderror
                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                    <i class="fa-solid fa-info-circle mr-1"></i>Password harus minimal 8 karakter, mengandung huruf besar, huruf kecil, angka, dan simbol
                </p>
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    <i class="fa-solid fa-shield-halved text-gray-400 mr-2"></i>Konfirmasi Password Baru
                </label>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    class="w-full px-4 py-3 border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 rounded-xl focus:outline-none focus:ring-2 [focus:ring-color:#025f5a] focus:border-transparent"
                    placeholder="Ketik ulang password baru"
                >
            </div>

            <div class="pt-4 flex gap-3">
                <button type="submit" class="px-6 py-3 [background:linear-gradient(135deg,#06b6d4,#025f5a)] text-white font-semibold rounded-xl hover:shadow-lg transition-all flex items-center gap-2">
                    <i class="fa-solid fa-check"></i>
                    <span>Ubah Password</span>
                </button>
                <a href="{{ route('dashboard.index') }}" class="px-6 py-3 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-xl transition flex items-center gap-2">
                    <i class="fa-solid fa-xmark"></i>
                    <span>Batal</span>
                </a>
            </div>
        </form>
    </div>

    <!-- Security Tips (Right Sidebar) -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-blue-200 dark:border-blue-900/30 p-6 shadow-sm h-fit sticky top-6">
        <div class="flex items-center gap-3 pb-4 mb-4 border-b border-blue-200 dark:border-blue-900/30">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-400 to-cyan-500 flex items-center justify-center text-white shadow-lg shadow-blue-500/30">
                <i class="fa-solid fa-lightbulb text-xl"></i>
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Tips Keamanan</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400">Lindungi akun Anda</p>
            </div>
        </div>
        <ul class="space-y-2.5 text-xs text-gray-700 dark:text-gray-300">
            <li class="flex items-start gap-2 p-2.5 rounded-lg bg-gray-50 dark:bg-gray-900/50">
                <i class="fa-solid fa-check-circle text-green-500 mt-0.5"></i>
                <span>Gunakan kombinasi huruf besar, huruf kecil, angka, dan simbol</span>
            </li>
            <li class="flex items-start gap-2 p-2.5 rounded-lg bg-gray-50 dark:bg-gray-900/50">
                <i class="fa-solid fa-check-circle text-green-500 mt-0.5"></i>
                <span>Buat password minimal 12 karakter untuk keamanan maksimal</span>
            </li>
            <li class="flex items-start gap-2 p-2.5 rounded-lg bg-gray-50 dark:bg-gray-900/50">
                <i class="fa-solid fa-check-circle text-green-500 mt-0.5"></i>
                <span>Hindari menggunakan informasi pribadi seperti nama atau tanggal lahir</span>
            </li>
            <li class="flex items-start gap-2 p-2.5 rounded-lg bg-gray-50 dark:bg-gray-900/50">
                <i class="fa-solid fa-check-circle text-green-500 mt-0.5"></i>
                <span>Jangan gunakan password yang sama untuk akun lain</span>
            </li>
            <li class="flex items-start gap-2 p-2.5 rounded-lg bg-gray-50 dark:bg-gray-900/50">
                <i class="fa-solid fa-check-circle text-green-500 mt-0.5"></i>
                <span>Ubah password secara berkala setiap 3-6 bulan</span>
            </li>
        </ul>
    </div>
</div>
@endsection
