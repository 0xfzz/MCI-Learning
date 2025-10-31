@php
    $selectedStatus = old('status', $blog->status ?? 'draft');
@endphp

<form method="POST" action="{{ $action }}" class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-3xl p-8 shadow-[0_18px_40px_rgba(2,95,90,0.08)] space-y-6">
    @csrf
    @if (!in_array($method, ['POST', 'GET']))
        @method($method)
    @endif

    <div>
        <label for="title" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Judul Artikel</label>
        <input
            type="text"
            id="title"
            name="title"
            value="{{ old('title', $blog->title ?? '') }}"
            class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-teal-500/60 focus:border-transparent transition"
            placeholder="Masukkan judul artikel"
            required
        >
        @error('title')
            <p class="mt-2 text-sm text-rose-500">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="status" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Status</label>
            <select
                id="status"
                name="status"
                class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-teal-500/60 focus:border-transparent transition"
            >
                <option value="draft" @selected($selectedStatus === 'draft')>Draft</option>
                <option value="published" @selected($selectedStatus === 'published')>Published</option>
            </select>
            @error('status')
                <p class="mt-2 text-sm text-rose-500">{{ $message }}</p>
            @enderror
        </div>
        <div class="flex flex-col justify-end text-sm text-gray-500 dark:text-gray-400">
            <p>Gunakan status <span class="font-semibold text-teal-600 dark:text-teal-300">Published</span> untuk menayangkan artikel ke publik.</p>
        </div>
    </div>

    <div>
        <label for="markdown-editor" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Konten Markdown</label>
        <textarea
            id="markdown-editor"
            name="content"
            rows="12"
            data-blog-id="{{ $blog->id ?? 'new' }}">{{ old('content', $blog->content ?? '') }}</textarea>
        @error('content')
            <p class="mt-2 text-sm text-rose-500">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center justify-end gap-3">
        <a href="{{ route('dashboard.blogs.index') }}" class="px-5 py-3 rounded-xl border border-gray-300 dark:border-gray-700 text-gray-600 dark:text-gray-300 hover:border-teal-500/50 hover:text-teal-500 transition font-semibold">
            Batal
        </a>
        <button type="submit" class="px-6 py-3 rounded-xl [background:linear-gradient(135deg,#06b6d4,#025f5a)] text-white font-semibold shadow-[0_12px_30px_rgba(2,95,90,0.25)] hover:-translate-y-1 transition">
            {{ $submitLabel ?? 'Simpan' }}
        </button>
    </div>
</form>

@once
    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/easymde/dist/easymde.min.css">
    @endpush

    @push('scripts')
        <script src="https://unpkg.com/easymde/dist/easymde.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const textarea = document.getElementById('markdown-editor');
                if (!textarea) {
                    return;
                }

                if (!textarea.dataset.easymdeInitialized) {
                    const blogId = textarea.dataset.blogId || 'new';
                    const editor = new EasyMDE({
                        element: textarea,
                        spellChecker: false,
                        initialValue: textarea.value,
                        autosave: {
                            enabled: true,
                            uniqueId: `mci-admin-blog-editor-${blogId}`,
                            delay: 1000,
                        },
                        placeholder: 'Tulis konten artikel dalam format Markdown...'
                    });

                    editor.codemirror.on('change', () => {
                        textarea.value = editor.value();
                    });
                    textarea.dataset.easymdeInitialized = 'true';
                }
            });
        </script>
    @endpush
@endonce
