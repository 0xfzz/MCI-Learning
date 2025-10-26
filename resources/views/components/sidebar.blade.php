<aside class="bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-800 p-6 overflow-y-auto hidden lg:block">
    <!-- Logo -->
    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 mb-10 px-1">
        <!-- Logo image with light/dark mode support -->
        <img src="{{ asset('assets/logo/hijau.png') }}" alt="MCI (Majelis Coding Indonesia)" class="h-10 w-auto">
    </a>

    @php
        $user = auth()->user();
        $isAdmin = $user && method_exists($user, 'isAdmin') && $user->isAdmin();
        $isInstructor = $user && method_exists($user, 'isInstructor') && $user->isInstructor();
        $onAdminPanel = $isAdmin && request()->routeIs('admin.*');

        $adminLinks = [
            [
                'route' => 'admin.dashboard',
                'active' => 'admin.dashboard',
                'icon' => 'fa-solid fa-shield-halved',
                'label' => 'Dashboard',
            ],
            [
                'route' => 'admin.users',
                'active' => 'admin.users',
                'icon' => 'fa-solid fa-users',
                'label' => 'Kelola Pengguna',
            ],
            [
                'route' => 'admin.sales',
                'active' => 'admin.sales',
                'icon' => 'fa-solid fa-chart-line',
                'label' => 'Performa Penjualan',
            ],
            [
                'route' => 'admin.transactions',
                'active' => 'admin.transactions',
                'icon' => 'fa-solid fa-clipboard-check',
                'label' => 'Verifikasi Transaksi',
            ],
            [
                'route' => 'admin.blogs.index',
                'active' => 'admin.blogs.*',
                'icon' => 'fa-solid fa-pen-nib',
                'label' => 'Kelola Blog',
            ],
        ];

        $generalLinks = [
            [
                'route' => 'home',
                'active' => 'home',
                'icon' => 'fa-solid fa-compass',
                'label' => 'Beranda',
            ],
            [
                'route' => 'dashboard',
                'active' => 'dashboard',
                'icon' => 'fa-solid fa-house',
                'label' => 'Dashboard',
                'requiresAuth' => true,
            ],
            [
                'route' => 'courses.index',
                'active' => 'courses.*',
                'icon' => 'fa-solid fa-book',
                'label' => 'Katalog Kursus',
            ],
            [
                'route' => 'blog.index',
                'active' => 'blog.*',
                'icon' => 'fa-solid fa-newspaper',
                'label' => 'Blog',
            ],
        ];

        $instructorLinks = $isInstructor
            ? [
                [
                    'route' => 'instructor.courses.index',
                    'active' => 'instructor.courses.*',
                    'icon' => 'fa-solid fa-graduation-cap',
                    'label' => 'Kursus Saya',
                ],
            ]
            : [];
    @endphp

    <nav>
        @if ($onAdminPanel)
            <div class="text-xs text-gray-400 font-semibold uppercase tracking-wider mb-3 px-2">Panel Admin</div>

            @foreach ($adminLinks as $link)
                @php $isActive = request()->routeIs($link['active']); @endphp
                <a href="{{ route($link['route']) }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition mb-1 {{ $isActive ? '[background:#e6f7f6] [color:#025f5a] font-semibold dark:[background:#01444022] dark:text-white' : '' }}">
                    <span class="text-lg w-5 text-center"><i class="{{ $link['icon'] }}"></i></span>
                    <span>{{ $link['label'] }}</span>
                </a>
            @endforeach

            <div class="mt-8 border-t border-dashed border-gray-200 dark:border-gray-800 pt-6 text-xs text-gray-400 px-2">
                <p class="font-semibold uppercase tracking-wider mb-2">Aksi Cepat</p>
                <a href="{{ route('admin.sales.export') }}" class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 hover:text-teal-600 dark:hover:text-teal-300 transition">
                    <i class="fa-solid fa-file-arrow-down"></i>
                    Unduh laporan penjualan
                </a>
                <a href="{{ route('admin.blogs.create') }}" class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 hover:text-teal-600 dark:hover:text-teal-300 transition mt-2">
                    <i class="fa-solid fa-pen-to-square"></i>
                    Tulis artikel baru
                </a>
            </div>
        @else
            <div class="text-xs text-gray-400 font-semibold uppercase tracking-wider mb-3 px-2">Menu</div>

            @foreach ($generalLinks as $link)
                @if (!($link['requiresAuth'] ?? false) || $user)
                    @php $isActive = request()->routeIs($link['active']); @endphp
                    <a href="{{ route($link['route']) }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition mb-1 {{ $isActive ? '[background:#e6f7f6] [color:#025f5a] font-semibold dark:[background:#01444022] dark:text-white' : '' }}">
                        <span class="text-lg w-5 text-center"><i class="{{ $link['icon'] }}"></i></span>
                        <span>{{ $link['label'] }}</span>
                    </a>
                @endif
            @endforeach

            @if ($instructorLinks)
                <div class="text-xs text-gray-400 font-semibold uppercase tracking-wider mt-6 mb-3 px-2">Instruktur</div>
                @foreach ($instructorLinks as $link)
                    @php $isActive = request()->routeIs($link['active']); @endphp
                    <a href="{{ route($link['route']) }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition mb-1 {{ $isActive ? '[background:#e6f7f6] [color:#025f5a] font-semibold dark:[background:#01444022] dark:text-white' : '' }}">
                        <span class="text-lg w-5 text-center"><i class="{{ $link['icon'] }}"></i></span>
                        <span>{{ $link['label'] }}</span>
                    </a>
                @endforeach
            @endif

            @if ($isAdmin)
                <div class="text-xs text-gray-400 font-semibold uppercase tracking-wider mt-6 mb-3 px-2">Admin</div>
                @php $isActive = request()->routeIs('admin.*'); @endphp
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition mb-1 {{ $isActive ? '[background:#e6f7f6] [color:#025f5a] font-semibold dark:[background:#01444022] dark:text-white' : '' }}">
                    <span class="text-lg w-5 text-center"><i class="fa-solid fa-shield-halved"></i></span>
                    <span>Masuk Panel Admin</span>
                </a>
            @endif
        @endif
    </nav>
</aside>
