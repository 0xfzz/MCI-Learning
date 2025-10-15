@extends('layouts.dashboard')

@section('title', 'COURSUE - Courses')

@section('search-placeholder', 'Cari course...')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-black text-gray-900 mb-2">Explore Courses</h1>
    <p class="text-gray-500">Discover amazing courses to boost your skills</p>
</div>

<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
    @php
        $courses = [
            ['id' => 1, 'bg' => 'from-blue-500 to-blue-400', 'icon' => '⚛️', 'title' => 'React JS Complete Guide', 'category' => 'FRONTEND', 'lessons' => 24, 'duration' => '6h 45m'],
            ['id' => 2, 'bg' => 'from-green-500 to-green-400', 'icon' => '💚', 'title' => 'Vue JS Mastery', 'category' => 'FRONTEND', 'lessons' => 18, 'duration' => '5h 20m'],
            ['id' => 3, 'bg' => 'from-red-500 to-red-400', 'icon' => '🅰️', 'title' => 'Angular Deep Dive', 'category' => 'FRONTEND', 'lessons' => 20, 'duration' => '7h 15m'],
            ['id' => 4, 'bg' => 'from-purple-500 to-purple-400', 'icon' => '⚡', 'title' => 'Node JS Backend', 'category' => 'BACKEND', 'lessons' => 30, 'duration' => '9h 30m'],
            ['id' => 5, 'bg' => 'from-yellow-500 to-yellow-400', 'icon' => '🎨', 'title' => 'UI/UX Design Fundamentals', 'category' => 'DESIGN', 'lessons' => 15, 'duration' => '4h 45m'],
            ['id' => 6, 'bg' => 'from-pink-500 to-pink-400', 'icon' => '📱', 'title' => 'React Native Mobile Apps', 'category' => 'MOBILE', 'lessons' => 22, 'duration' => '8h 10m'],
        ];
    @endphp

    @foreach($courses as $course)
        <a href="{{ route('courses.show', $course['id']) }}" class="bg-white border border-gray-200 rounded-2xl overflow-hidden hover:border-purple-500 hover:-translate-y-2 hover:shadow-2xl transition-all cursor-pointer">
            <div class="h-44 bg-gradient-to-br {{ $course['bg'] }} flex items-center justify-center text-6xl relative">
                <span class="opacity-90">{{ $course['icon'] }}</span>
            </div>
            <div class="p-5">
                <span class="inline-block px-3 py-1 bg-purple-50 text-purple-600 text-xs font-bold uppercase rounded-md mb-3">
                    {{ $course['category'] }}
                </span>
                <h3 class="font-bold text-gray-900 mb-4 leading-snug text-lg">{{ $course['title'] }}</h3>
                <div class="flex items-center justify-between pt-4 border-t border-gray-100 text-sm text-gray-500">
                    <span>📚 {{ $course['lessons'] }} lessons</span>
                    <span>⏱️ {{ $course['duration'] }}</span>
                </div>
            </div>
        </a>
    @endforeach
</div>
@endsection
