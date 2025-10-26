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
    const UPDATED_AT = null;

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
    protected $fillable = ["user_id", "course_id", "rating", "comment"];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            "rating" => "integer",
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
}
