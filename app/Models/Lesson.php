<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = "lesson_id";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "course_id",
        "parent_id",
        "title",
        "youtube_link",
        "duration",
        "order_number",
        "is_section",
        "is_free",
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            "is_section" => "boolean",
            "is_free" => "boolean",
            "order_number" => "integer",
        ];
    }

    /**
     * Get the course that owns the lesson.
     */
    public function course()
    {
        return $this->belongsTo(Course::class, "course_id", "course_id");
    }

    /**
     * Get the parent section (if this is a child lesson).
     */
    public function parent()
    {
        return $this->belongsTo(Lesson::class, "parent_id", "lesson_id");
    }

    /**
     * Get the child lessons (if this is a section).
     */
    public function children()
    {
        return $this->hasMany(Lesson::class, "parent_id", "lesson_id")->orderBy(
            "order_number",
        );
    }

    /**
     * Get the progress records for the lesson.
     */
    public function progress()
    {
        return $this->hasMany(LessonProgress::class, "lesson_id", "lesson_id");
    }

    /**
     * Check if user has completed this lesson.
     */
    public function isCompletedBy($userId)
    {
        return $this->progress()
            ->where("user_id", $userId)
            ->where("is_completed", true)
            ->exists();
    }

    /**
     * Scope a query to only include sections.
     */
    public function scopeSections($query)
    {
        return $query->where("is_section", true);
    }

    /**
     * Scope a query to only include video lessons.
     */
    public function scopeVideos($query)
    {
        return $query->where("is_section", false);
    }

    /**
     * Scope a query to only include free lessons.
     */
    public function scopeFree($query)
    {
        return $query->where("is_free", true);
    }

    /**
     * Get lessons ordered by order_number.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy("order_number");
    }
}
