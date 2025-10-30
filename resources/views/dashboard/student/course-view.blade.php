@extends('layouts.dashboard')

@section('title', $course->title . ' - MCI Learning')

@section('search-placeholder', 'Cari dalam kursus...')

@section('show-right-sidebar', true)

@section('content')
<!-- Breadcrumb -->
<nav class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl px-4 py-3 mb-6 flex items-center gap-2 text-sm">
    <a href="{{ route('dashboard.index') }}" class="text-gray-500 hover:text-[#025f5a] dark:text-gray-400 dark:hover:text-teal-300 transition">
        <i class="fa-solid fa-home"></i> Dashboard
    </a>
    <span class="text-gray-300 dark:text-gray-600">›</span>
    <a href="{{ route('dashboard.my-courses.index') }}" class="text-gray-500 hover:text-[#025f5a] dark:text-gray-400 dark:hover:text-teal-300 transition">
        Kursus Saya
    </a>
    <span class="text-gray-300 dark:text-gray-600">›</span>
    <span class="text-[#025f5a] dark:text-teal-300 font-semibold">{{ \Illuminate\Support\Str::limit($course->title, 30) }}</span>
</nav>

<!-- Progress Bar -->
<div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl p-5 mb-6">
    <div class="flex items-center justify-between mb-3">
        <div>
            <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300">Progress Belajar</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $completedLessons }} dari {{ $totalLessons }} video selesai</p>
        </div>
        <div class="text-2xl font-bold text-[#025f5a] dark:text-teal-300">{{ $progressPercentage }}%</div>
    </div>
    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3 overflow-hidden">
        <div class="bg-gradient-to-r from-[#025f5a] to-teal-500 h-full rounded-full transition-all duration-500" style="width: {{ $progressPercentage }}%"></div>
    </div>
</div>

@if(session('status'))
    <div class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 rounded-2xl px-4 py-3 mb-6">
        <i class="fa-solid fa-circle-check mr-2"></i>{{ session('status') }}
    </div>
@endif

@if($errors->any())
    <div class="bg-rose-50 dark:bg-rose-900/20 border border-rose-200 dark:border-rose-800 text-rose-600 dark:text-rose-300 rounded-2xl px-4 py-3 mb-6">
        <ul class="list-disc list-inside text-sm space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Video Player Card -->
@if($currentLesson)
<div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl overflow-hidden mb-6">
    <div class="p-5">
        <div class="relative w-full pb-[56.25%] rounded-xl overflow-hidden bg-black shadow-2xl">
            @if($currentLesson->youtube_link)
                @php
                    $youtubeId = '';
                    if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/', $currentLesson->youtube_link, $match)) {
                        $youtubeId = $match[1];
                    }
                @endphp
                @if($youtubeId)
                    <iframe
                        class="absolute top-0 left-0 w-full h-full"
                        src="https://www.youtube.com/embed/{{ $youtubeId }}"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                    </iframe>
                @else
                    <div class="absolute inset-0 flex items-center justify-center text-white">
                        <div class="text-center">
                            <i class="fa-solid fa-video-slash text-4xl mb-3 opacity-50"></i>
                            <p>Link YouTube tidak valid</p>
                        </div>
                    </div>
                @endif
            @else
                <div class="absolute inset-0 flex items-center justify-center text-white">
                    <div class="text-center">
                        <i class="fa-solid fa-video text-4xl mb-3 opacity-50"></i>
                        <p>Video belum tersedia</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <div class="px-6 pb-6 border-t border-gray-100 dark:border-gray-800">
        <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-gray-100 mt-6 mb-3">{{ $currentLesson->title }}</h1>
        <div class="flex items-center gap-5 text-sm text-gray-500 dark:text-gray-400">
            @if($currentLesson->duration)
                <span class="flex items-center gap-2">
                    <i class="fa-solid fa-clock text-[#025f5a]"></i>
                    <span>{{ $currentLesson->duration }}</span>
                </span>
            @endif
            <span class="flex items-center gap-2">
                <i class="fa-solid fa-book-open text-[#025f5a]"></i>
                <span>{{ $course->category->name ?? 'Umum' }}</span>
            </span>
            @if($currentLesson->is_free)
                <span class="px-2 py-1 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 rounded-full text-xs font-semibold">
                    Gratis
                </span>
            @endif
        </div>
        <div class="mt-5 flex items-center gap-3">
            <label class="flex items-center gap-3 cursor-pointer">
                <input
                    type="checkbox"
                    class="w-5 h-5 rounded border-gray-300 text-[#025f5a] focus:ring-[#025f5a] cursor-pointer"
                    {{ $currentLesson->isCompletedBy(auth()->id()) ? 'checked' : '' }}
                    onchange="toggleLessonComplete({{ $currentLesson->lesson_id }}, this.checked)"
                >
                <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Tandai sebagai selesai</span>
            </label>
        </div>
    </div>
