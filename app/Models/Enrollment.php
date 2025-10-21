<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = "enrollment_id";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "user_id",
        "course_id",
        "enrolled_at",
        "is_completed",
        "completed_at",
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            "is_completed" => "boolean",
            "enrolled_at" => "datetime",
            "completed_at" => "datetime",
        ];
    }

    /**
     * Get the user that owns the enrollment.
     */
    public function user()
    {
        return $this->belongsTo(User::class, "user_id", "user_id");
    }

    /**
     * Get the course that owns the enrollment.
     */
    public function course()
    {
        return $this->belongsTo(Course::class, "course_id", "course_id");
    }

    /**
     * Mark the enrollment as completed.
     */
    public function markAsCompleted()
    {
        $this->update([
            "is_completed" => true,
            "completed_at" => now(),
        ]);
    }

    /**
     * Calculate the progress percentage for this enrollment.
     */
    public function progressPercentage()
    {
        $totalLessons = $this->course->lessons()->videos()->count();

        if ($totalLessons === 0) {
            return 0;
        }

        $completedLessons = LessonProgress::where("user_id", $this->user_id)
            ->whereIn(
                "lesson_id",
                $this->course->lessons()->videos()->pluck("lesson_id"),
            )
            ->where("is_completed", true)
            ->count();

        return round(($completedLessons / $totalLessons) * 100, 2);
    }

    /**
     * Scope a query to only include completed enrollments.
     */
    public function scopeCompleted($query)
    {
        return $query->where("is_completed", true);
    }

    /**
     * Scope a query to only include active (not completed) enrollments.
     */
    public function scopeActive($query)
    {
        return $query->where("is_completed", false);
    }
}
