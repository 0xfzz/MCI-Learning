@extends('layouts.dashboard')

@section('title', 'Verifikasi Transaksi - MCI Learning')

@section('search-placeholder', 'Cari transaksi atau invoice...')

@section('content')
<div class="mb-10">
    <p class="text-sm uppercase tracking-widest text-gray-400 dark:text-gray-500 font-semibold">Panel Admin</p>
    <h1 class="text-3xl font-black text-gray-900 dark:text-gray-100">Verifikasi Transaksi</h1>
    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Pastikan seluruh pembayaran terverifikasi tepat waktu untuk menjaga kepercayaan peserta.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
    @forelse ($summaryCards as $item)
        <div class="rounded-3xl border border-gray-200 dark:border-gray-800 bg-white/95 dark:bg-gray-900/95 backdrop-blur p-6">
            <p class="text-xs uppercase tracking-wide text-gray-400 dark:text-gray-500 font-semibold mb-3">{{ $item['label'] }}</p>
            @php
                $valueClass = $item['accent'] ?? 'text-gray-900 dark:text-gray-100';
            @endphp
            <p class="text-3xl font-black mb-2"><span class="{{ $valueClass }}">{{ $item['value'] }}</span></p>
        </div>
    @empty
        <div class="col-span-full rounded-3xl border border-dashed border-gray-200 dark:border-gray-800 p-6 text-center text-sm text-gray-500 dark:text-gray-400">
            Belum ada data verifikasi pembayaran.
        </div>
    @endforelse
</div>

<section class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-3xl p-6 mb-10">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">Antrian Verifikasi</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Tinjau bukti pembayaran dan selesaikan verifikasi.</p>
        </div>
        <div class="flex gap-2">
            <form method="GET" action="{{ route('dashboard.transactions.index') }}" class="flex items-center gap-2">
                <label for="status" class="sr-only">Status</label>
                <select id="status" name="status" class="px-3 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm text-gray-600 dark:text-gray-300 focus:ring-2 focus:ring-teal-500 focus:outline-none">
                    <option value="all" @selected(($filters['status'] ?? 'all') === 'all')>Semua Status</option>
                    <option value="pending" @selected(($filters['status'] ?? 'all') === 'pending')>Menunggu</option>
                    <option value="success" @selected(($filters['status'] ?? 'all') === 'success')>Terverifikasi</option>
                    <option value="failed" @selected(($filters['status'] ?? 'all') === 'failed')>Ditolak</option>
                    <option value="clarification" @selected(($filters['status'] ?? 'all') === 'clarification')>Perlu Klarifikasi</option>
                </select>
                <button type="submit" class="px-4 py-2 text-sm rounded-xl border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 hover:border-teal-400/60 transition">Filter</button>
            </form>
            <form method="POST" action="{{ route('dashboard.payments.bulk-complete') }}">
                @csrf
                <button type="submit" class="px-4 py-2 text-sm rounded-xl [background:linear-gradient(135deg,#06b6d4,#025f5a)] text-white shadow-[0_14px_35px_rgba(2,95,90,0.3)]">Tandai Selesai</button>
            </form>
        </div>
    </div>
    <div class="space-y-4">
        @forelse ($pendingTransactions as $transaction)
            <div class="p-4 rounded-2xl border border-gray-200 dark:border-gray-800 bg-gray-50/60 dark:bg-gray-800/40">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $transaction['invoice'] }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $transaction['user'] }} • {{ $transaction['course'] }}</p>
                        @if ($transaction['needs_clarification'])
                            <span class="mt-2 inline-flex items-center gap-1 text-[11px] font-semibold text-amber-600">
                                <i class="fa-solid fa-circle-exclamation"></i> Klarifikasi diminta
                            </span>
                        @endif
                    </div>
                    <p class="font-semibold text-teal-600 dark:text-teal-300">{{ $transaction['amount'] }}</p>
                </div>
                <div class="mt-3 flex items-center justify-between text-xs text-gray-400 dark:text-gray-500">
                    <span>Diunggah {{ $transaction['submitted'] }}</span>
                    <div class="flex gap-2">
                        <button type="button" onclick="showVerificationModal({{ json_encode($transaction) }})" class="px-4 py-2 rounded-xl text-white font-semibold [background:linear-gradient(135deg,#06b6d4,#025f5a)] hover:shadow-lg transition">
                            <i class="fa-solid fa-clipboard-check"></i> Tinjau & Verifikasi
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-sm text-gray-500 dark:text-gray-400">Tidak ada transaksi yang menunggu verifikasi.</p>
        @endforelse
    </div>
