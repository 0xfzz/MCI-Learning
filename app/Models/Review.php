<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = "created_at";

    /**
     * The name of the "updated at" column.
     *
     * @var string|null
     */
    const UPDATED_AT = "updated_at";

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = "review_id";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "user_id",
        "course_id",
        "rating",
        "comment",
        "status",
        "approved_at",
        "approved_by",
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        "status" => "pending",
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            "rating" => "integer",
            "approved_at" => "datetime",
        ];
    }

    /**
     * Get the user that owns the review.
     */
    public function user()
    {
        return $this->belongsTo(User::class, "user_id", "user_id");
    }

    /**
     * Get the course that owns the review.
     */
    public function course()
    {
        return $this->belongsTo(Course::class, "course_id", "course_id");
    }

    /**
     * Get the admin who approved the review.
     */
    public function approvedBy()
    {
        return $this->belongsTo(User::class, "approved_by", "user_id");
    }

    /**
     * Scope a query to filter by rating.
     */
    public function scopeRating($query, $rating)
    {
        return $query->where("rating", $rating);
    }

    /**
     * Scope a query to only include reviews with comments.
     */
    public function scopeWithComment($query)
    {
        return $query->whereNotNull("comment");
    }

    /**
     * Scope a query to order by rating (highest first).
     */
    public function scopeHighestRated($query)
    {
        return $query->orderBy("rating", "desc");
    }

    /**
     * Scope a query to order by rating (lowest first).
     */
    public function scopeLowestRated($query)
    {
        return $query->orderBy("rating", "asc");
    }

    /**
     * Scope a query to order by most recent.
     */
    public function scopeRecent($query)
    {
        return $query->orderBy("created_at", "desc");
    }

    /**
     * Scope for approved testimonials.
     */
    public function scopeApproved($query)
    {
        return $query->where("status", "approved");
    }

    /**
     * Scope for pending reviews.
     */
    public function scopePending($query)
    {
        return $query->where("status", "pending");
    }

    /**
     * Scope for rejected reviews.
     */
    public function scopeRejected($query)
    {
        return $query->where("status", "rejected");
    }

    public function getRouteKeyName()
    {
        return "review_id";
    }
}
