<aside class="bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-800 p-6 overflow-y-auto hidden lg:block">
    <!-- Logo -->
    <a href="{{ route('dashboard.index') }}" class="flex items-center gap-3 mb-10 px-1">
        <img src="{{ asset('assets/logo/hijau.png') }}" alt="MCI (Majelis Coding Indonesia)" class="h-10 w-auto dark:hidden">
        <img src="{{ asset('assets/logo/putih.png') }}" alt="MCI (Majelis Coding Indonesia)" class="hidden h-10 w-auto dark:block">
    </a>

    @php
        $user = auth()->user();
        $isAdmin = $user && method_exists($user, 'isAdmin') && $user->isAdmin();
        $isInstructor = $user && method_exists($user, 'isInstructor') && $user->isInstructor();
        $isStudent = $user && method_exists($user, 'isStudent') && $user->isStudent();

        // Build menu based on user role
        $menuItems = [];

        if ($isAdmin) {
            // Admin menus - all integrated
            $menuItems = [
                [
                    'route' => 'home',
                    'active' => 'home',
                    'icon' => 'fa-solid fa-compass',
                    'label' => 'Beranda',
                ],
                [
                    'route' => 'dashboard.index',
                    'active' => 'dashboard.index',
                    'icon' => 'fa-solid fa-gauge',
                    'label' => 'Dashboard',
                ],
                [
                    'route' => 'dashboard.users.index',
                    'active' => 'dashboard.users.*',
                    'icon' => 'fa-solid fa-users',
                    'label' => 'Kelola Pengguna',
                ],
                [
                    'route' => 'dashboard.sales.index',
                    'active' => 'dashboard.sales.*',
                    'icon' => 'fa-solid fa-chart-line',
                    'label' => 'Performa Penjualan',
                ],
                [
                    'route' => 'dashboard.transactions.index',
                    'active' => 'dashboard.transactions.*',
                    'icon' => 'fa-solid fa-clipboard-check',
                    'label' => 'Verifikasi Transaksi',
                ],
                [
                    'route' => 'dashboard.blogs.index',
                    'active' => 'dashboard.blogs.*',
                    'icon' => 'fa-solid fa-pen-nib',
                    'label' => 'Kelola Blog',
                ],
                [
                    'route' => 'courses.index',
                    'active' => 'courses.index',
                    'icon' => 'fa-solid fa-book',
                    'label' => 'Katalog Kursus',
                ],
                [
                    'route' => 'blog.index',
                    'active' => 'blog.*',
                    'icon' => 'fa-solid fa-newspaper',
                    'label' => 'Blog',
                ],
                [
                    'separator' => true,
                ],
                [
                    'collapse' => true,
                    'id' => 'profile-menu',
                    'icon' => 'fa-solid fa-user-circle',
                    'label' => 'Profile',
                    'active' => 'dashboard.profile.*',
                    'submenu' => [
                        [
                            'route' => 'dashboard.profile.edit',
                            'active' => 'dashboard.profile.edit',
                            'icon' => 'fa-solid fa-id-card',
                            'label' => 'Edit Profile',
                        ],
                        [
                            'route' => 'dashboard.profile.password.edit',
                            'active' => 'dashboard.profile.password.*',
                            'icon' => 'fa-solid fa-key',
                            'label' => 'Reset Password',
                        ],
                    ],
                ],
                [
                    'separator' => true,
                ],
            ];
        } elseif ($isInstructor) {
            // Instructor menus
            $menuItems = [
                [
                    'route' => 'home',
                    'active' => 'home',
                    'icon' => 'fa-solid fa-compass',
                    'label' => 'Beranda',
                ],
                [
                    'route' => 'dashboard.index',
                    'active' => 'dashboard.index',
                    'icon' => 'fa-solid fa-gauge',
                    'label' => 'Dashboard',
                ],
                [
                    'route' => 'dashboard.courses.index',
                    'active' => 'dashboard.courses.*',
                    'icon' => 'fa-solid fa-graduation-cap',
                    'label' => 'Kelola Kursus',
                ],
                [
                    'route' => 'blog.index',
                    'active' => 'blog.*',
                    'icon' => 'fa-solid fa-newspaper',
                    'label' => 'Blog',
                ],
                [
                    'separator' => true,
                ],
                [
                    'collapse' => true,
                    'id' => 'profile-menu',
                    'icon' => 'fa-solid fa-user-circle',
                    'label' => 'Profile',
                    'active' => 'dashboard.profile.*',
                    'submenu' => [
                        [
                            'route' => 'dashboard.profile.edit',
                            'active' => 'dashboard.profile.edit',
                            'icon' => 'fa-solid fa-id-card',
                            'label' => 'Edit Profile',
                        ],
                        [
                            'route' => 'dashboard.profile.password.edit',
                            'active' => 'dashboard.profile.password.*',
                            'icon' => 'fa-solid fa-key',
                            'label' => 'Reset Password',
                        ],
                    ],
                ],
                [
                    'separator' => true,
                ],
            ];
        } elseif ($isStudent) {
            // Student menus
            $menuItems = [
                [
                    'route' => 'home',
                    'active' => 'home',
                    'icon' => 'fa-solid fa-compass',
                    'label' => 'Beranda',
                ],
                [
                    'route' => 'dashboard.index',
                    'active' => 'dashboard.index',
                    'icon' => 'fa-solid fa-gauge',
                    'label' => 'Dashboard',
                ],
                [
                    'route' => 'dashboard.my-courses.index',
                    'active' => 'dashboard.my-courses.*',
                    'icon' => 'fa-solid fa-book-open',
                    'label' => 'Jelajahi Kursus',
                ],
                [
                    'route' => 'blog.index',
                    'active' => 'blog.*',
                    'icon' => 'fa-solid fa-newspaper',
                    'label' => 'Blog',
                ],
                [
                    'separator' => true,
                ],
                [
                    'collapse' => true,
                    'id' => 'profile-menu',
                    'icon' => 'fa-solid fa-user-circle',
                    'label' => 'Profile',
                    'active' => 'dashboard.profile.*',
                    'submenu' => [
                        [
                            'route' => 'dashboard.profile.edit',
                            'active' => 'dashboard.profile.edit',
                            'icon' => 'fa-solid fa-id-card',
                            'label' => 'Edit Profile',
                        ],
                        [
                            'route' => 'dashboard.profile.password.edit',
                            'active' => 'dashboard.profile.password.*',
                            'icon' => 'fa-solid fa-key',
                            'label' => 'Reset Password',
                        ],
                    ],
                ],
                [
                    'separator' => true,
                ],
            ];
        } else {
            // Guest or unknown role
            $menuItems = [
                [
                    'route' => 'home',
                    'active' => 'home',
                    'icon' => 'fa-solid fa-compass',
                    'label' => 'Beranda',
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
        }
    @endphp

    <nav x-data="{ profileOpen: {{ request()->routeIs('dashboard.profile.*') ? 'true' : 'false' }} }">
        @foreach ($menuItems as $item)
            @if (isset($item['separator']) && $item['separator'])
                <div class="my-4 border-t border-gray-200 dark:border-gray-800"></div>
            @elseif (isset($item['collapse']) && $item['collapse'])
                {{-- Collapsible Menu --}}
                @php
                    $isParentActive = false;
                    foreach (explode('|', $item['active']) as $pattern) {
                        if (request()->routeIs(trim($pattern))) {
                            $isParentActive = true;
                            break;
                        }
                    }
                @endphp
                <div>
                    <button
                        @click="profileOpen = !profileOpen"
                        class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition mb-1 {{ $isParentActive ? '[background:#e6f7f6] [color:#025f5a] font-semibold dark:[background:#01444022] dark:text-white' : '' }}"
                    >
                        <div class="flex items-center gap-3">
                            <span class="text-lg w-5 text-center"><i class="{{ $item['icon'] }}"></i></span>
                            <span>{{ $item['label'] }}</span>
                        </div>
                        <i class="fa-solid fa-chevron-down text-xs transition-transform" :class="profileOpen ? 'rotate-180' : ''"></i>
                    </button>

                    <div x-show="profileOpen" x-collapse class="ml-8 space-y-1 mb-1">
                        @foreach ($item['submenu'] as $subitem)
                            @php
                                $isSubActive = false;
                                foreach (explode('|', $subitem['active']) as $pattern) {
                                    if (request()->routeIs(trim($pattern))) {
                                        $isSubActive = true;
                                        break;
                                    }
                                }
                            @endphp
                            <a href="{{ route($subitem['route']) }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm transition {{ $isSubActive ? '[background:#e6f7f6] [color:#025f5a] font-semibold dark:[background:#01444022] dark:text-white' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                                <span class="text-base w-5 text-center"><i class="{{ $subitem['icon'] }}"></i></span>
                                <span>{{ $subitem['label'] }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @else
                @php
                    $activePatterns = explode('|', $item['active']);
                    $isActive = false;
                    foreach ($activePatterns as $pattern) {
                        if (request()->routeIs(trim($pattern))) {
                            $isActive = true;
                            break;
                        }
                    }
                @endphp
                <a href="{{ route($item['route']) }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition mb-1 {{ $isActive ? '[background:#e6f7f6] [color:#025f5a] font-semibold dark:[background:#01444022] dark:text-white' : '' }}">
                    <span class="text-lg w-5 text-center"><i class="{{ $item['icon'] }}"></i></span>
                    <span>{{ $item['label'] }}</span>
                </a>
            @endif
        @endforeach

        @auth
            <div class="mt-8 border-t border-dashed border-gray-200 dark:border-gray-800 pt-4">
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 text-sm text-rose-500 hover:border-rose-400/60 transition">
                        <span class="text-lg w-5 text-center"><i class="fa-solid fa-arrow-right-from-bracket"></i></span>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        @endauth
    </nav>
</aside>
