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
        <div class="flex items-center gap-2">
            <button onclick="openAddUserModal()" class="px-4 py-2 text-sm rounded-xl bg-[#025f5a] text-white hover:bg-[#024842] transition flex items-center gap-2">
                <i class="fa-solid fa-plus"></i>
                Tambah Pengguna
            </button>
            <form method="GET" action="{{ route('dashboard.users.index') }}" class="flex items-center gap-2">
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
                                <button
                                    onclick='openEditUserModal(@json($user))'
                                    class="px-3 py-2 text-xs rounded-xl border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 hover:border-teal-400/60 transition"
                                    @disabled($isSelf)
                                >
                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                </button>
                                <button
                                    onclick='openDeleteUserModal({{ $user->user_id }}, "{{ addslashes($user->name ?? $user->username) }}")'
                                    class="px-3 py-2 text-xs rounded-xl border border-gray-200 dark:border-gray-700 text-rose-500 hover:border-rose-400/60 transition"
                                    @disabled($isSelf)
                                >
                                    <i class="fa-solid fa-trash"></i> Hapus
                                </button>
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

<!-- Add User Modal -->
<div id="addUserModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-900 rounded-3xl border border-gray-200 dark:border-gray-800 w-full max-w-md shadow-2xl">
        <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-800">
            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">Tambah Pengguna Baru</h3>
            <button onclick="closeAddUserModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>
        <form method="POST" action="{{ route('dashboard.users.store') }}" class="p-6">
            @csrf
            <div class="space-y-4">
                <div>
                    <label for="add_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Nama Lengkap</label>
                    <input type="text" id="add_name" name="name" required class="w-full px-4 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-teal-500">
                </div>
                <div>
                    <label for="add_username" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Username</label>
                    <input type="text" id="add_username" name="username" required class="w-full px-4 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-teal-500">
                </div>
                <div>
                    <label for="add_email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Email</label>
                    <input type="email" id="add_email" name="email" required class="w-full px-4 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-teal-500">
                </div>
                <div>
                    <label for="add_password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Password</label>
                    <input type="password" id="add_password" name="password" required class="w-full px-4 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-teal-500">
                </div>
                <div>
                    <label for="add_role" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Role</label>
                    <select id="add_role" name="role" required class="w-full px-4 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-teal-500">
                        @foreach ($availableRoles as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="flex items-center justify-end gap-3 mt-6">
                <button type="button" onclick="closeAddUserModal()" class="px-4 py-2 text-sm rounded-xl border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600 transition">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 text-sm rounded-xl bg-[#025f5a] text-white hover:bg-[#024842] transition">
                    Tambah Pengguna
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit User Modal -->
<div id="editUserModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-900 rounded-3xl border border-gray-200 dark:border-gray-800 w-full max-w-md shadow-2xl">
        <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-800">
            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">Edit Pengguna</h3>
            <button onclick="closeEditUserModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>
        <form id="editUserForm" method="POST" class="p-6">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <div>
                    <label for="edit_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Nama Lengkap</label>
                    <input type="text" id="edit_name" name="name" required class="w-full px-4 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-teal-500">
                </div>
                <div>
                    <label for="edit_username" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Username</label>
                    <input type="text" id="edit_username" name="username" required class="w-full px-4 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-teal-500">
                </div>
                <div>
                    <label for="edit_email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Email</label>
                    <input type="email" id="edit_email" name="email" required class="w-full px-4 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-teal-500">
                </div>
                <div>
                    <label for="edit_role" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Role</label>
                    <select id="edit_role" name="role" required class="w-full px-4 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-teal-500">
                        @foreach ($availableRoles as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="edit_password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Password Baru (Opsional)</label>
                    <input type="password" id="edit_password" name="password" placeholder="Kosongkan jika tidak ingin mengubah" class="w-full px-4 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-teal-500">
                </div>
            </div>
            <div class="flex items-center justify-end gap-3 mt-6">
                <button type="button" onclick="closeEditUserModal()" class="px-4 py-2 text-sm rounded-xl border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600 transition">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 text-sm rounded-xl bg-[#025f5a] text-white hover:bg-[#024842] transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Delete User Modal -->
<div id="deleteUserModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-900 rounded-3xl border border-gray-200 dark:border-gray-800 w-full max-w-md shadow-2xl">
        <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-800">
            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">Konfirmasi Hapus</h3>
            <button onclick="closeDeleteUserModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>
        <div class="p-6">
            <div class="w-16 h-16 mx-auto rounded-full bg-rose-500/10 text-rose-500 flex items-center justify-center text-2xl mb-4">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <p class="text-center text-gray-600 dark:text-gray-400 mb-6">
                Apakah Anda yakin ingin menghapus pengguna <strong id="deleteUserName" class="text-gray-900 dark:text-gray-100"></strong>? Tindakan ini tidak dapat dibatalkan.
            </p>
            <form id="deleteUserForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex items-center justify-end gap-3">
                    <button type="button" onclick="closeDeleteUserModal()" class="px-4 py-2 text-sm rounded-xl border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600 transition">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm rounded-xl bg-rose-500 text-white hover:bg-rose-600 transition">
                        Ya, Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Add User Modal
function openAddUserModal() {
    document.getElementById('addUserModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeAddUserModal() {
    document.getElementById('addUserModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Edit User Modal
function openEditUserModal(user) {
    document.getElementById('edit_name').value = user.name || '';
    document.getElementById('edit_username').value = user.username || '';
    document.getElementById('edit_email').value = user.email || '';
    document.getElementById('edit_role').value = user.role || '';
    document.getElementById('edit_password').value = '';

    const form = document.getElementById('editUserForm');
    form.action = `/dashboard/users/${user.user_id}`;

    document.getElementById('editUserModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeEditUserModal() {
    document.getElementById('editUserModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Delete User Modal
function openDeleteUserModal(userId, userName) {
    document.getElementById('deleteUserName').textContent = userName;

    const form = document.getElementById('deleteUserForm');
    form.action = `/dashboard/users/${userId}`;

    document.getElementById('deleteUserModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeDeleteUserModal() {
    document.getElementById('deleteUserModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modals when clicking outside
document.addEventListener('click', function(event) {
    const modals = ['addUserModal', 'editUserModal', 'deleteUserModal'];
    modals.forEach(modalId => {
        const modal = document.getElementById(modalId);
        if (event.target === modal) {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    });
});

// Close modals with ESC key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeAddUserModal();
        closeEditUserModal();
        closeDeleteUserModal();
    }
});
</script>

