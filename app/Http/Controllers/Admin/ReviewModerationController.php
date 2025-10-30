<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewModerationController extends Controller
{
    public function index(Request $request)
    {
        $statusFilter = $request->query('status', 'pending');

        $reviewsQuery = Review::query()
            ->with(['user', 'course', 'approvedBy'])
            ->orderByDesc('created_at');

        if ($statusFilter !== 'all') {
            $reviewsQuery->where('status', $statusFilter);
        }

        $reviews = $reviewsQuery->paginate(10)->withQueryString();

        $stats = [
            'all' => Review::count(),
            'pending' => Review::pending()->count(),
            'approved' => Review::approved()->count(),
            'rejected' => Review::rejected()->count(),
        ];

        return view('dashboard.admin.reviews', compact('reviews', 'stats', 'statusFilter'));
    }

    public function approve(Request $request, Review $review)
    {
        if ($review->status === 'approved') {
            return back()->with('status', 'Ulasan sudah dalam status disetujui.');
        }

        $review->fill([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => $request->user()->user_id,
        ])->save();

        $review->course?->refreshReviewStats();

        return back()->with('status', 'Ulasan berhasil disetujui.');
    }

    public function reject(Request $request, Review $review)
    {
        if ($review->status === 'rejected') {
            return back()->with('status', 'Ulasan sudah dalam status ditolak.');
        }

        $previousStatus = $review->status;

        $review->fill([
            'status' => 'rejected',
            'approved_at' => null,
            'approved_by' => null,
        ])->save();

        if ($previousStatus === 'approved') {
            $review->course?->refreshReviewStats();
        }

        return back()->with('status', 'Ulasan berhasil ditolak.');
    }
}
