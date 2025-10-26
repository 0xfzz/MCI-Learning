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
    <div class="grid lg:grid-cols-[260px_1fr] xl:grid-cols-[260px_1fr_340px] h-screen overflow-hidden bg-white dark:bg-gray-900">
        <!-- Left Sidebar -->
        @include('components.sidebar')

        <!-- Main Content -->
    <main class="overflow-y-auto p-6 lg:p-8 bg-transparent">
            <!-- Top Bar -->
            <div class="flex items-center justify-between mb-8">
                <div class="flex-1 max-w-2xl">
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </span>
                        <input
                            type="text"
                            placeholder="@yield('search-placeholder', 'Cari tutorial disini...')"
                            class="w-full pl-12 pr-4 py-3 border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 rounded-xl focus:outline-none focus:ring-2 [focus:ring-color:#025f5a] focus:border-transparent transition"
                        >
                    </div>
                </div>
                <div class="flex items-center gap-3 ml-4">
                    <button data-theme-toggle class="w-10 h-10 flex items-center justify-center border border-gray-200 dark:border-gray-700 rounded-xl hover:[border-color:#025f5a] hover:[background:#e6f7f6] dark:hover:[background:#01444022] transition">
                        <i class="fa-solid fa-moon block dark:hidden"></i>
                        <i class="fa-solid fa-sun hidden dark:block"></i>
                    </button>
                    <button class="w-10 h-10 flex items-center justify-center border border-gray-200 dark:border-gray-700 rounded-xl hover:[border-color:#025f5a] hover:[background:#e6f7f6] dark:hover:[background:#01444022] transition">
                        <i class="fa-solid fa-bell"></i>
                    </button>
                    <button class="w-10 h-10 flex items-center justify-center border border-gray-200 dark:border-gray-700 rounded-xl hover:[border-color:#025f5a] hover:[background:#e6f7f6] dark:hover:[background:#01444022] transition">
                        <i class="fa-solid fa-gear"></i>
                    </button>
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
        <div class="bg-white dark:bg-gray-900 border-l border-gray-200 dark:border-gray-800">
            @yield('right-sidebar')
        </div>
    </div>
    @stack('scripts')
</body>
</html>
