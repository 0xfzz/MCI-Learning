@extends('layouts.dashboard')

@section('title', 'COURSUE - Course Platform')

@section('search-placeholder', 'Cari tutorial disini...')

@section('content')
<!-- Breadcrumb -->
<nav class="bg-white border border-gray-200 rounded-xl px-4 py-3 mb-8 flex items-center gap-2 text-sm">
    <a href="#" class="[color:#999] hover:[color:#7c3aed] transition">Home</a>
    <span class="[color:#ccc]">›</span>
    <a href="#" class="[color:#999] hover:[color:#7c3aed] transition">Tutorial</a>
    <span class="[color:#ccc]">›</span>
    <a href="#" class="[color:#999] hover:[color:#7c3aed] transition">Frontend</a>
    <span class="[color:#ccc]">›</span>
    <span class="[color:#7c3aed] font-semibold">React Hooks</span>
</nav>

<!-- Video Player Card -->
<div class="bg-white border border-gray-200 rounded-2xl overflow-hidden mb-6">
    <div class="p-5">
        <div class="relative w-full pb-[56.25%] rounded-xl overflow-hidden [background:#000] shadow-2xl">
            <iframe
                class="absolute top-0 left-0 w-full h-full"
                src="https://www.youtube.com/embed/dQw4w9WgXcQ"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen>
            </iframe>
        </div>
    </div>
    <div class="px-6 pb-6 border-t border-gray-100">
        <h1 class="text-3xl font-bold [color:#1f2937] mt-6 mb-3">Introduction to React Hooks - useState & useEffect</h1>
        <div class="flex items-center gap-5 text-sm [color:#999]">
            <span class="flex items-center gap-2">
                <span>👁️</span>
                <span>12,458 views</span>
            </span>
            <span class="flex items-center gap-2">
                <span>📅</span>
                <span>2 hari yang lalu</span>
            </span>
            <span class="flex items-center gap-2">
                <span>⏱️</span>
                <span>24:35</span>
            </span>
        </div>
    </div>
</div>

<!-- Forum Discussion Card -->
<div class="bg-white border border-gray-200 rounded-2xl p-6 mb-6 hover:[border-color:#7c3aed] hover:shadow-lg transition-all">
    <div class="flex items-center gap-4 mb-5">
        <div class="w-12 h-12 [background:linear-gradient(135deg,#f3f0ff,#e9d5ff)] rounded-xl flex items-center justify-center text-2xl">
            💬
        </div>
        <div class="flex-1">
            <h3 class="font-bold [color:#1f2937] text-lg">Forum Diskusi</h3>
            <p class="text-sm [color:#999]">Bergabung dengan 1,247 diskusi aktif</p>
        </div>
    </div>
    <button class="px-6 py-3 [background:#7c3aed] text-white rounded-xl font-semibold hover:[background:#6d28d9] transition hover:-translate-y-1 [box-shadow:0_6px_16px_rgba(124,58,237,0.3)]">
        Lihat Forum
    </button>
</div>

<!-- WhatsApp Group Card -->
<div class="bg-white border border-gray-200 rounded-2xl p-6 mb-6 hover:[border-color:#10b981] hover:shadow-lg transition-all">
    <div class="flex items-center gap-4 mb-5">
        <div class="w-12 h-12 [background:linear-gradient(135deg,#d1fae5,#a7f3d0)] rounded-xl flex items-center justify-center text-2xl">
            📱
        </div>
        <div class="flex-1">
            <h3 class="font-bold [color:#1f2937] text-lg">Grup WhatsApp</h3>
            <p class="text-sm [color:#999]">Join komunitas belajar dengan 500+ members</p>
        </div>
    </div>
    <button class="px-6 py-3 [background:#10b981] text-white rounded-xl font-semibold hover:[background:#059669] transition hover:-translate-y-1 [box-shadow:0_6px_16px_rgba(16,185,129,0.3)]">
        Gabung Grup
    </button>
</div>

