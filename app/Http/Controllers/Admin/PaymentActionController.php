<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PaymentActionController extends Controller
{
    /**
     * Mark an individual payment as verified.
     */
    public function verify(Request $request, Payment $payment): RedirectResponse
    {
        $payment->markAsSuccess();

        return $this->redirectWithMessage($request, 'Transaksi berhasil diverifikasi.');
    }

    /**
     * Request additional clarification for a payment.
     */
    public function requestClarification(Request $request, Payment $payment): RedirectResponse
    {
        $payment->requestClarification();

        return $this->redirectWithMessage($request, 'Permintaan klarifikasi telah dikirim ke peserta.');
    }

    /**
     * Reject a payment submission.
     */
    public function reject(Request $request, Payment $payment): RedirectResponse
    {
        $payment->markAsFailed();

        return $this->redirectWithMessage($request, 'Transaksi ditandai sebagai ditolak.');
    }

    /**
     * Mark all pending payments as verified in bulk.
     */
    public function bulkComplete(Request $request): RedirectResponse
    {
        $pendingPayments = Payment::pending()->get();

        $pendingPayments->each->markAsSuccess();

        $message = $pendingPayments->isEmpty()
            ? 'Tidak ada transaksi menunggu verifikasi.'
            : sprintf('%d transaksi berhasil diverifikasi.', $pendingPayments->count());

        return $this->redirectWithMessage($request, $message);
    }

    /**
     * Redirect back to the previous page while preserving filters and flashes.
     */
    private function redirectWithMessage(Request $request, string $message): RedirectResponse
    {
        return back()->with('status', $message);
    }
}
