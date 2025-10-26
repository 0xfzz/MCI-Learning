<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
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
    protected $primaryKey = "course_id";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "instructor_id",
        "category_id",
        "title",
        "description",
        "thumbnail",
        "level",
        "price",
        "discount_price",
        "is_paid",
        "whatsapp_group",
        "source_code_link",
        "status",
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            "is_paid" => "boolean",
            "price" => "integer",
            "discount_price" => "integer",
        ];
    }

    /**
     * Get the instructor that owns the course.
     */
    public function instructor()
    {
        return $this->belongsTo(User::class, "instructor_id", "user_id");
    }

    /**
     * Get the category that owns the course.
     */
    public function category()
    {
        return $this->belongsTo(Category::class, "category_id", "category_id");
    }

    /**
     * Get the lessons for the course.
     */
    public function lessons()
    {
        return $this->hasMany(Lesson::class, "course_id", "course_id");
    }

    /**
     * Get the sections (parent lessons) for the course.
     */
    public function sections()
    {
        return $this->hasMany(Lesson::class, "course_id", "course_id")
            ->whereNull("parent_id")
            ->where("is_section", true)
            ->orderBy("order_number");
    }

    /**
     * Get the enrollments for the course.
     */
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, "course_id", "course_id");
    }

    /**
     * Get the enrolled students for the course.
     */
    public function students()
    {
        return $this->belongsToMany(
            User::class,
            "enrollments",
            "course_id",
            "user_id",
            "course_id",
            "user_id",
        )->withPivot("enrolled_at", "is_completed", "completed_at");
    }

    /**
     * Get the payments for the course.
     */
    public function payments()
    {
        return $this->hasMany(Payment::class, "course_id", "course_id");
    }

    /**
     * Get the reviews for the course.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class, "course_id", "course_id");
    }

    /**
     * Get the average rating for the course.
     */
    public function averageRating()
    {
        return $this->reviews()->avg("rating");
    }

    /**
     * Get the total number of students enrolled in the course.
     */
    public function totalStudents()
    {
        return $this->enrollments()->count();
    }

    /**
     * Check if the course is published.
     */
    public function isPublished(): bool
    {
        return $this->status === "published";
    }

    /**
     * Check if the course is draft.
     */
    public function isDraft(): bool
    {
        return $this->status === "draft";
    }

    /**
     * Check if the course is free.
     */
    public function isFree(): bool
    {
        return !$this->is_paid || $this->price == 0;
    }

    /**
     * Get the effective price (considering discount).
     */
    public function getEffectivePrice()
    {
        return $this->discount_price ?? $this->price;
    }
}
