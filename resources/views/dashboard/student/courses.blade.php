@extends('layouts.dashboard')

@section('title', 'Jelajahi Kursus - MCI Learning')
@section('search-placeholder', 'Cari kursus yang ingin dipelajari...')

@section('content')
@php
    $paginationLinks = $courses instanceof \Illuminate\Pagination\AbstractPaginator
        ? $courses->links()
        : null;
@endphp

<div class="space-y-10">
    <div class="flex flex-col xl:flex-row xl:items-end xl:justify-between gap-6">
        <div>
            <p class="text-sm uppercase tracking-[0.25em] text-gray-500 dark:text-gray-500 font-semibold">Jelajahi & Pelajari</p>
            <h1 class="text-3xl lg:text-4xl font-black text-gray-900 dark:text-gray-100 mt-3">Katalog Kursus</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-4 max-w-2xl">Temukan kursus yang sesuai dengan minat Anda. Daftar sekarang dan mulai perjalanan belajar Anda!</p>
        </div>
        <form method="GET" class="w-full xl:max-w-md">
            <div class="relative">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
                <input
                    type="search"
                    name="q"
                    value="{{ $filters['search'] }}"
                    placeholder="Cari judul atau topik kursus..."
                    class="w-full pl-12 pr-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-[#025f5a]"
                >
            </div>
        </form>
    </div>

    <div class="grid lg:grid-cols-[260px_1fr] gap-8">
        <aside class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-3xl p-6 h-fit sticky top-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-6">Filter</h2>

            <div class="mb-6">
                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Tipe Kursus</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach ($typeOptions as $typeKey => $typeLabel)
                        <a
                            href="{{ route('dashboard.my-courses.index', array_filter(['q' => $filters['search'], 'category' => $filters['category'], 'level' => $filters['level'], 'type' => $typeKey === 'all' ? null : $typeKey], fn ($value) => $value !== null && $value !== '')) }}"
                            class="px-3 py-1.5 rounded-full text-xs font-semibold border transition {{ ($filters['type'] ?? 'all') === $typeKey ? 'text-white bg-[#025f5a] border-[#025f5a]' : 'text-gray-500 border-gray-200 hover:border-[#025f5a] dark:text-gray-400 dark:border-gray-700' }}"
                        >{{ $typeLabel }}</a>
                    @endforeach
                </div>
            </div>

            <div class="mb-6">
                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Kategori</h3>
                <div class="flex flex-wrap gap-2">
                    <a
                        href="{{ route('dashboard.my-courses.index', array_filter(['q' => $filters['search'], 'level' => $filters['level'], 'type' => $filters['type']], fn ($value) => $value !== null && $value !== '')) }}"
                        class="px-3 py-1.5 rounded-full text-xs font-semibold border transition {{ $filters['category'] ? 'text-gray-500 border-gray-200 dark:text-gray-400 dark:border-gray-700' : 'text-white bg-[#025f5a] border-[#025f5a]' }}"
                    >Semua</a>
                    @foreach ($categories as $category)
                        <a
                            href="{{ route('dashboard.my-courses.index', array_filter(['q' => $filters['search'], 'category' => $category->slug, 'level' => $filters['level'], 'type' => $filters['type']], fn ($value) => $value !== null && $value !== '')) }}"
                            class="px-3 py-1.5 rounded-full text-xs font-semibold border transition {{ $filters['category'] === $category->slug ? 'text-white bg-[#025f5a] border-[#025f5a]' : 'text-gray-500 border-gray-200 hover:border-[#025f5a] dark:text-gray-400 dark:border-gray-700' }}"
                        >{{ $category->name }}</a>
                    @endforeach
                </div>
            </div>

            <div>
                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Level</h3>
                <div class="flex flex-wrap gap-2">
                    <a
                        href="{{ route('dashboard.my-courses.index', array_filter(['q' => $filters['search'], 'category' => $filters['category'], 'type' => $filters['type']], fn ($value) => $value !== null && $value !== '')) }}"
                        class="px-3 py-1.5 rounded-full text-xs font-semibold border transition {{ $filters['level'] ? 'text-gray-500 border-gray-200 dark:text-gray-400 dark:border-gray-700' : 'text-white bg-[#025f5a] border-[#025f5a]' }}"
                    >Semua</a>
                    @foreach ($levelOptions as $levelKey => $levelLabel)
                        <a
                            href="{{ route('dashboard.my-courses.index', array_filter(['q' => $filters['search'], 'category' => $filters['category'], 'level' => $levelKey, 'type' => $filters['type']], fn ($value) => $value !== null && $value !== '')) }}"
                            class="px-3 py-1.5 rounded-full text-xs font-semibold border transition {{ $filters['level'] === $levelKey ? 'text-white bg-[#025f5a] border-[#025f5a]' : 'text-gray-500 border-gray-200 hover:border-[#025f5a] dark:text-gray-400 dark:border-gray-700' }}"
                        >{{ $levelLabel }}</a>
                    @endforeach
                </div>
            </div>
        </aside>

        <section>
            @if (count($courses) === 0)
                <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-3xl p-12 text-center">
                    <div class="w-16 h-16 mx-auto rounded-full bg-[#025f5a]/10 text-[#025f5a] flex items-center justify-center text-2xl mb-5">
                        <i class="fa-solid fa-search"></i>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-3">Kursus tidak ditemukan</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Coba ubah kata kunci pencarian atau pilih filter yang berbeda.</p>
                </div>
            @else
                <div class="grid sm:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach ($courses as $course)
                        <div class="group bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-3xl overflow-hidden hover:border-[#025f5a] hover:shadow-2xl hover:-translate-y-1 transition">
                            <div class="relative h-48">
                                @if ($course->thumbnail)
                                    <img src="{{ asset('storage/'.$course->thumbnail) }}" alt="{{ $course->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-[#025f5a] to-teal-500 flex items-center justify-center text-white text-5xl font-black">
                                        {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($course->title, 0, 1)) }}
                                    </div>
                                @endif
                                @if ($course->is_enrolled)
                                    <span class="absolute top-4 left-4 px-3 py-1 text-xs font-semibold rounded-full bg-emerald-500 text-white">
                                        <i class="fa-solid fa-check mr-1"></i>Terdaftar
                                    </span>
                                @elseif ($course->has_pending_payment)
                                    <span class="absolute top-4 left-4 px-3 py-1 text-xs font-semibold rounded-full bg-amber-500 text-white">
                                        <i class="fa-solid fa-clock mr-1"></i>Pending
                                    </span>
                                @elseif ($course->is_paid)
                                    <span class="absolute top-4 left-4 px-3 py-1 text-xs font-semibold rounded-full bg-white/90 text-[#025f5a]">Premium</span>
                                @else
                                    <span class="absolute top-4 left-4 px-3 py-1 text-xs font-semibold rounded-full bg-white/90 text-emerald-600">Gratis</span>
                                @endif
                            </div>
                            <div class="p-6">
                                <div class="flex items-center gap-2 text-xs uppercase tracking-wider text-gray-400 mb-3">
                                    <span>{{ $course->category->name ?? 'Tanpa Kategori' }}</span>
                                    @if ($course->level)
                                        <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                        <span>{{ $levelOptions[$course->level] ?? ucfirst($course->level) }}</span>
                                    @endif
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 group-hover:text-[#025f5a] transition">{{ $course->title }}</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-3 leading-relaxed">{{ \Illuminate\Support\Str::limit($course->description, 110) }}</p>

                                <div class="mt-6 flex items-center justify-between text-sm text-gray-500 dark:text-gray-400">
                                    <span><i class="fa-solid fa-layer-group mr-2 text-[#025f5a]"></i>{{ $course->lessons_count ?? 0 }} modul</span>
                                    <span><i class="fa-solid fa-users mr-2 text-[#025f5a]"></i>{{ $course->students_count ?? 0 }} siswa</span>
                                </div>

                                <div class="mt-5 flex items-center justify-between">
                                    <div class="text-lg font-bold text-[#025f5a] dark:text-teal-300">
                                        {{ $course->is_paid ? 'Rp '.number_format($course->getEffectivePrice(), 0, ',', '.') : 'Gratis' }}
                                    </div>
                                    @if ($course->is_enrolled)
                                        <a href="{{ route('dashboard.my-courses.learn', $course->course_id) }}" class="text-xs font-semibold px-4 py-2 rounded-xl bg-[#025f5a] text-white hover:bg-[#024842] transition">
                                            Lanjutkan
                                        </a>
                                    @elseif ($course->has_pending_payment)
                                        <button disabled class="text-xs font-semibold px-4 py-2 rounded-xl border border-amber-500/30 text-amber-600 cursor-not-allowed">
                                            Menunggu Verifikasi
                                        </button>
                                    @else
                                        <button
                                            type="button"
                                            class="text-xs font-semibold px-4 py-2 rounded-xl border border-[#025f5a] text-[#025f5a] hover:bg-[#025f5a] hover:text-white transition"
                                            data-course-id="{{ $course->course_id }}"
                                            data-course-title="{{ $course->title }}"
                                            data-course-thumbnail="{{ $course->thumbnail }}"
                                            data-course-is-paid="{{ $course->is_paid ? 'true' : 'false' }}"
                                            data-course-price="{{ $course->is_paid ? $course->getEffectivePrice() : 0 }}"
                                            data-course-instructor="{{ $course->instructor->name ?? 'Instructor' }}"
                                            data-course-lessons="{{ $course->lessons_count ?? 0 }}"
                                            data-course-students="{{ $course->students_count ?? 0 }}"
                                            onclick="openEnrollModalFromButton(this)"
                                        >
                                            Daftar Sekarang
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if ($paginationLinks)
                    <div class="mt-10">
                        {{ $paginationLinks }}
                    </div>
                @endif
            @endif
        </section>
    </div>
</div>

<!-- Enroll Modal -->
<div id="enrollModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-900 rounded-3xl border border-gray-200 dark:border-gray-800 w-full max-w-2xl shadow-2xl max-h-[90vh] overflow-y-auto">
        <div class="sticky top-0 bg-white dark:bg-gray-900 flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-800 z-10">
            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">Daftar Kursus</h3>
            <button onclick="closeEnrollModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>
        <div class="p-6">
            <div id="enrollModalContent">
                <!-- Course details will be populated here -->
            </div>
            <form id="enrollForm" method="POST" action="" enctype="multipart/form-data" class="mt-6">
                @csrf
                <div class="space-y-4">
                    <div id="paymentMethodSection" class="hidden">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Metode Pembayaran</label>
                        <div class="space-y-2">
                            <label class="flex items-center p-4 border border-gray-200 dark:border-gray-700 rounded-xl cursor-pointer hover:border-[#025f5a] transition">
                                <input type="radio" name="payment_method" value="manual-transfer" checked class="mr-3 text-[#025f5a] focus:ring-[#025f5a]">
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900 dark:text-gray-100">Transfer Manual</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Transfer ke rekening bank yang ditentukan</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div id="bankInfoSection" class="hidden">
                        <div class="bg-gradient-to-br from-[#025f5a] to-teal-600 rounded-2xl p-6 text-white">
                            <h4 class="text-sm font-semibold uppercase tracking-wide mb-4 opacity-90">Informasi Rekening</h4>
                            <div class="space-y-3">
                                <div class="flex items-center justify-between bg-white/10 backdrop-blur rounded-xl p-3">
                                    <div>
                                        <p class="text-xs opacity-75 mb-1">Bank</p>
                                        <p class="font-bold">Bank Mandiri</p>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between bg-white/10 backdrop-blur rounded-xl p-3">
                                    <div class="flex-1">
                                        <p class="text-xs opacity-75 mb-1">Nomor Rekening</p>
                                        <p class="font-bold text-lg tracking-wider">1370022078634</p>
                                    </div>
                                    <button type="button" onclick="copyToClipboard('1370022078634')" class="ml-3 px-3 py-1 bg-white/20 hover:bg-white/30 rounded-lg text-xs font-semibold transition whitespace-nowrap">
                                        <i class="fa-solid fa-copy mr-1"></i>Salin
                                    </button>
                                </div>
                                <div class="flex items-center justify-between bg-white/10 backdrop-blur rounded-xl p-3">
                                    <div>
                                        <p class="text-xs opacity-75 mb-1">Atas Nama</p>
                                        <p class="font-bold">FAIZ NURDIANA</p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 p-3 bg-white/10 backdrop-blur rounded-xl">
                                <p class="text-xs opacity-90">
                                    <i class="fa-solid fa-circle-info mr-1"></i>
                                    Transfer tepat sesuai nominal yang tertera dan unggah bukti transfer
                                </p>
                            </div>
                        </div>
                    </div>

                    <div id="proofUploadSection" class="hidden">
                        <label for="bukti_transfer" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Bukti Transfer <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input
                                type="file"
                                id="bukti_transfer"
                                name="bukti_transfer"
                                accept="image/jpeg,image/jpg,image/png,image/webp"
                                class="hidden"
                                required
                                onchange="previewProof(event)"
                            >
                            <label for="bukti_transfer" class="flex items-center justify-center w-full px-4 py-6 border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-xl cursor-pointer hover:border-[#025f5a] transition">
                                <div class="text-center" id="uploadPlaceholder">
                                    <i class="fa-solid fa-cloud-arrow-up text-3xl text-gray-400 mb-2"></i>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Klik untuk unggah bukti transfer</p>
                                    <p class="text-xs text-gray-400 mt-1">JPG, PNG, WEBP (Max 2MB)</p>
                                </div>
                                <div id="uploadPreview" class="hidden">
                                    <img id="proofImage" src="" alt="Preview" class="max-h-24 rounded-lg">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2" id="fileName"></p>
                                </div>
                            </label>
                        </div>
                        <p class="text-xs text-red-500 dark:text-red-400 mt-2">
                            <i class="fa-solid fa-exclamation-circle mr-1"></i>
                            Wajib mengunggah bukti transfer untuk kursus berbayar
                        </p>
                    </div>
                </div>
                <div class="flex items-center justify-end gap-3 mt-6 pt-4 border-t border-gray-200 dark:border-gray-800">
                    <button type="button" onclick="closeEnrollModal()" class="px-4 py-2 text-sm rounded-xl border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600 transition">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm rounded-xl bg-[#025f5a] text-white hover:bg-[#024842] transition">
                        Konfirmasi Pendaftaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let currentCourse = null;

function openEnrollModalFromButton(button) {
    // Extract data from button attributes
    const course = {
        course_id: button.getAttribute('data-course-id'),
        title: button.getAttribute('data-course-title'),
        thumbnail: button.getAttribute('data-course-thumbnail'),
        is_paid: button.getAttribute('data-course-is-paid') === 'true',
        price: parseInt(button.getAttribute('data-course-price')),
        instructor: {
            name: button.getAttribute('data-course-instructor')
        },
        lessons_count: parseInt(button.getAttribute('data-course-lessons')),
        students_count: parseInt(button.getAttribute('data-course-students'))
    };

    openEnrollModal(course);
}

function openEnrollModal(course) {
    console.log("Opening modal for course:", course);
    currentCourse = course;
    const modal = document.getElementById('enrollModal');
    const content = document.getElementById('enrollModalContent');
    const form = document.getElementById('enrollForm');
    const paymentSection = document.getElementById('paymentMethodSection');

    // Update form action - use Laravel route
    form.action = `/dashboard/my-courses/${course.course_id}/enroll`;
    console.log("Form action set to:", form.action);

    // Build course info
    const price = course.is_paid
        ? `Rp ${new Intl.NumberFormat('id-ID').format(course.price || 0)}`
        : 'Gratis';

    const badgeClass = course.is_paid
        ? 'bg-[#025f5a]/10 text-[#025f5a]'
        : 'bg-emerald-500/10 text-emerald-600';

    const badgeText = course.is_paid ? 'Premium' : 'Gratis';

    content.innerHTML = `
        <div class="flex gap-4">
            ${course.thumbnail
                ? `<img src="/storage/${course.thumbnail}" alt="${course.title}" class="w-24 h-24 rounded-2xl object-cover">`
                : `<div class="w-24 h-24 rounded-2xl bg-gradient-to-br from-[#025f5a] to-teal-500 flex items-center justify-center text-white text-3xl font-black">
                    ${course.title.charAt(0).toUpperCase()}
                </div>`
            }
            <div class="flex-1">
                <span class="px-2.5 py-1 rounded-full text-xs font-semibold ${badgeClass}">${badgeText}</span>
                <h4 class="text-lg font-bold text-gray-900 dark:text-gray-100 mt-2">${course.title}</h4>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    <i class="fa-solid fa-user mr-1"></i>${course.instructor?.name || 'Instructor'}
                </p>
                <div class="flex items-center gap-4 mt-3 text-xs text-gray-500 dark:text-gray-400">
                    <span><i class="fa-solid fa-layer-group mr-1 text-[#025f5a]"></i>${course.lessons_count || 0} modul</span>
                    <span><i class="fa-solid fa-users mr-1 text-[#025f5a]"></i>${course.students_count || 0} siswa</span>
                </div>
            </div>
        </div>
        <div class="mt-4 p-4 bg-gray-50 dark:bg-gray-800 rounded-xl">
            <div class="flex items-center justify-between">
                <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Total Pembayaran</span>
                <span class="text-xl font-bold text-[#025f5a] dark:text-teal-300">${price}</span>
            </div>
        </div>
    `;

    // Show/hide payment method section
    if (course.is_paid) {
        paymentSection.classList.remove('hidden');
        document.getElementById('bankInfoSection').classList.remove('hidden');
        document.getElementById('proofUploadSection').classList.remove('hidden');
    } else {
        paymentSection.classList.add('hidden');
        document.getElementById('bankInfoSection').classList.add('hidden');
        document.getElementById('proofUploadSection').classList.add('hidden');
    }

    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

// Add form submission handler
document.addEventListener('DOMContentLoaded', function() {
    const enrollForm = document.getElementById('enrollForm');
    if (enrollForm) {
        enrollForm.addEventListener('submit', function(e) {
            // Validate form has an action
            if (!this.action || this.action === '' || this.action === window.location.href) {
                e.preventDefault();
                alert('Error: Form action not set. Please try closing and reopening the modal.');
                console.error('Form action is not properly set:', this.action);
                return false;
            }

            // Check if paid course requires bukti_transfer
            const isPaid = currentCourse && currentCourse.is_paid;
            const buktiTransfer = document.getElementById('bukti_transfer');

            if (isPaid && buktiTransfer && !buktiTransfer.files.length) {
                e.preventDefault();
                alert('Harap unggah bukti transfer untuk kursus berbayar');
                return false;
            }

            console.log('Form submitting to:', this.action);
            // Allow form to submit
            return true;
        });
    }
});

function closeEnrollModal() {
    document.getElementById('enrollModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
    currentCourse = null;

    // Reset file input
    const fileInput = document.getElementById('bukti_transfer');
    if (fileInput) {
        fileInput.value = '';
        document.getElementById('uploadPlaceholder').classList.remove('hidden');
        document.getElementById('uploadPreview').classList.add('hidden');
    }
}

function previewProof(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('proofImage').src = e.target.result;
            document.getElementById('fileName').textContent = file.name;
            document.getElementById('uploadPlaceholder').classList.add('hidden');
            document.getElementById('uploadPreview').classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
}

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Show temporary success message
        const event = new CustomEvent('toast', {
            detail: { message: 'Nomor rekening disalin!', type: 'success' }
        });
        window.dispatchEvent(event);

        // Fallback: simple alert if toast not available
        setTimeout(() => {
            if (!window.toastShown) {
                alert('Nomor rekening disalin: ' + text);
            }
        }, 100);
    }).catch(function(err) {
        alert('Gagal menyalin: ' + err);
    });
}

// Close modal when clicking outside
document.getElementById('enrollModal')?.addEventListener('click', function(event) {
    if (event.target === this) {
        closeEnrollModal();
    }
});

// Close modal with ESC key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeEnrollModal();
    }
});
</script>
@endsection
