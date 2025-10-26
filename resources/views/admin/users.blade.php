@extends('layouts.dashboard')

@section('title', 'Kelola Pengguna - MCI Learning')

@section('search-placeholder', 'Cari pengguna atau role...')

@section('content')
<div class="mb-10">
    <p class="text-sm uppercase tracking-widest text-gray-400 dark:text-gray-500 font-semibold">Panel Admin</p>
    <h1 class="text-3xl font-black text-gray-900 dark:text-gray-100">Kelola Pengguna</h1>
    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Lihat pertumbuhan komunitas dan optimalkan peran pengguna.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
    @forelse ($metrics as $metric)
        @php
            $trendClass = str_starts_with($metric['trend'], '-') ? 'text-rose-500' : (str_starts_with($metric['trend'], '0') ? 'text-gray-400' : 'text-emerald-500');
        @endphp
        <div class="relative overflow-hidden rounded-3xl border border-gray-200 dark:border-gray-800 bg-white/95 dark:bg-gray-900/95 backdrop-blur shadow-[0_20px_45px_rgba(2,95,90,0.08)]">
            <div class="absolute -top-12 -right-10 w-28 h-28 rounded-full opacity-10" style="background: {{ $metric['gradient'] ?? 'linear-gradient(135deg,#06b6d4,#025f5a)' }}"></div>
            <div class="p-6 relative z-10">
                <p class="text-xs uppercase tracking-wide text-gray-400 dark:text-gray-500 font-semibold mb-2">{{ $metric['label'] }}</p>
                <div class="flex items-end justify-between">
                    <div>
                        <p class="text-3xl font-black text-gray-900 dark:text-gray-100">{{ $metric['value'] }}</p>
                        @if (!empty($metric['caption']))
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $metric['caption'] }}</p>
                        @endif
                    </div>
                    <span class="text-sm font-semibold {{ $trendClass }}">{{ $metric['trend'] }}</span>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full rounded-3xl border border-dashed border-gray-200 dark:border-gray-800 p-6 text-center text-sm text-gray-500 dark:text-gray-400">
            Belum ada data pengguna untuk ditampilkan.
        </div>
    @endforelse
</div>

<div class="mt-12 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-3xl p-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">Daftar Pengguna</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Kelola peran dan status akun secara terpusat.</p>
        </div>
        <form method="GET" action="{{ route('admin.users') }}" class="flex items-center gap-2">
            <label for="q" class="sr-only">Cari pengguna</label>
            <input
                id="q"
                name="q"
                type="search"
                value="{{ request('q') }}"
                placeholder="Cari nama, username, atau email..."
                class="w-64 px-4 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm text-gray-600 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-teal-500"
            >
            <button type="submit" class="px-4 py-2 text-sm rounded-xl border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 hover:border-teal-400/60 transition">Cari</button>
        </form>
    </div>

    @php
        $currentUserId = auth()->user()?->user_id;
        $roleBadges = [
            'admin' => 'bg-emerald-500/10 text-emerald-500',
            'instructor' => 'bg-indigo-500/10 text-indigo-500',
            'student' => 'bg-teal-500/10 text-teal-600',
        ];
    @endphp

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-xs uppercase tracking-wide text-gray-400 dark:text-gray-500 border-b border-gray-100 dark:border-gray-800">
                    <th class="py-3 text-left">Pengguna</th>
                    <th class="py-3 text-left">Email</th>
                    <th class="py-3 text-left">Role</th>
                    <th class="py-3 text-left">Bergabung</th>
                    <th class="py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                @forelse ($users as $user)
                    @php
                        $isSelf = $currentUserId === $user->user_id;
                        $badgeClass = $roleBadges[$user->role] ?? 'bg-gray-200 text-gray-600';
                    @endphp
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40 transition">
                        <td class="py-4 pr-4">
                            <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $user->name ?? $user->username }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ '@'.$user->username }}</p>
                        </td>
                        <td class="py-4 pr-4 text-gray-500 dark:text-gray-400">{{ $user->email }}</td>
                        <td class="py-4 pr-4">
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $badgeClass }}">{{ ucfirst($user->role) }}</span>
                        </td>
                        <td class="py-4 pr-4 text-gray-500 dark:text-gray-400">{{ optional($user->created_at)?->format('d M Y') ?? '-' }}</td>
                        <td class="py-4 pr-4">
                            <div class="flex items-center justify-end gap-2">
                                <form method="POST" action="{{ route('admin.users.update-role', $user) }}" class="flex items-center gap-2">
                                    @csrf
                                    <label for="role-{{ $user->user_id }}" class="sr-only">Peran</label>
                                    <select id="role-{{ $user->user_id }}" name="role" class="px-3 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-xs text-gray-600 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-teal-500" @disabled($isSelf)>
                                        @foreach ($availableRoles as $value => $label)
                                            <option value="{{ $value }}" @selected($user->role === $value)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="px-3 py-2 text-xs rounded-xl border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 hover:border-teal-400/60 transition" @disabled($isSelf)>
                                        Simpan
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Hapus pengguna ini? Tindakan tidak dapat dibatalkan.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-2 text-xs rounded-xl border border-gray-200 dark:border-gray-700 text-rose-500 hover:border-rose-400/60 transition" @disabled($isSelf)>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-6 text-center text-sm text-gray-500 dark:text-gray-400">Belum ada pengguna yang dapat dikelola.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $users->onEachSide(1)->links() }}
    </div>
</div>
@endsection

@section('right-sidebar')
@endsection