</section>

<section class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-3xl p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">Riwayat Verifikasi</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Catatan transaksi yang telah diproses.</p>
        </div>
    <a href="{{ route('dashboard.transactions.index', ['status' => 'all']) }}" class="text-sm font-semibold text-teal-600 dark:text-teal-300 hover:text-teal-500">Lihat semua</a>
    </div>
    @php
        $statusLabels = [
            'success' => 'Terverifikasi',
            'failed' => 'Ditolak',
            'pending' => 'Menunggu Verifikasi',
        ];
        $statusColors = [
            'success' => 'bg-emerald-500/10 text-emerald-500',
            'failed' => 'bg-rose-500/10 text-rose-500',
            'pending' => 'bg-amber-500/10 text-amber-500',
            'clarification' => 'bg-amber-500/10 text-amber-500',
        ];
    @endphp
    <div class="divide-y divide-gray-100 dark:divide-gray-800 text-sm">
        @forelse ($history as $row)
            <div class="py-4 flex items-center justify-between">
                <div>
                    <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $row['invoice'] }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $row['user'] }} • {{ $row['course'] }}</p>
                </div>
                <div class="flex items-center gap-4">
                    @php
                        $statusKey = $row['clarification_requested'] ? 'clarification' : $row['status'];
                        $statusLabel = $row['clarification_requested'] ? 'Klarifikasi Diminta' : ($statusLabels[$row['status']] ?? ucfirst($row['status']));
                        $statusClass = $statusColors[$statusKey] ?? 'bg-gray-200 text-gray-600';
                    @endphp
                    <span class="px-3 py-1 rounded-lg text-xs font-semibold {{ $statusClass }}">{{ $statusLabel }}</span>
                    <span class="text-xs text-gray-400 dark:text-gray-500">{{ $row['time'] }}</span>
                </div>
            </div>
        @empty
            <p class="py-6 text-center text-sm text-gray-500 dark:text-gray-400">Belum ada riwayat verifikasi.</p>
        @endforelse
    </div>
</section>

