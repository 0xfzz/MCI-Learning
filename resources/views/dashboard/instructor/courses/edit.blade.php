@extends('layouts.dashboard')

@section('title', 'Edit Kursus - MCI Learning')

@section('search-placeholder', 'Cari modul kursus...')

@section('content')
<div class="mb-10">
    <p class="text-sm uppercase tracking-widest text-gray-400 dark:text-gray-500 font-semibold">Instruktur</p>
    <h1 class="text-3xl font-black text-gray-900 dark:text-gray-100">Edit Kursus</h1>
    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Perbarui informasi kursus untuk memastikan siswa mendapatkan detail terbaru.</p>
</div>

<form method="POST" action="{{ route('dashboard.courses.update', $course) }}" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-[2fr_1fr] gap-8">
    @csrf
    @method('PUT')

    <section class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-3xl p-6 space-y-6">
        <div>
            <label for="title" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Judul Kursus</label>
            <input id="title" name="title" type="text" value="{{ old('title', $course->title) }}" required class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-teal-500">
        </div>

        <div>
            <label for="thumbnail" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Thumbnail Kursus</label>
            <input id="thumbnail" name="thumbnail" type="file" accept="image/jpeg,image/png,image/jpg,image/webp" class="hidden" onchange="previewThumbnail(event)">
            <div class="flex items-start gap-4">
                <div id="thumbnail-preview" class="w-32 h-32 rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-700 flex items-center justify-center overflow-hidden bg-gray-50 dark:bg-gray-800">
                    @if($course->thumbnail)
                        <img src="{{ asset('storage/'.$course->thumbnail) }}" class="w-full h-full object-cover" alt="Current thumbnail">
                    @else
                        <i class="fa-solid fa-image text-3xl text-gray-400 dark:text-gray-600"></i>
                    @endif
                </div>
                <div class="flex-1">
                    <button type="button" onclick="document.getElementById('thumbnail').click()" class="px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                        <i class="fa-solid fa-upload mr-2"></i>{{ $course->thumbnail ? 'Ganti Gambar' : 'Pilih Gambar' }}
                    </button>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Format: JPG, PNG, WEBP. Maks 2MB. Rekomendasi 1200x630px</p>
                    @if($course->thumbnail)
                        <p class="text-xs text-teal-600 dark:text-teal-400 mt-1"><i class="fa-solid fa-check-circle mr-1"></i>Thumbnail sudah diupload</p>
                    @endif
                </div>
            </div>
        </div>

        <div>
            <label for="category_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Kategori</label>
            <select id="category_id" name="category_id" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-teal-500">
                <option value="">Pilih kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->category_id }}" @selected(old('category_id', $course->category_id) == $category->category_id)>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="description" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Deskripsi</label>
            <textarea id="description" name="description" rows="6" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-teal-500">{{ old('description', $course->description) }}</textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="level" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Level</label>
                <select id="level" name="level" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-teal-500">
                    <option value="">Pilih level</option>
                    @foreach ($levels as $value => $label)
                        <option value="{{ $value }}" @selected(old('level', $course->level) === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="status" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Status</label>
                <select id="status" name="status" required class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-teal-500">
                    @foreach ($statusOptions as $value => $label)
                        <option value="{{ $value }}" @selected(old('status', $course->status) === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="flex items-center gap-3">
                <input id="is_paid" name="is_paid" type="checkbox" value="1" @checked(old('is_paid', $course->is_paid)) class="w-5 h-5 rounded border-gray-300 text-teal-600 focus:ring-teal-500">
                <label for="is_paid" class="text-sm font-semibold text-gray-700 dark:text-gray-200">Kursus berbayar</label>
            </div>
            <div>
                <label for="price" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Harga (Rp)</label>
                <input id="price" name="price" type="number" min="0" value="{{ old('price', $course->price) }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-teal-500">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="discount_price" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Harga Diskon (opsional)</label>
                <input id="discount_price" name="discount_price" type="number" min="0" value="{{ old('discount_price', $course->discount_price) }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-teal-500">
            </div>
            <div>
                <label for="whatsapp_group" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Link Grup WhatsApp</label>
                <input id="whatsapp_group" name="whatsapp_group" type="url" value="{{ old('whatsapp_group', $course->whatsapp_group) }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-teal-500">
            </div>
        </div>

        <div>
            <label for="source_code_link" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Link Source Code</label>
            <input id="source_code_link" name="source_code_link" type="url" value="{{ old('source_code_link', $course->source_code_link) }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-teal-500">
        </div>
    </section>

    <aside class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-3xl p-6 h-fit space-y-6">
        <div>
            <h2 class="text-base font-semibold text-gray-900 dark:text-gray-100 mb-2">Status Kursus</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Terakhir diperbarui: {{ optional($course->created_at)?->diffForHumans() ?? '-' }}</p>
        </div>
        <div class="border-t border-dashed border-gray-200 dark:border-gray-800 pt-4">
            <button type="submit" class="w-full px-4 py-3 rounded-xl bg-[#025f5a] text-white text-sm font-semibold shadow-lg shadow-emerald-500/20 hover:bg-[#014440] transition">Simpan Perubahan</button>
            <a href="{{ route('dashboard.courses.index') }}" class="mt-3 inline-flex justify-center w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 text-sm text-gray-600 dark:text-gray-300 hover:border-teal-400/60 transition">Batal</a>
        </div>
    </aside>
</form>

@push('scripts')
<script>
function previewThumbnail(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('thumbnail-preview');

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = '<img src="' + e.target.result + '" class="w-full h-full object-cover">';
        };
        reader.readAsDataURL(file);
    }
}
</script>
@endpush
@endsection