</div>
@else
<div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl p-12 text-center mb-6">
    <div class="w-16 h-16 mx-auto rounded-full bg-gray-100 dark:bg-gray-800 text-gray-400 flex items-center justify-center text-2xl mb-5">
        <i class="fa-solid fa-video"></i>
    </div>
    <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-3">Belum ada video tersedia</h2>
    <p class="text-sm text-gray-500 dark:text-gray-400">Kursus ini belum memiliki materi video. Silakan cek kembali nanti.</p>
</div>
@endif

<!-- Additional Resources -->
<div class="grid lg:grid-cols-2 gap-6 mb-6">
    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl p-6">
        <div class="flex items-start justify-between gap-3 mb-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Bagikan Pengalaman Belajar</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">Admin akan meninjau ulasan sebelum ditampilkan.</p>
            </div>
            <div class="text-right">
                <div class="text-3xl font-bold text-[#025f5a] dark:text-teal-300">{{ number_format($averageRating, 1) }}</div>
                <span class="text-xs text-gray-500 dark:text-gray-400">Rata-rata rating</span>
            </div>
        </div>

        @if($studentReview && $studentReview->status === 'approved')
            <div class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 text-sm rounded-xl px-4 py-3">
                <i class="fa-solid fa-circle-check mr-2"></i>Ulasan kamu sudah disetujui dan tampil sebagai testimoni kursus ini.
            </div>
        @else
            @if($studentReview && $studentReview->status === 'pending')
                <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 text-amber-700 dark:text-amber-300 text-sm rounded-xl px-4 py-3 mb-4">
                    <i class="fa-solid fa-hourglass-half mr-2"></i>Ulasan kamu sedang menunggu persetujuan admin. Kamu masih bisa memperbarui isinya sebelum disetujui.
                </div>
            @elseif($studentReview && $studentReview->status === 'rejected')
                <div class="bg-rose-50 dark:bg-rose-900/20 border border-rose-200 dark:border-rose-800 text-rose-600 dark:text-rose-300 text-sm rounded-xl px-4 py-3 mb-4">
                    <i class="fa-solid fa-circle-exclamation mr-2"></i>Ulasan sebelumnya ditolak. Perbarui komentar agar bisa ditinjau ulang.
                </div>
            @endif

            <form action="{{ route('dashboard.my-courses.reviews.store', $course->course_id) }}" method="POST" class="space-y-4">
                @csrf
                @php
                    $selectedRating = (int) old('rating', $studentReview->rating ?? 0);
                @endphp
                <div>
                    <label for="rating" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Penilaian</label>
                    <div class="flex items-center gap-3">
                        <select id="rating" name="rating" class="w-40 rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm focus:border-[#025f5a] focus:ring-[#025f5a]">
                            <option value="">Pilih rating</option>
                            @for($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}" {{ $selectedRating === $i ? 'selected' : '' }}>
                                    {{ $i }} Bintang
                                </option>
                            @endfor
                        </select>
                        <div class="flex items-center gap-1" data-rating-preview>
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fa-solid fa-star text-lg transition-colors rating-star {{ $selectedRating >= $i ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-700' }}" data-rating-star></i>
                            @endfor
                        </div>
                    </div>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-2">1 = kurang puas, 5 = sangat merekomendasikan.</p>
                </div>
                <div>
                    <label for="comment" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Ceritakan pengalamanmu</label>
                    <textarea id="comment" name="comment" rows="5" class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm focus:border-[#025f5a] focus:ring-[#025f5a]" placeholder="Apa yang kamu suka dari kursus ini?">{{ old('comment', $studentReview->comment ?? '') }}</textarea>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-2">Komentar minimal 20 karakter agar admin dapat menilainya.</p>
                </div>
                <button type="submit" class="px-5 py-3 bg-[#025f5a] text-white text-sm font-semibold rounded-xl hover:bg-[#024842] transition shadow-lg shadow-[#025f5a]/20">
                    Kirim Ulasan
                </button>
            </form>
        @endif
    </div>

    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl p-6">
        <div class="flex items-start justify-between gap-3 mb-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Testimoni Mahasiswa</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $course->reviews_count }} ulasan disetujui</p>
            </div>
            <div class="text-right">
                <div class="text-sm text-gray-400 dark:text-gray-500">Rating rata-rata</div>
                <div class="text-xl font-bold text-[#025f5a] dark:text-teal-300">{{ number_format($averageRating, 1) }}/5</div>
            </div>
        </div>

        <div class="space-y-4 max-h-96 overflow-y-auto pr-1">
            @forelse($recentApprovedReviews as $review)
                <div class="border border-gray-100 dark:border-gray-800 rounded-xl p-4 bg-gray-50/80 dark:bg-gray-800/60">
                    <div class="flex items-center justify-between mb-3">
                        <div>
                            <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $review->user->name ?? $review->user->username ?? 'Mahasiswa' }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ optional($review->approved_at)->format('d M Y') }}</div>
                        </div>
                        <div class="flex items-center gap-1">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fa-solid fa-star text-xs {{ $review->rating >= $i ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}"></i>
                            @endfor
                        </div>
                    </div>
                    <p class="text-sm text-gray-700 dark:text-gray-200 whitespace-pre-line">{{ $review->comment }}</p>
                </div>
            @empty
                <div class="border border-dashed border-gray-200 dark:border-gray-700 rounded-xl p-6 text-center text-sm text-gray-500 dark:text-gray-400">
                    Belum ada testimoni yang disetujui untuk kursus ini.
                </div>
            @endforelse
        </div>
    </div>
</div>

<div class="grid md:grid-cols-2 gap-6 mb-6">
    <!-- Forum Discussion Card -->
    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl p-6 hover:border-[#025f5a] hover:shadow-lg transition-all">
        <div class="flex items-center gap-4 mb-5">
            <div class="w-12 h-12 bg-gradient-to-br from-purple-100 to-purple-200 dark:from-purple-900/30 dark:to-purple-800/30 rounded-xl flex items-center justify-center text-2xl">
                💬
            </div>
            <div class="flex-1">
                <h3 class="font-bold text-gray-900 dark:text-gray-100 text-lg">Forum Diskusi</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">Tanya jawab dengan instruktur</p>
            </div>
        </div>
        <button class="px-6 py-3 bg-purple-600 text-white rounded-xl font-semibold hover:bg-purple-700 transition hover:-translate-y-1 shadow-lg hover:shadow-purple-600/30 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
            Segera Hadir
        </button>
    </div>

    <!-- WhatsApp Group Card -->
    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl p-6 hover:border-emerald-500 hover:shadow-lg transition-all">
        <div class="flex items-center gap-4 mb-5">
            <div class="w-12 h-12 bg-gradient-to-br from-emerald-100 to-emerald-200 dark:from-emerald-900/30 dark:to-emerald-800/30 rounded-xl flex items-center justify-center text-2xl">
                📱
            </div>
            <div class="flex-1">
                <h3 class="font-bold text-gray-900 dark:text-gray-100 text-lg">Grup WhatsApp</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">Join komunitas belajar</p>
            </div>
        </div>
        <button class="px-6 py-3 bg-emerald-600 text-white rounded-xl font-semibold hover:bg-emerald-700 transition hover:-translate-y-1 shadow-lg hover:shadow-emerald-600/30 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
            Segera Hadir
        </button>
    </div>
</div>
@endsection

@section('right-sidebar')
<aside class="bg-white dark:bg-gray-900 border-l border-gray-200 dark:border-gray-800 overflow-y-auto">
    <div class="p-6">
        <!-- Playlist Header -->
        <div class="pb-5 border-b border-gray-200 dark:border-gray-800 mb-5">
            <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-2">Daftar Video</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">{{ $totalLessons }} video</p>
            @if($sections->count() > 0)
                <button class="text-[#025f5a] dark:text-teal-300 text-sm font-semibold underline hover:text-[#024842] dark:hover:text-teal-400 transition" onclick="toggleAllCategories()">
                    <span id="toggleText">Tutup Semua</span>
                </button>
            @endif
        </div>

        <!-- Playlist Content -->
        <div class="space-y-2">
            @foreach($sections as $index => $section)
                <div class="category-section" data-category="{{ $index }}">
                    <button class="w-full flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition" onclick="toggleCategory({{ $index }})">
                        <div class="text-left flex-1">
                            <div class="font-semibold text-gray-900 dark:text-gray-100 text-sm">{{ $section->title }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ $section->children->count() }} video</div>
                        </div>
                        <span class="text-gray-500 dark:text-gray-400 transition-transform category-chevron text-xs" id="chevron-{{ $index }}">
                            <i class="fa-solid fa-chevron-down"></i>
                        </span>
                    </button>

                    <div class="video-list mt-1" id="videos-{{ $index }}">
                        @foreach($section->children as $lesson)
                            @php
                                $isCompleted = $lesson->isCompletedBy(auth()->id());
                                $isActive = $currentLesson && $currentLesson->lesson_id === $lesson->lesson_id;
                            @endphp
                            <a href="{{ route('dashboard.my-courses.learn', ['course' => $course->course_id, 'lesson' => $lesson->lesson_id]) }}" class="flex items-center gap-3 p-3 my-1 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800 cursor-pointer transition group {{ $isActive ? 'bg-[#025f5a]/10 dark:bg-teal-900/20 border border-[#025f5a]/30' : 'border border-transparent' }}">
                                <div class="w-8 h-8 flex-shrink-0 bg-gradient-to-br {{ $isActive ? 'from-[#025f5a] to-teal-600' : 'from-gray-400 to-gray-500' }} rounded-lg flex items-center justify-center text-white">
                                    <i class="fa-solid fa-play text-[10px]"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="font-medium text-xs text-gray-900 dark:text-gray-100 leading-tight line-clamp-2 {{ $isActive ? 'text-[#025f5a] dark:text-teal-300' : '' }}">
                                        {{ $lesson->title }}
                                    </div>
                                    @if($lesson->duration)
                                        <div class="text-[10px] text-gray-500 dark:text-gray-400 mt-1">{{ $lesson->duration }}</div>
                                    @endif
                                </div>
                                <div class="flex-shrink-0">
                                    @if($isCompleted)
                                        <i class="fa-solid fa-check-circle text-emerald-500 text-sm"></i>
                                    @else
                                        <i class="fa-regular fa-circle text-gray-300 dark:text-gray-600 text-sm"></i>
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endforeach

            @if($standaloneLessons->count() > 0)
                <div class="pt-2">
                    @foreach($standaloneLessons as $lesson)
                        @php
                            $isCompleted = $lesson->isCompletedBy(auth()->id());
                            $isActive = $currentLesson && $currentLesson->lesson_id === $lesson->lesson_id;
                        @endphp
                        <a href="{{ route('dashboard.my-courses.learn', ['course' => $course->course_id, 'lesson' => $lesson->lesson_id]) }}" class="flex items-center gap-3 p-3 my-1 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800 cursor-pointer transition group {{ $isActive ? 'bg-[#025f5a]/10 dark:bg-teal-900/20 border border-[#025f5a]/30' : 'border border-transparent' }}">
                            <div class="w-8 h-8 flex-shrink-0 bg-gradient-to-br {{ $isActive ? 'from-[#025f5a] to-teal-600' : 'from-gray-400 to-gray-500' }} rounded-lg flex items-center justify-center text-white">
                                <i class="fa-solid fa-play text-[10px]"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="font-medium text-xs text-gray-900 dark:text-gray-100 leading-tight line-clamp-2 {{ $isActive ? 'text-[#025f5a] dark:text-teal-300' : '' }}">
                                    {{ $lesson->title }}
                                </div>
                                @if($lesson->duration)
                                    <div class="text-[10px] text-gray-500 dark:text-gray-400 mt-1">{{ $lesson->duration }}</div>
                                @endif
                            </div>
                            <div class="flex-shrink-0">
                                @if($isCompleted)
                                    <i class="fa-solid fa-check-circle text-emerald-500 text-sm"></i>
                                @else
                                    <i class="fa-regular fa-circle text-gray-300 dark:text-gray-600 text-sm"></i>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif

            @if($sections->count() === 0 && $standaloneLessons->count() === 0)
                <div class="text-center py-8">
                    <i class="fa-solid fa-video text-3xl text-gray-300 dark:text-gray-600 mb-3"></i>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Belum ada video tersedia</p>
                </div>
            @endif
        </div>
    </div>
</aside>

@push('scripts')
<script>
    function toggleCategory(index) {
        const videoList = document.getElementById(`videos-${index}`);
        const chevron = document.getElementById(`chevron-${index}`);
        const icon = chevron.querySelector('i');

        videoList.classList.toggle('hidden');

        if (videoList.classList.contains('hidden')) {
            icon.classList.remove('fa-chevron-down');
            icon.classList.add('fa-chevron-right');
        } else {
            icon.classList.remove('fa-chevron-right');
            icon.classList.add('fa-chevron-down');
        }
    }

    let allExpanded = true;
    function toggleAllCategories() {
        allExpanded = !allExpanded;
        const toggleText = document.getElementById('toggleText');

        document.querySelectorAll('.video-list').forEach((list, index) => {
            const chevron = document.getElementById(`chevron-${index}`);
            const icon = chevron?.querySelector('i');

            if (allExpanded) {
                list.classList.remove('hidden');
                if (icon) {
                    icon.classList.remove('fa-chevron-right');
                    icon.classList.add('fa-chevron-down');
                }
            } else {
                list.classList.add('hidden');
                if (icon) {
                    icon.classList.remove('fa-chevron-down');
                    icon.classList.add('fa-chevron-right');
                }
            }
        });

        toggleText.textContent = allExpanded ? 'Tutup Semua' : 'Lihat Semua';
    }

    function toggleLessonComplete(lessonId, isChecked) {
        fetch(`{{ route('dashboard.my-courses.learn', $course->course_id) }}/lesson/${lessonId}/complete`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                completed: isChecked
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update progress bar
                const progressBar = document.querySelector('.bg-gradient-to-r');
                if (progressBar) {
                    progressBar.style.width = `${data.percentage}%`;
                }

                // Update progress text
                const progressText = document.querySelector('.text-xs.text-gray-500');
                if (progressText) {
                    progressText.textContent = `${data.completed} dari ${data.total} video selesai`;
                }

                const percentageText = document.querySelector('.text-2xl.font-bold');
                if (percentageText) {
                    percentageText.textContent = `${data.percentage}%`;
                }

                // Update checkbox in sidebar
                const sidebarCheckbox = document.querySelector(`.video-list input[type="checkbox"][onclick*="${lessonId}"]`);
                if (sidebarCheckbox) {
                    sidebarCheckbox.checked = isChecked;
                }

                // Show success message
                if (data.percentage === 100) {
                    alert('🎉 Selamat! Anda telah menyelesaikan semua video dalam kursus ini!');
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menyimpan progress');
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        const ratingSelect = document.getElementById('rating');
        const ratingStars = document.querySelectorAll('[data-rating-star]');

        if (ratingSelect && ratingStars.length) {
            const syncStars = (value) => {
                ratingStars.forEach((star, index) => {
                    const active = index < value;
                    star.classList.toggle('text-yellow-400', active);
                    star.classList.toggle('text-gray-300', !active);
                    star.classList.toggle('dark:text-gray-700', !active);
                });
            };

            syncStars(parseInt(ratingSelect.value || '0', 10));

            ratingSelect.addEventListener('change', (event) => {
                syncStars(parseInt(event.target.value || '0', 10));
            });
        }
    });
</script>
@endpush
@endsection
