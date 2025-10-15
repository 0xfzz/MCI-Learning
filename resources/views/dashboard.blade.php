@extends('layouts.dashboard')

@section('title', 'MCI (Majelis Coding Indonesia) - Dashboard')

@section('search-placeholder', 'Search your course here...')

@section('content')
<!-- Hero Banner -->
<div class="[background:linear-gradient(135deg,#06b6d4_0%,#4f46e5_50%,#025f5a_100%)] rounded-3xl p-12 mb-8 relative overflow-hidden">
    <div class="absolute -right-20 -top-20 w-72 h-72 [background:rgba(255,255,255,0.1)] rounded-full"></div>
    <div class="absolute right-12 -bottom-24 w-60 h-60 [background:rgba(255,255,255,0.08)] rounded-full"></div>
 
    <div class="relative z-10">
    <div class="text-xs uppercase tracking-wider mb-3 font-semibold text-white/80">ONLINE COURSE</div>
    <h1 class="text-4xl font-black mb-6 leading-tight text-white">Sharpen Your Skills With<br>Professional Online Courses</h1>
        <button class="px-7 py-3.5 [background:#333] text-white rounded-xl font-semibold hover:[background:#262626] transition flex items-center gap-2 hover:-translate-y-1">
            <i class="fa-solid fa-bullseye"></i>
            Join Now
        </button>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    @php
        $stats = [
            ['icon' => 'fa-code', 'watched' => '8/15 Watched', 'title' => 'Front-end', 'grad' => 'linear-gradient(135deg,#14b8a6,#06b6d4)'],
            ['icon' => 'fa-database', 'watched' => '3/14 Watched', 'title' => 'Back-end', 'grad' => 'linear-gradient(135deg,#6366f1,#7c3aed)'],
            ['icon' => 'fa-pen-ruler', 'watched' => '2/6 Watched', 'title' => 'Product Design', 'grad' => 'linear-gradient(135deg,#f59e0b,#f97316)'],
            ['icon' => 'fa-diagram-project', 'watched' => '9/10 Watched', 'title' => 'Project Manager', 'grad' => 'linear-gradient(135deg,#10b981,#14b8a6)'],
        ];
    @endphp

    @foreach($stats as $stat)
    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl p-5 hover:[border-color:#025f5a] hover:-translate-y-2 hover:shadow-xl transition-all cursor-pointer">
            <div class="flex items-start justify-between mb-3">
                <span class="w-10 h-10 rounded-xl flex items-center justify-center text-white shadow-sm" style="background: {{ $stat['grad'] }}">
                    <i class="fa-solid {{ $stat['icon'] }}"></i>
                </span>
                <span class="text-gray-300 text-lg font-black cursor-pointer"><i class="fa-solid fa-ellipsis-vertical"></i></span>
            </div>
            <div class="text-sm text-gray-400 mb-1">{{ $stat['watched'] }}</div>
            <div class="font-bold text-gray-900 dark:text-gray-100">{{ $stat['title'] }}</div>
        </div>
    @endforeach
</div>

<!-- Continue Watching Section -->
<div class="flex items-center justify-between mb-6">
    <h2 class="text-2xl font-extrabold text-gray-900 dark:text-gray-100">Continue Watching</h2>
    <div class="flex gap-2">
        <button class="w-9 h-9 border border-gray-200 rounded-lg hover:[border-color:#025f5a] hover:[background:#e6f7f6] transition flex items-center justify-center">
            <i class="fa-solid fa-chevron-left"></i>
        </button>
        <button class="w-9 h-9 border border-gray-200 rounded-lg hover:[border-color:#025f5a] hover:[background:#e6f7f6] transition flex items-center justify-center">
            <i class="fa-solid fa-chevron-right"></i>
        </button>
    </div>
</div>

<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
    @php
        $courses = [
            ['bg' => 'from-teal-500 to-cyan-500', 'icon' => 'fa-laptop-code', 'badge' => 'FRONTEND', 'title' => "Beginner's Guide To Becoming A Professional Frontend Developer", 'students' => '+124'],
            ['bg' => 'from-indigo-600 to-violet-500', 'icon' => 'fa-server', 'badge' => 'BACKEND', 'title' => "Beginner's Guide To Becoming A Professional Backend Developer", 'students' => '+27'],
            ['bg' => 'from-amber-400 to-orange-500', 'icon' => 'fa-palette', 'badge' => 'FRONTEND', 'title' => "Beginner's Guide To Becoming A Professional Frontend Developer", 'students' => '+87'],
        ];
    @endphp

    @foreach($courses as $course)
    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl overflow-hidden hover:[border-color:#025f5a] hover:-translate-y-2 hover:shadow-2xl transition-all cursor-pointer">
            <div class="h-44 bg-gradient-to-br {{ $course['bg'] }} flex items-center justify-center text-5xl relative">
                <span class="opacity-40"><i class="fa-solid {{ $course['icon'] }}"></i></span>
                <button class="absolute top-3 right-3 w-8 h-8 bg-white/95 rounded-full flex items-center justify-center">
                    <i class="fa-regular fa-heart text-[16px]"></i>
                </button>
            </div>
            <div class="p-5">
                @php
                    $badgeStyles = [
                        'FRONTEND' => 'background:#e6f7f6;color:#025f5a;',
                        'BACKEND'  => 'background:rgba(99,102,241,0.12);color:#4f46e5;',
                        'DESIGN'   => 'background:rgba(245,158,11,0.12);color:#d97706;',
                    ];
                    $badge = $course['badge'];
                    $style = $badgeStyles[$badge] ?? 'background:#e6f7f6;color:#025f5a;';
                @endphp
                <span class="inline-block px-3 py-1 text-xs font-bold uppercase rounded-md mb-3" style="{{ $style }}">
                    {{ $badge }}
                </span>
                <h3 class="font-bold text-gray-900 dark:text-gray-100 mb-4 leading-snug">{{ $course['title'] }}</h3>
                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                    <div class="flex items-center gap-2">
                        <div class="flex -space-x-2">
                            <div class="w-7 h-7 rounded-full [background:linear-gradient(to_br,#06b6d4,#025f5a)] border-2 border-white"></div>
                            <div class="w-7 h-7 rounded-full [background:linear-gradient(to_br,#10b981,#059669)] border-2 border-white"></div>
                            <div class="w-7 h-7 rounded-full [background:linear-gradient(to_br,#14b8a6,#0d9488)] border-2 border-white"></div>
                        </div>
                        <span class="text-sm text-gray-600 dark:text-gray-300 font-semibold">{{ $course['students'] }}</span>
                    </div>
                    <div class="w-8 h-8 [background:linear-gradient(to_br,#06b6d4,#025f5a)] rounded-full flex items-center justify-center text-white cursor-pointer hover:scale-110 transition ring-2 ring-white/60">
                        <i class="fa-solid fa-arrow-right"></i>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<!-- Your Mentor Section -->
<div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl p-8">
    <div class="flex items-center justify-between mb-6">
    <h2 class="text-2xl font-extrabold text-gray-900 dark:text-gray-100">Your Mentor</h2>
        <button class="[color:#025f5a] font-semibold text-sm underline hover:[color:#014440]">See All</button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-100 dark:border-gray-800">
                    <th class="text-left py-3 px-4 text-xs text-gray-400 font-bold uppercase tracking-wider">Instructor Name & Date</th>
                    <th class="text-left py-3 px-4 text-xs text-gray-400 font-bold uppercase tracking-wider">Course Type</th>
                    <th class="text-left py-3 px-4 text-xs text-gray-400 font-bold uppercase tracking-wider">Course Title</th>
                    <th class="text-left py-3 px-4 text-xs text-gray-400 font-bold uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $mentors = [
                        ['name' => 'Alex Morgan', 'date' => '25/02/2023', 'type' => 'FRONTEND', 'course' => 'Understanding Concept Of React'],
                        ['name' => 'Nikolas Helmet', 'date' => '18/03/2023', 'type' => 'BACKEND', 'course' => 'Concept Of The Data Base'],
                        ['name' => 'Josh Freakson', 'date' => '12/04/2023', 'type' => 'BACKEND', 'course' => 'Core Development Approaches'],
                    ];
                @endphp

                @foreach($mentors as $mentor)
                    <tr class="border-b border-gray-50 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-800 transition cursor-pointer">
                        <td class="py-5 px-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full [background:linear-gradient(135deg,#06b6d4,#025f5a)]"></div>
                                <div>
                                    <div class="font-semibold text-gray-900 dark:text-gray-100">{{ $mentor['name'] }}</div>
                                    <div class="text-sm text-gray-400">{{ $mentor['date'] }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-5 px-4">
                            <span class="inline-block px-3 py-1 [background:#e6f7f6] [color:#025f5a] text-xs font-bold uppercase rounded-md">
                                {{ $mentor['type'] }}
                            </span>
                        </td>
                        <td class="py-5 px-4 text-gray-600 dark:text-gray-300">{{ $mentor['course'] }}</td>
                        <td class="py-5 px-4">
                            <button class="[color:#025f5a] text-lg hover:[color:#014440]"><i class="fa-solid fa-pen"></i></button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('right-sidebar')
<aside class="bg-white dark:bg-gray-900 border-l border-gray-200 dark:border-gray-800 p-6 overflow-y-auto hidden xl:block">
    <!-- Profile Section -->
    <div class="text-center mb-8">
        <div class="flex items-center justify-between mb-5">
            <h3 class="font-bold text-gray-900 dark:text-gray-100 text-lg">Your Profile</h3>
            <button class="text-gray-300 dark:text-gray-500 text-xl font-black">⋮</button>
        </div>

        <div class="w-20 h-20 rounded-full [background:linear-gradient(135deg,#06b6d4,#025f5a)] mx-auto mb-4 ring-4 [ring-color:#e6f7f6]"></div>
    <h4 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">Good Morning Alex</h4>
    <p class="text-sm text-gray-500 dark:text-gray-400 mb-5 px-4">Continue Your Journey And Achieve Your Target</p>

        <div class="flex justify-center gap-3">
            <button class="w-10 h-10 bg-gray-100 dark:bg-gray-800 rounded-xl flex items-center justify-center hover:[background:#e6f7f6] dark:hover:[background:#01444022] hover:[color:#025f5a] transition"><i class="fa-solid fa-bell"></i></button>
            <button class="w-10 h-10 bg-gray-100 dark:bg-gray-800 rounded-xl flex items-center justify-center hover:[background:#e6f7f6] dark:hover:[background:#01444022] hover:[color:#025f5a] transition"><i class="fa-solid fa-envelope"></i></button>
            <button class="w-10 h-10 bg-gray-100 dark:bg-gray-800 rounded-xl flex items-center justify-center hover:[background:#e6f7f6] dark:hover:[background:#01444022] hover:[color:#025f5a] transition"><i class="fa-solid fa-user"></i></button>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl p-5 mb-6">
        <div class="flex gap-2 items-end h-32 mb-3">
            @php
                $bars = [
                    ['h' => 50, 'grad' => 'linear-gradient(to_top,#14b8a6,#06b6d4)'],
                    ['h' => 68, 'grad' => 'linear-gradient(to_top,#6366f1,#7c3aed)'],
                    ['h' => 78, 'grad' => 'linear-gradient(to_top,#f59e0b,#f97316)'],
                    ['h' => 88, 'grad' => 'linear-gradient(to_top,#06b6d4,#025f5a)'],
                    ['h' => 100, 'grad' => 'linear-gradient(to_top,#10b981,#14b8a6)'],
                ];
            @endphp
            @foreach($bars as $bar)
                <div class="flex-1 rounded-t-lg opacity-60 hover:opacity-100 transition cursor-pointer" style="height: {{ $bar['h'] }}%; background: {{ $bar['grad'] }}"></div>
            @endforeach
        </div>
    </div>

    <!-- Mentors List -->
    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl p-5">
        <div class="flex items-center justify-between mb-5">
            <h4 class="font-bold text-gray-900 dark:text-gray-100">Your Mentor</h4>
            <button class="w-8 h-8 [background:#e6f7f6] rounded-lg [color:#025f5a] font-bold hover:[background:#025f5a] hover:text-white transition flex items-center justify-center">
                <i class="fa-solid fa-plus"></i>
            </button>
        </div>

        @php
            $sidebarMentors = [
                ['name' => 'Kilian Rosvelt', 'role' => 'Software Developer'],
                ['name' => 'Teodor Maskevich', 'role' => 'Product Owner'],
                ['name' => 'Andrew Kooller', 'role' => 'Frontend Developer'],
                ['name' => 'Adam Chekich', 'role' => 'Backend Developer'],
                ['name' => 'Anton Peterson', 'role' => 'Software Developer'],
                ['name' => 'Matew Jackson', 'role' => 'Product Designer'],
            ];
        @endphp

        @foreach($sidebarMentors as $mentor)
            <div class="flex items-center justify-between py-3 {{ !$loop->last ? 'border-b border-gray-100 dark:border-gray-800' : '' }}">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full [background:linear-gradient(135deg,#06b6d4,#025f5a)]"></div>
                    <div>
                        <div class="font-semibold text-sm text-gray-900 dark:text-gray-100">{{ $mentor['name'] }}</div>
                        <div class="text-xs text-gray-400">{{ $mentor['role'] }}</div>
                    </div>
                </div>
                <button class="px-5 py-2 [background:#025f5a] text-white text-xs font-semibold rounded-lg hover:[background:#014440] transition">Follow</button>
            </div>
        @endforeach

        <button class="w-full mt-3 py-2.5 bg-gray-100 dark:bg-gray-800 [color:#025f5a] font-semibold text-sm rounded-lg hover:[background:#e6f7f6] dark:hover:[background:#01444022] transition">
            See All
        </button>
    </div>
</aside>
@endsection