<!-- Source Code Download Card -->
<div class="bg-white border border-gray-200 rounded-2xl p-6 hover:[border-color:#3b82f6] hover:shadow-lg transition-all">
    <div class="flex items-center gap-4 mb-5">
        <div class="w-12 h-12 [background:linear-gradient(135deg,#dbeafe,#bfdbfe)] rounded-xl flex items-center justify-center text-2xl">
            💾
        </div>
        <div class="flex-1">
            <h3 class="font-bold [color:#1f2937] text-lg">Download Source Code</h3>
            <p class="text-sm [color:#999]">Akses full source code untuk tutorial ini</p>
        </div>
    </div>

    <div class="[background:#fff7ed] [border:1px_solid_#fed7aa] rounded-xl p-4 mb-5 flex gap-3">
        <span class="[color:#f59e0b] text-xl flex-shrink-0">⚠️</span>
        <p class="text-sm [color:#404040]">
            <strong>Perhatian:</strong> Source code hanya untuk keperluan belajar. Dilarang menggunakan untuk keperluan komersial tanpa izin.
        </p>
    </div>

    <button class="px-6 py-3 [background:#3b82f6] text-white rounded-xl font-semibold hover:[background:#2563eb] transition hover:-translate-y-1 [box-shadow:0_6px_16px_rgba(59,130,246,0.3)]">
        Download Source Code
    </button>
</div>
@endsection

