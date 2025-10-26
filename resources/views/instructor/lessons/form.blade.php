@php
    $isSection = old('is_section', $lesson->is_section ?? request('is_section', true));
@endphp

<div class="space-y-6">
    <div>
        <label for="title" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Judul</label>
        <input id="title" name="title" type="text" value="{{ old('title', $lesson->title ?? '') }}" required class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-teal-500">
    </div>

    <div class="flex items-center gap-3">
        <input id="is_section" name="is_section" type="checkbox" value="1" @checked($isSection) class="w-5 h-5 rounded border-gray-300 text-teal-600 focus:ring-teal-500">
        <label for="is_section" class="text-sm font-semibold text-gray-700 dark:text-gray-200">Ini adalah bagian (folder materi)</label>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6" data-lesson-video-fields>
        <div>
            <label for="youtube_link" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Link YouTube</label>
            <input id="youtube_link" name="youtube_link" type="url" value="{{ old('youtube_link', $lesson->youtube_link ?? '') }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-teal-500">
            <p class="mt-1 text-xs text-gray-400">Kosongkan jika ini adalah bagian.</p>
        </div>
        <div>
            <label for="duration" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Durasi</label>
            <input id="duration" name="duration" type="text" value="{{ old('duration', $lesson->duration ?? '') }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-teal-500">
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6" data-lesson-order-free>
        <div>
            <label for="order_number" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Urutan</label>
            <input id="order_number" name="order_number" type="number" min="1" value="{{ old('order_number', $lesson->order_number ?? ($nextOrder ?? 1)) }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-teal-500">
        </div>
        <div class="flex items-center gap-3">
            <input id="is_free" name="is_free" type="checkbox" value="1" @checked(old('is_free', $lesson->is_free ?? false)) class="w-5 h-5 rounded border-gray-300 text-teal-600 focus:ring-teal-500">
            <label for="is_free" class="text-sm font-semibold text-gray-700 dark:text-gray-200">Tandai sebagai materi gratis</label>
        </div>
    </div>

    <div>
        <label for="parent_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Bagian Induk</label>
        <select id="parent_id" name="parent_id" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-teal-500">
            <option value="">Tidak ada (bagian utama)</option>
            @foreach ($sections as $section)
                <option value="{{ $section->lesson_id }}" @selected(old('parent_id', $lesson->parent_id ?? request('parent_id')) == $section->lesson_id)>{{ $section->title }}</option>
            @endforeach
        </select>
    </div>
</div>
