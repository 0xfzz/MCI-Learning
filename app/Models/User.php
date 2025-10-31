<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = "user_id";

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        "username",
        "email",
        "password",
        "role",
        "name",
        "avatar",
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = ["password"];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            "password" => "hashed",
            "created_at" => "datetime",
                "updated_at" => "datetime",
                "email_verified_at" => "datetime",
        ];
    }

    /**
     * Disable remember token support since the column does not exist.
     */
    public function getRememberTokenName()
    {
        return null;
    }

    /**
     * Get the courses taught by the instructor.
     */
    public function taughtCourses()
    {
        return $this->hasMany(Course::class, "instructor_id", "user_id");
    }

    /**
     * Get the enrollments for the user.
     */
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, "user_id", "user_id");
    }

    /**
     * Get the courses the user is enrolled in.
     */
    public function enrolledCourses()
    {
        return $this->belongsToMany(
            Course::class,
            "enrollments",
            "user_id",
            "course_id",
            "user_id",
            "course_id",
        )->withPivot("enrolled_at", "is_completed", "completed_at");
    }

    /**
     * Get the lesson progress for the user.
     */
    public function lessonProgress()
    {
        return $this->hasMany(LessonProgress::class, "user_id", "user_id");
    }

    /**
     * Get the payments made by the user.
     */
    public function payments()
    {
        return $this->hasMany(Payment::class, "user_id", "user_id");
    }

    /**
     * Get the reviews written by the user.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class, "user_id", "user_id");
    }

    /**
     * Check if the user is an admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === "admin";
    }

    /**
     * Check if the user is an instructor.
     */
    public function isInstructor(): bool
    {
        return $this->role === "instructor";
    }

    /**
     * Check if the user is a student.
     */
    public function isStudent(): bool
    {
        return $this->role === "student";
    }

    public function getRouteKeyName(): string
    {
        return "user_id";
    }
}
