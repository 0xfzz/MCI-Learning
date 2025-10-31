<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'MCI (Majelis Coding Indonesia) - Dashboard')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900" rel="stylesheet" />

    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" />

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Scripts -->
    <script>
        (function(){
            try {
                var t = localStorage.getItem('theme');
                if (t === 'dark' || (!t && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                    document.documentElement.classList.add('dark');
                }
            } catch(e) {}
        })();
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="bg-gray-50 dark:bg-gray-900 font-sans antialiased text-gray-900 dark:text-gray-100">
    <div class="grid @if(View::hasSection('right-sidebar')) lg:grid-cols-[260px_1fr_380px] @else lg:grid-cols-[260px_1fr] @endif h-screen overflow-hidden bg-white dark:bg-gray-900">
        <!-- Left Sidebar -->
        @include('components.sidebar')

        <!-- Main Content -->
        <main class="overflow-y-auto p-6 lg:p-8 bg-transparent">
            <!-- Top Bar -->
            <div class="flex items-center justify-end mb-8">
                <div class="flex items-center gap-3">
                    <button data-theme-toggle class="w-10 h-10 flex items-center justify-center border border-gray-200 dark:border-gray-700 rounded-xl hover:[border-color:#025f5a] hover:[background:#e6f7f6] dark:hover:[background:#01444022] transition">
                        <i class="fa-solid fa-moon dark:hidden text-gray-700"></i>
                        <i class="fa-solid fa-sun hidden dark:block text-yellow-400"></i>
                    </button>
                    <button class="w-10 h-10 flex items-center justify-center border border-gray-200 dark:border-gray-700 rounded-xl hover:[border-color:#025f5a] hover:[background:#e6f7f6] dark:hover:[background:#01444022] transition relative">
                        <i class="fa-solid fa-bell text-gray-700 dark:text-gray-300"></i>
                        <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full"></span>
                    </button>
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="w-10 h-10 flex items-center justify-center border border-gray-200 dark:border-gray-700 rounded-xl hover:[border-color:#025f5a] hover:[background:#e6f7f6] dark:hover:[background:#01444022] transition">
                            <i class="fa-solid fa-gear text-gray-700 dark:text-gray-300"></i>
                        </button>

                        <!-- Settings Dropdown -->
                        <div
                            x-show="open"
                            @click.away="open = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-72 bg-white dark:bg-gray-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-700 z-50"
                            style="display: none;"
                        >
                            <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-full [background:linear-gradient(135deg,#06b6d4,#025f5a)] flex items-center justify-center text-white font-bold text-lg">
                                        {{ strtoupper(substr(auth()->user()->name ?? auth()->user()->username, 0, 1)) }}
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-bold text-gray-900 dark:text-white">{{ auth()->user()->name ?? auth()->user()->username }}</h3>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ auth()->user()->email }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="p-2">
                                <a href="{{ route('dashboard.profile.edit') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:[background:#e6f7f6] dark:hover:[background:#01444022] transition group">
                                    <i class="fa-solid fa-user text-gray-500 dark:text-gray-400 group-hover:[color:#025f5a]"></i>
                                    <span class="text-gray-700 dark:text-gray-300 group-hover:[color:#025f5a] font-medium">Profil Saya</span>
                                </a>

                                <a href="{{ route('dashboard.profile.password.edit') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:[background:#e6f7f6] dark:hover:[background:#01444022] transition group">
                                    <i class="fa-solid fa-key text-gray-500 dark:text-gray-400 group-hover:[color:#025f5a]"></i>
                                    <span class="text-gray-700 dark:text-gray-300 group-hover:[color:#025f5a] font-medium">Ubah Password</span>
                                </a>

                                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:[background:#e6f7f6] dark:hover:[background:#01444022] transition group">
                                    <i class="fa-solid fa-bell text-gray-500 dark:text-gray-400 group-hover:[color:#025f5a]"></i>
                                    <span class="text-gray-700 dark:text-gray-300 group-hover:[color:#025f5a] font-medium">Notifikasi</span>
                                </a>

                                <div class="my-2 border-t border-gray-200 dark:border-gray-700"></div>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-red-50 dark:hover:bg-red-900/20 transition group">
                                        <i class="fa-solid fa-right-from-bracket text-gray-500 dark:text-gray-400 group-hover:text-red-600"></i>
                                        <span class="text-gray-700 dark:text-gray-300 group-hover:text-red-600 font-medium">Keluar</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if (session('status'))
                <div class="mb-4 px-4 py-3 rounded-xl border border-emerald-200 bg-emerald-50 text-emerald-700 dark:border-emerald-900/50 dark:bg-emerald-900/20 dark:text-emerald-200">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 px-4 py-3 rounded-xl border border-rose-200 bg-rose-50 text-rose-600 dark:border-rose-900/50 dark:bg-rose-900/20 dark:text-rose-200">
                    <ul class="list-disc list-inside space-y-1 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>

        <!-- Right Sidebar (Optional) -->
        @yield('right-sidebar')
    </div>
    @stack('scripts')
</body>
</html>
