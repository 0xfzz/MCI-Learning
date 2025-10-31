@extends('layouts.dashboard')

@section('title', 'Edit Profil - MCI Learning')

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-4">
        <a href="{{ route('dashboard.index') }}" class="hover:text-[#025f5a] transition">Dashboard</a>
        <i class="fa-solid fa-chevron-right text-xs"></i>
        <span class="text-gray-900 dark:text-white font-medium">Edit Profil</span>
    </div>
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Edit Profil</h1>
            <p class="text-gray-500 dark:text-gray-400">Kelola informasi profil dan akun Anda</p>
        </div>
        <a href="{{ route('dashboard.profile.password.edit') }}" class="px-4 py-2 bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 text-white rounded-xl transition text-sm font-medium shadow-lg shadow-orange-500/30">
            <i class="fa-solid fa-key mr-2"></i>Ubah Password
        </a>
    </div>
</div>

<!-- Profile Content -->
<div class="space-y-6">
    <!-- Profile Information -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-8 shadow-sm">
        <div class="flex items-center gap-4 pb-6 mb-6 border-b border-gray-200 dark:border-gray-700">
            <div class="w-20 h-20 rounded-full [background:linear-gradient(135deg,#06b6d4,#025f5a)] flex items-center justify-center text-white font-bold text-3xl">
                {{ strtoupper(substr($user->name ?? $user->username, 0, 1)) }}
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">Informasi Profil</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Perbarui informasi profil dan email Anda</p>
            </div>
        </div>

        <form method="POST" action="{{ route('dashboard.profile.update') }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="username" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Username</label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    value="{{ old('username', $user->username) }}"
                    required
                    class="w-full px-4 py-3 border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 rounded-xl focus:outline-none focus:ring-2 [focus:ring-color:#025f5a] focus:border-transparent"
                >
                @error('username')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Nama Lengkap</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $user->name) }}"
                    class="w-full px-4 py-3 border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 rounded-xl focus:outline-none focus:ring-2 [focus:ring-color:#025f5a] focus:border-transparent"
                >
                @error('name')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email', $user->email) }}"
                    required
                    class="w-full px-4 py-3 border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 rounded-xl focus:outline-none focus:ring-2 [focus:ring-color:#025f5a] focus:border-transparent"
                >
                @error('email')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4 flex gap-3">
                <button type="submit" class="px-6 py-3 [background:linear-gradient(135deg,#06b6d4,#025f5a)] text-white font-semibold rounded-xl hover:shadow-lg transition-all flex items-center gap-2">
                    <i class="fa-solid fa-check"></i>
                    <span>Simpan Perubahan</span>
                </button>
                <a href="{{ route('dashboard.index') }}" class="px-6 py-3 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-xl transition flex items-center gap-2">
                    <i class="fa-solid fa-xmark"></i>
                    <span>Batal</span>
                </a>
            </div>
        </form>
    </div>

    <!-- Danger Zone -->
    <div class="mt-6 bg-white dark:bg-gray-800 rounded-2xl border-2 border-red-200 dark:border-red-900/50 p-8 shadow-sm">
        <div class="flex items-center gap-4 pb-6 mb-6 border-b border-red-200 dark:border-red-900/50">
            <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-red-500 to-red-600 flex items-center justify-center text-white shadow-lg shadow-red-500/30">
                <i class="fa-solid fa-triangle-exclamation text-2xl"></i>
            </div>
            <div>
                <h2 class="text-xl font-bold text-red-600 dark:text-red-400">Zona Berbahaya</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Tindakan ini tidak dapat dibatalkan</p>
            </div>
        </div>

        <p class="text-gray-600 dark:text-gray-400 mb-6">
            Setelah akun Anda dihapus, semua data akan dihapus secara permanen. Harap unduh data yang ingin Anda simpan sebelum melanjutkan.
        </p>

        <form method="POST" action="{{ route('dashboard.profile.destroy') }}" x-data="{ confirmDelete: false }">
            @csrf
            @method('DELETE')

            <div x-show="!confirmDelete">
                <button type="button" @click="confirmDelete = true" class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-xl transition flex items-center gap-2 shadow-lg shadow-red-500/30">
                    <i class="fa-solid fa-trash"></i>
                    <span>Hapus Akun</span>
                </button>
            </div>

            <div x-show="confirmDelete" class="space-y-4">
                <div class="p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-900/50 rounded-xl">
                    <p class="text-red-800 dark:text-red-200 font-semibold mb-2">Apakah Anda yakin ingin menghapus akun Anda?</p>
                    <p class="text-red-700 dark:text-red-300 text-sm">Tindakan ini tidak dapat dibatalkan. Masukkan password Anda untuk mengonfirmasi.</p>
                </div>

                <div>
                    <label for="delete_password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Password</label>
                    <input
                        type="password"
                        id="delete_password"
                        name="password"
                        required
                        class="w-full px-4 py-3 border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent"
                    >
                    @error('password')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-xl transition flex items-center gap-2 shadow-lg shadow-red-500/30">
                        <i class="fa-solid fa-trash"></i>
                        <span>Ya, Hapus Akun Saya</span>
                    </button>
                    <button type="button" @click="confirmDelete = false" class="px-6 py-3 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-xl transition flex items-center gap-2">
                        <i class="fa-solid fa-xmark"></i>
                        <span>Batal</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
