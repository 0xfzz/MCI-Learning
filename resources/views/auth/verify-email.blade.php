@extends('layouts.app')

@section('title', 'Verifikasi Email Kamu')

@section('content')
<div class="min-h-screen flex items-center justify-center px-6 py-16">
    <div class="max-w-xl w-full bg-white dark:bg-gray-900 border border-teal-500/20 dark:border-teal-400/20 rounded-3xl shadow-[0_30px_70px_rgba(20,184,166,0.16)] p-12 space-y-8 text-center">
        <div class="inline-flex items-center justify-center w-20 h-20 rounded-3xl [background:linear-gradient(135deg,#06b6d4,#025f5a)] text-white text-3xl">
            <i class="fa-solid fa-envelope-circle-check"></i>
        </div>
        <div class="space-y-3">
            <h1 class="text-3xl font-bold [color:#025f5a] dark:text-teal-200">Cek Kotak Masukmu</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">
                Kami telah mengirimkan tautan verifikasi ke alamat email yang kamu daftarkan. Klik tautan tersebut untuk mengaktifkan akun dan mulai menjelajahi dashboard MCI Learning.
            </p>
        </div>

        @if (session('status'))
            <div class="rounded-2xl border border-teal-500/30 bg-teal-500/10 px-5 py-4 text-sm text-teal-600 dark:text-teal-300">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('verification.send') }}" class="space-y-4">
            @csrf
            <button type="submit" class="w-full inline-flex items-center justify-center gap-2 rounded-2xl px-6 py-3.5 text-sm font-semibold text-white [background:linear-gradient(135deg,#06b6d4,#025f5a)] shadow-[0_20px_45px_rgba(2,95,90,0.28)] transition-all hover:-translate-y-1 hover:shadow-[0_25px_60px_rgba(2,95,90,0.33)]">
                <i class="fa-solid fa-paper-plane"></i>
                Kirim Ulang Email Verifikasi
            </button>
        </form>

        <div class="text-xs text-gray-500 dark:text-gray-400 space-y-2">
            <p>Tidak menemukan emailnya? Cek folder spam atau gunakan tombol di atas untuk mengirim ulang.</p>
            <p>Memerlukan bantuan? <a href="mailto:hello@majeliscoding.id" class="font-semibold text-teal-600 dark:text-teal-300 hover:text-teal-500">Hubungi tim support</a>.</p>
        </div>

        <div class="pt-4 border-t border-dashed border-gray-200 dark:border-gray-800 text-sm">
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="text-teal-600 dark:text-teal-300 font-semibold hover:text-teal-500">Keluar</button>
            </form>
            <span class="mx-2 text-gray-400">&middot;</span>
            <a href="{{ route('home') }}" class="text-teal-600 dark:text-teal-300 font-semibold hover:text-teal-500">Kembali ke Beranda</a>
        </div>
    </div>
</div>
@endsection