@section('right-sidebar')
<aside class="bg-white border-l border-gray-200 p-6 overflow-y-auto hidden xl:block">
    <!-- Playlist Header -->
    <div class="pb-5 border-b border-gray-200 mb-5">
        <h2 class="text-lg font-bold [color:#1f2937] mb-2">Daftar Video</h2>
        <p class="text-sm [color:#999] mb-3">24 videos • 6 jam 45 menit</p>
        <button class="[color:#7c3aed] text-sm font-semibold underline hover:[color:#6d28d9]" onclick="toggleAllCategories()">
            <span id="toggleText">Lihat Semua</span>
        </button>
    </div>

    <!-- Playlist Content -->
    <div class="space-y-2">
        @php
            $categories = [
                [
                    'name' => 'Pengenalan React',
                    'count' => 5,
                    'expanded' => true,
                    'videos' => [
                        ['title' => 'Apa itu React dan Kenapa Menggunakannya?', 'duration' => '15:30', 'watched' => true],
                        ['title' => 'Setup Environment untuk React Development', 'duration' => '12:45', 'watched' => true],
                        ['title' => 'Introduction to React Hooks - useState & useEffect', 'duration' => '24:35', 'watched' => false, 'active' => true],
                        ['title' => 'JSX Syntax dan Component Basics', 'duration' => '18:20', 'watched' => false],
                        ['title' => 'Props dan State Management', 'duration' => '22:10', 'watched' => false],
                    ]
                ],
                [
                    'name' => 'Advanced Hooks',
                    'count' => 6,
                    'expanded' => true,
                    'videos' => [
                        ['title' => 'useContext untuk State Global', 'duration' => '19:45', 'watched' => false],
                        ['title' => 'useReducer untuk Complex State Logic', 'duration' => '25:30', 'watched' => false],
                        ['title' => 'useCallback dan useMemo Optimization', 'duration' => '21:15', 'watched' => false],
                        ['title' => 'useRef untuk DOM Manipulation', 'duration' => '16:40', 'watched' => false],
                        ['title' => 'Custom Hooks - Membuat Hooks Sendiri', 'duration' => '28:20', 'watched' => false],
                        ['title' => 'useLayoutEffect vs useEffect', 'duration' => '14:55', 'watched' => false],
                    ]
                ],
                [
                    'name' => 'React Router',
                    'count' => 4,
                    'expanded' => false,
                    'videos' => [
                        ['title' => 'Setup React Router v6', 'duration' => '13:25', 'watched' => false],
                        ['title' => 'Nested Routes dan Layout', 'duration' => '20:10', 'watched' => false],
                        ['title' => 'Dynamic Routes dan URL Parameters', 'duration' => '17:35', 'watched' => false],
                        ['title' => 'Protected Routes dan Authentication', 'duration' => '23:50', 'watched' => false],
                    ]
                ],
                [
                    'name' => 'State Management',
                    'count' => 5,
                    'expanded' => false,
                    'videos' => [
                        ['title' => 'Introduction to Redux Toolkit', 'duration' => '26:40', 'watched' => false],
                        ['title' => 'Redux Store dan Slices', 'duration' => '22:15', 'watched' => false],
                        ['title' => 'Async Actions dengan createAsyncThunk', 'duration' => '28:30', 'watched' => false],
                        ['title' => 'Zustand - Alternative State Management', 'duration' => '19:20', 'watched' => false],
                        ['title' => 'Jotai untuk Atomic State Management', 'duration' => '16:45', 'watched' => false],
                    ]
                ],
                [
                    'name' => 'Project Final',
                    'count' => 4,
                    'expanded' => false,
                    'videos' => [
                        ['title' => 'Planning dan Setup Project E-Commerce', 'duration' => '18:30', 'watched' => false],
                        ['title' => 'Implementasi Product Listing dan Detail', 'duration' => '32:15', 'watched' => false],
                        ['title' => 'Shopping Cart dan Checkout Flow', 'duration' => '35:40', 'watched' => false],
                        ['title' => 'Deployment ke Production', 'duration' => '24:20', 'watched' => false],
                    ]
                ],
            ];
        @endphp

        @foreach($categories as $index => $category)
            <div class="category-section" data-category="{{ $index }}">
                <button class="w-full flex items-center justify-between p-4 [background:#f5f5f5] hover:[background:#e8e8e8] rounded-xl transition" onclick="toggleCategory({{ $index }})">
                    <div class="text-left">
                        <div class="font-semibold [color:#1f2937] text-sm">{{ $category['name'] }}</div>
                        <div class="text-xs [color:#999]">{{ $category['count'] }} videos</div>
                    </div>
                    <span class="[color:#999] transition-transform category-chevron" id="chevron-{{ $index }}">
                        {{ $category['expanded'] ? '▼' : '▶' }}
                    </span>
                </button>

                <div class="video-list {{ $category['expanded'] ? '' : 'hidden' }}" id="videos-{{ $index }}">
                    @foreach($category['videos'] as $video)
                        <div class="flex items-start gap-3 p-3 my-1 rounded-xl hover:[background:#f5f5f5] cursor-pointer transition {{ isset($video['active']) && $video['active'] ? '[background:#eff6ff] [border:1px_solid_#3b82f6]' : '[border:1px_solid_transparent]' }}">
                            <div class="w-10 h-10 flex-shrink-0 [background:linear-gradient(135deg,{{ isset($video['active']) && $video['active'] ? '#3b82f6,#2563eb' : '#a855f7,#ec4899' }})] rounded-lg flex items-center justify-center text-white">
                                ▶
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="font-semibold text-sm [color:#1f2937] leading-tight mb-1">
                                    {{ $video['title'] }}
                                </div>
                                <div class="text-xs [color:#999]">{{ $video['duration'] }}</div>
                            </div>
                            <input
                                type="checkbox"
                                class="w-5 h-5 flex-shrink-0 mt-2 cursor-pointer [accent-color:#7c3aed]"
                                {{ $video['watched'] ? 'checked' : '' }}
                            >
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</aside>

@push('scripts')
<script>
    function toggleCategory(index) {
        const videoList = document.getElementById(`videos-${index}`);
        const chevron = document.getElementById(`chevron-${index}`);

        videoList.classList.toggle('hidden');
        chevron.textContent = videoList.classList.contains('hidden') ? '▶' : '▼';
    }

    let allExpanded = true;
    function toggleAllCategories() {
        allExpanded = !allExpanded;
        const toggleText = document.getElementById('toggleText');

        document.querySelectorAll('.video-list').forEach((list, index) => {
            const chevron = document.getElementById(`chevron-${index}`);
            if (allExpanded) {
                list.classList.remove('hidden');
                chevron.textContent = '▼';
            } else {
                list.classList.add('hidden');
                chevron.textContent = '▶';
            }
        });

        toggleText.textContent = allExpanded ? 'Tutup Semua' : 'Lihat Semua';
    }
</script>
@endpush
@endsection
