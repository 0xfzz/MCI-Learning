@extends('layouts.dashboard')

@section('title', 'Kelola Kursus Saya - MCI Learning')

@section('search-placeholder', 'Cari kursus atau status...')

@section('content')
<div class="mb-10">
    <p class="text-sm uppercase tracking-widest text-gray-400 dark:text-gray-500 font-semibold">Instruktur</p>
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-gray-900 dark:text-gray-100">Kursus Saya</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Pantau dan kelola seluruh kursus yang Anda ajarkan.</p>
        </div>
        <a href="{{ route('instructor.courses.create') }}" class="inline-flex items-center gap-2 px-4 py-3 rounded-xl bg-[#025f5a] text-white text-sm font-semibold shadow-lg shadow-emerald-500/20 hover:bg-[#014440] transition">
            <i class="fa-solid fa-circle-plus"></i>
            Kursus Baru
        </a>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
    <div class="rounded-3xl border border-gray-200 dark:border-gray-800 bg-white/95 dark:bg-gray-900/95 p-6">
        <p class="text-xs uppercase tracking-wide text-gray-400 dark:text-gray-500 font-semibold mb-2">Total Kursus</p>
        <p class="text-3xl font-black text-gray-900 dark:text-gray-100">{{ number_format($metrics['total']) }}</p>
    </div>
    <div class="rounded-3xl border border-gray-200 dark:border-gray-800 bg-white/95 dark:bg-gray-900/95 p-6">
        <p class="text-xs uppercase tracking-wide text-gray-400 dark:text-gray-500 font-semibold mb-2">Dipublikasikan</p>
        <p class="text-3xl font-black text-emerald-500">{{ number_format($metrics['published']) }}</p>
    </div>
    <div class="rounded-3xl border border-gray-200 dark:border-gray-800 bg-white/95 dark:bg-gray-900/95 p-6">
        <p class="text-xs uppercase tracking-wide text-gray-400 dark:text-gray-500 font-semibold mb-2">Draft</p>
        <p class="text-3xl font-black text-amber-500">{{ number_format($metrics['draft']) }}</p>
    </div>
    <div class="rounded-3xl border border-gray-200 dark:border-gray-800 bg-white/95 dark:bg-gray-900/95 p-6">
        <p class="text-xs uppercase tracking-wide text-gray-400 dark:text-gray-500 font-semibold mb-2">Total Murid</p>
        <p class="text-3xl font-black text-gray-900 dark:text-gray-100">{{ number_format($metrics['students']) }}</p>
    </div>
</div>

<div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-3xl p-6">
    <form method="GET" action="{{ route('instructor.courses.index') }}" class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
        <div class="flex items-center gap-2">
            <label for="status" class="sr-only">Status</label>
            <select id="status" name="status" class="px-4 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm text-gray-600 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-teal-500">
                <option value="">Semua status</option>
                @foreach ($statusOptions as $value => $label)
                    <option value="{{ $value }}" @selected($filters['status'] === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex items-center gap-2">
            <label for="q" class="sr-only">Cari kursus</label>
            <input id="q" name="q" type="search" value="{{ $filters['q'] }}" placeholder="Cari judul atau deskripsi..." class="w-full lg:w-72 px-4 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm text-gray-600 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-teal-500">
            <button type="submit" class="px-4 py-2 text-sm rounded-xl border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 hover:border-teal-400/60 transition">Terapkan</button>
        </div>
    </form>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-xs uppercase tracking-wide text-gray-400 dark:text-gray-500 border-b border-gray-100 dark:border-gray-800">
                    <th class="text-left py-3">Kursus</th>
                    <th class="text-left py-3">Kategori</th>
                    <th class="text-left py-3">Status</th>
                    <th class="text-right py-3">Harga</th>
                    <th class="text-right py-3">Siswa</th>
                    <th class="text-right py-3">Dibuat</th>
                    <th class="text-right py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                @forelse ($courses as $course)
                    @php
                        $statusStyles = [
                            'published' => 'bg-emerald-500/10 text-emerald-600',
                            'draft' => 'bg-amber-500/10 text-amber-600',
                        ];
                        $statusClass = $statusStyles[$course->status] ?? 'bg-gray-200 text-gray-600';
                    @endphp
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40 transition">
                        <td class="py-4 pr-4">
                            <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $course->title }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Level: {{ $course->level ? ucfirst($course->level) : 'Umum' }}</p>
                        </td>
                        <td class="py-4 pr-4 text-gray-500 dark:text-gray-400">{{ $course->category?->name ?? 'Tidak ada' }}</td>
                        <td class="py-4 pr-4">
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $statusClass }}">{{ ucfirst($course->status) }}</span>
                        </td>
                        <td class="py-4 pr-4 text-right text-gray-500 dark:text-gray-400">
                            @if ($course->is_paid)
                                Rp {{ number_format($course->discount_price ?? $course->price, 0, ',', '.') }}
                            @else
                                Gratis
                            @endif
                        </td>
                        <td class="py-4 pr-4 text-right text-gray-500 dark:text-gray-400">{{ number_format($course->enrollments_count) }}</td>
                        <td class="py-4 pr-4 text-right text-gray-500 dark:text-gray-400">{{ optional($course->created_at)?->format('d M Y') ?? '-' }}</td>
                        <td class="py-4 pr-4">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('instructor.lessons.index', $course) }}" class="px-3 py-2 text-xs rounded-xl border border-gray-200 dark:border-gray-700 text-[#025f5a] hover:border-teal-400/60 transition">Materi</a>
                                <a href="{{ route('instructor.courses.edit', $course) }}" class="px-3 py-2 text-xs rounded-xl border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 hover:border-teal-400/60 transition">Edit</a>
                                <form method="POST" action="{{ route('instructor.courses.destroy', $course) }}" onsubmit="return confirm('Hapus kursus ini? Seluruh materi akan ikut terhapus.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-2 text-xs rounded-xl border border-gray-200 dark:border-gray-700 text-rose-500 hover:border-rose-400/60 transition">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-6 text-center text-sm text-gray-500 dark:text-gray-400">Belum ada kursus. Mulai dengan membuat kursus pertama Anda.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @php
        $paginator = is_object($courses) ? $courses : null;
    @endphp

    @if ($paginator)
        <div class="mt-6">
            {{ method_exists($paginator, 'onEachSide') ? $paginator->onEachSide(1)->links() : $paginator->links() }}
        </div>
    @endif
</div>
@endsection

@section('right-sidebar')
@endsection
