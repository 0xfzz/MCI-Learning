<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonProgress extends Model
{
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "lesson_progress";

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = "progress_id";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "user_id",
        "lesson_id",
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
            "completed_at" => "datetime",
        ];
    }

    /**
     * Get the user that owns the progress.
     */
    public function user()
    {
        return $this->belongsTo(User::class, "user_id", "user_id");
    }

    /**
     * Get the lesson that owns the progress.
     */
    public function lesson()
    {
        return $this->belongsTo(Lesson::class, "lesson_id", "lesson_id");
    }

    /**
     * Mark the lesson as completed.
     */
    public function markAsCompleted()
    {
        $this->update([
            "is_completed" => true,
            "completed_at" => now(),
        ]);
    }

    /**
     * Mark the lesson as incomplete.
     */
    public function markAsIncomplete()
    {
        $this->update([
            "is_completed" => false,
            "completed_at" => null,
        ]);
    }

    /**
     * Scope a query to only include completed progress.
     */
    public function scopeCompleted($query)
    {
        return $query->where("is_completed", true);
    }

    /**
     * Scope a query to only include incomplete progress.
     */
    public function scopeIncomplete($query)
    {
        return $query->where("is_completed", false);
    }
}