<!-- Verification Modal -->
<div id="verificationModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay with blur -->
        <div class="fixed inset-0 transition-opacity bg-gray-900/75 backdrop-blur-sm" onclick="closeVerificationModal()"></div>

        <!-- Modal panel -->
        <div class="relative inline-block align-bottom bg-white dark:bg-gray-900 rounded-3xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full border border-gray-200 dark:border-gray-800">
            <div class="bg-white dark:bg-gray-900 px-6 pt-5 pb-4">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100" id="modalTitle">Verifikasi Pembayaran</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1" id="modalSubtitle"></p>
                    </div>
                    <button type="button" onclick="closeVerificationModal()" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                        <i class="fa-solid fa-xmark text-2xl"></i>
                    </button>
                </div>

                <!-- Transaction Details -->
                <div class="mb-4 p-4 rounded-2xl bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700">
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-gray-500 dark:text-gray-400 mb-1">Invoice</p>
                            <p class="font-semibold text-gray-900 dark:text-gray-100" id="detailInvoice"></p>
                        </div>
                        <div>
                            <p class="text-gray-500 dark:text-gray-400 mb-1">Jumlah</p>
                            <p class="font-semibold text-teal-600 dark:text-teal-300" id="detailAmount"></p>
                        </div>
                        <div>
                            <p class="text-gray-500 dark:text-gray-400 mb-1">Peserta</p>
                            <p class="font-semibold text-gray-900 dark:text-gray-100" id="detailUser"></p>
                        </div>
                        <div>
                            <p class="text-gray-500 dark:text-gray-400 mb-1">Kursus</p>
                            <p class="font-semibold text-gray-900 dark:text-gray-100" id="detailCourse"></p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-gray-500 dark:text-gray-400 mb-1">Metode Pembayaran</p>
                            <p class="font-semibold text-gray-900 dark:text-gray-100" id="detailPaymentMethod"></p>
                        </div>
                    </div>
                </div>

                <!-- Proof Image -->
                <div class="mt-4">
                    <p class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Bukti Transfer</p>
                    <div id="proofImageContainer" class="relative">
                        <img id="proofImage" src="" alt="Bukti Transfer" class="w-full rounded-2xl border border-gray-200 dark:border-gray-800">
                    </div>
                    <div id="noProofMessage" class="hidden p-8 text-center rounded-2xl border border-dashed border-gray-300 dark:border-gray-700">
                        <i class="fa-solid fa-image text-4xl text-gray-300 dark:text-gray-600 mb-2"></i>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Tidak ada bukti transfer yang diunggah</p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="bg-gray-50 dark:bg-gray-800/50 px-6 py-4 flex justify-between items-center gap-3 border-t border-gray-200 dark:border-gray-700">
                <button type="button" onclick="closeVerificationModal()" class="px-4 py-2 rounded-xl border border-gray-200 dark:border-gray-700 text-sm text-gray-600 dark:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600 transition">
                    <i class="fa-solid fa-xmark"></i> Batal
                </button>
                <div class="flex gap-3">
                    <form id="clarifyForm" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2 rounded-xl border border-amber-500/40 bg-amber-50 dark:bg-amber-500/10 text-amber-600 dark:text-amber-400 font-semibold hover:bg-amber-100 dark:hover:bg-amber-500/20 transition">
                            <i class="fa-solid fa-circle-exclamation"></i> Minta Klarifikasi
                        </button>
                    </form>
                    <form id="rejectForm" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2 rounded-xl border border-rose-500/40 bg-rose-50 dark:bg-rose-500/10 text-rose-600 dark:text-rose-400 font-semibold hover:bg-rose-100 dark:hover:bg-rose-500/20 transition">
                            <i class="fa-solid fa-xmark-circle"></i> Tolak
                        </button>
                    </form>
                    <form id="verifyForm" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-6 py-2 rounded-xl text-white font-semibold [background:linear-gradient(135deg,#10b981,#059669)] hover:shadow-lg transition">
                            <i class="fa-solid fa-check-circle"></i> Verifikasi
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let currentTransaction = null;

    function showVerificationModal(transaction) {
        currentTransaction = transaction;

        // Update modal title and subtitle
        document.getElementById('modalTitle').textContent = 'Verifikasi Pembayaran';
        document.getElementById('modalSubtitle').textContent = 'Tinjau bukti pembayaran dan lakukan verifikasi';

        // Update transaction details
        document.getElementById('detailInvoice').textContent = transaction.invoice;
        document.getElementById('detailAmount').textContent = transaction.amount;
        document.getElementById('detailUser').textContent = transaction.user;
        document.getElementById('detailCourse').textContent = transaction.course;
        document.getElementById('detailPaymentMethod').textContent = transaction.payment_method || 'Transfer Bank';

        // Update proof image
        const proofImageContainer = document.getElementById('proofImageContainer');
        const proofImage = document.getElementById('proofImage');
        const noProofMessage = document.getElementById('noProofMessage');

        if (transaction.bukti_transfer) {
            proofImage.src = '/storage/' + transaction.bukti_transfer;
            proofImageContainer.classList.remove('hidden');
            noProofMessage.classList.add('hidden');
        } else {
            proofImageContainer.classList.add('hidden');
            noProofMessage.classList.remove('hidden');
        }

        // Update form actions
        document.getElementById('verifyForm').action = '/dashboard/payments/' + transaction.id + '/verify';
        document.getElementById('clarifyForm').action = '/dashboard/payments/' + transaction.id + '/clarify';
        document.getElementById('rejectForm').action = '/dashboard/payments/' + transaction.id + '/reject';

        // Show modal
        document.getElementById('verificationModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeVerificationModal() {
        document.getElementById('verificationModal').classList.add('hidden');
        document.body.style.overflow = '';
        currentTransaction = null;
    }

    // Close modal on Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeVerificationModal();
        }
    });
</script>
@endpush
