<aside class="bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-800 p-6 overflow-y-auto hidden lg:block">
    <!-- Logo -->
    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 mb-10 px-1">
        <!-- Logo image with light/dark mode support -->
        <img src="{{ asset('assets/logo/hijau.png') }}" alt="MCI (Majelis Coding Indonesia)" class="h-10 w-auto">
    </a>

    <!-- Navigation -->
    <nav>
        <div class="text-xs text-gray-400 font-semibold uppercase tracking-wider mb-3 px-2">
            Menu
        </div>

    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition mb-1 {{ request()->routeIs('dashboard') ? '[background:#e6f7f6] [color:#025f5a] font-semibold dark:[background:#01444022] dark:text-white' : '' }}">
            <span class="text-lg w-5 text-center"><i class="fa-solid fa-house"></i></span>
            <span>Dashboard</span>
        </a>

    <a href="{{ route('courses.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition mb-1 {{ request()->routeIs('courses.*') ? '[background:#e6f7f6] [color:#025f5a] font-semibold dark:[background:#01444022] dark:text-white' : '' }}">
            <span class="text-lg w-5 text-center"><i class="fa-solid fa-book"></i></span>
            <span>Tutorial</span>
        </a>

    <a href="{{ route('blog.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition mb-1 {{ request()->routeIs('blog.*') ? '[background:#e6f7f6] [color:#025f5a] font-semibold dark:[background:#01444022] dark:text-white' : '' }}">
            <span class="text-lg w-5 text-center"><i class="fa-solid fa-newspaper"></i></span>
            <span>Blog</span>
        </a>

    <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition mb-1">
            <span class="text-lg w-5 text-center"><i class="fa-solid fa-lightbulb"></i></span>
            <span>Info Open Source</span>
        </a>

    <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition mb-1">
            <span class="text-lg w-5 text-center"><i class="fa-solid fa-envelope"></i></span>
            <span>Contact</span>
        </a>

    <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition mb-1">
            <span class="text-lg w-5 text-center"><i class="fa-solid fa-trophy"></i></span>
            <span>Leaderboard</span>
        </a>

        @if(auth()->check() && auth()->user() instanceof \App\Models\User && auth()->user()->isAdmin())
            <div class="text-xs text-gray-400 font-semibold uppercase tracking-wider mt-6 mb-3 px-2">
                Admin
            </div>

        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition mb-1 {{ request()->routeIs('admin.dashboard') ? '[background:#e6f7f6] [color:#025f5a] font-semibold dark:[background:#01444022] dark:text-white' : '' }}">
                <span class="text-lg w-5 text-center"><i class="fa-solid fa-shield-halved"></i></span>
                <span>Admin Dashboard</span>
            </a>

        <a href="{{ route('admin.blogs.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition mb-1 {{ request()->routeIs('admin.blogs.*') ? '[background:#e6f7f6] [color:#025f5a] font-semibold dark:[background:#01444022] dark:text-white' : '' }}">
                <span class="text-lg w-5 text-center"><i class="fa-solid fa-pen-nib"></i></span>
                <span>Kelola Blog</span>
            </a>
        @endif

        <div class="text-xs text-gray-400 font-semibold uppercase tracking-wider mt-6 mb-3 px-2">
            Kategori
        </div>

    <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition mb-1">
            <span class="text-lg w-5 text-center"><i class="fa-brands fa-react"></i></span>
            <span>React JS</span>
        </a>

    <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition mb-1">
            <span class="text-lg w-5 text-center"><i class="fa-brands fa-vuejs"></i></span>
            <span>Vue JS</span>
        </a>

    <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition mb-1">
            <span class="text-lg w-5 text-center"><i class="fa-brands fa-angular"></i></span>
            <span>Angular</span>
        </a>

        <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 hover:bg-gray-50 transition mb-1">
            <span class="text-lg w-5 text-center"><i class="fa-brands fa-node-js"></i></span>
            <span>Node JS</span>
        </a>
    </nav>
</aside>
