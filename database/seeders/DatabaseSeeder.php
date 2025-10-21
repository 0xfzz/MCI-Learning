<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\LessonProgress;
use App\Models\Payment;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Users
        $admin = User::create([
            "username" => "admin",
            "email" => "admin@example.com",
            "password" => Hash::make("password"),
            "role" => "admin",
            "name" => "Admin User",
            "avatar" => null,
        ]);

        $instructor1 = User::create([
            "username" => "instructor1",
            "email" => "instructor1@example.com",
            "password" => Hash::make("password"),
            "role" => "instructor",
            "name" => "John Doe",
            "avatar" => null,
        ]);

        $instructor2 = User::create([
            "username" => "instructor2",
            "email" => "instructor2@example.com",
            "password" => Hash::make("password"),
            "role" => "instructor",
            "name" => "Jane Smith",
            "avatar" => null,
        ]);

        $student1 = User::create([
            "username" => "student1",
            "email" => "student1@example.com",
            "password" => Hash::make("password"),
            "role" => "student",
            "name" => "Alice Johnson",
            "avatar" => null,
        ]);

        $student2 = User::create([
            "username" => "student2",
            "email" => "student2@example.com",
            "password" => Hash::make("password"),
            "role" => "student",
            "name" => "Bob Williams",
            "avatar" => null,
        ]);

        // Create Categories
        $frontend = Category::create([
            "name" => "Frontend Development",
            "slug" => "frontend-development",
        ]);

        $backend = Category::create([
            "name" => "Backend Development",
            "slug" => "backend-development",
        ]);

        $mobile = Category::create([
            "name" => "Mobile Development",
            "slug" => "mobile-development",
        ]);

        $database = Category::create([
            "name" => "Database",
            "slug" => "database",
        ]);

        // Create Courses
        $reactCourse = Course::create([
            "instructor_id" => $instructor1->user_id,
            "category_id" => $frontend->category_id,
            "title" => "Complete React Development Course",
            "description" =>
                "Learn React from scratch including hooks, context API, and Redux",
            "thumbnail" => null,
            "level" => "beginner",
            "price" => 299000,
            "discount_price" => 199000,
            "is_paid" => true,
            "whatsapp_group" => "https://chat.whatsapp.com/react-group",
            "source_code_link" => "https://github.com/example/react-course",
            "status" => "published",
        ]);

        $laravelCourse = Course::create([
            "instructor_id" => $instructor1->user_id,
            "category_id" => $backend->category_id,
            "title" => "Laravel Mastery - Build Modern Web Apps",
            "description" =>
                "Master Laravel framework and build professional web applications",
            "thumbnail" => null,
            "level" => "intermediate",
            "price" => 399000,
            "discount_price" => null,
            "is_paid" => true,
            "whatsapp_group" => "https://chat.whatsapp.com/laravel-group",
            "source_code_link" => "https://github.com/example/laravel-course",
            "status" => "published",
        ]);

        $flutterCourse = Course::create([
            "instructor_id" => $instructor2->user_id,
            "category_id" => $mobile->category_id,
            "title" => "Flutter Mobile App Development",
            "description" =>
                "Create beautiful cross-platform mobile apps with Flutter",
            "thumbnail" => null,
            "level" => "beginner",
            "price" => 0,
            "discount_price" => null,
            "is_paid" => false,
            "whatsapp_group" => "https://chat.whatsapp.com/flutter-group",
            "source_code_link" => "https://github.com/example/flutter-course",
            "status" => "published",
        ]);

        // Create Lessons for React Course
        $reactSection1 = Lesson::create([
            "course_id" => $reactCourse->course_id,
            "parent_id" => null,
            "title" => "Introduction to React",
            "youtube_link" => null,
            "duration" => null,
            "order_number" => 1,
            "is_section" => true,
            "is_free" => false,
        ]);

        Lesson::create([
            "course_id" => $reactCourse->course_id,
            "parent_id" => $reactSection1->lesson_id,
            "title" => "What is React and Why Use It?",
            "youtube_link" => "https://www.youtube.com/watch?v=dQw4w9WgXcQ",
            "duration" => "15:30",
            "order_number" => 1,
            "is_section" => false,
            "is_free" => true,
        ]);

        Lesson::create([
            "course_id" => $reactCourse->course_id,
            "parent_id" => $reactSection1->lesson_id,
            "title" => "Setup Development Environment",
            "youtube_link" => "https://www.youtube.com/watch?v=dQw4w9WgXcQ",
            "duration" => "12:45",
            "order_number" => 2,
            "is_section" => false,
            "is_free" => true,
        ]);

        Lesson::create([
            "course_id" => $reactCourse->course_id,
            "parent_id" => $reactSection1->lesson_id,
            "title" => "Your First React Component",
            "youtube_link" => "https://www.youtube.com/watch?v=dQw4w9WgXcQ",
            "duration" => "18:20",
            "order_number" => 3,
            "is_section" => false,
            "is_free" => false,
        ]);

        $reactSection2 = Lesson::create([
            "course_id" => $reactCourse->course_id,
            "parent_id" => null,
            "title" => "React Hooks Deep Dive",
            "youtube_link" => null,
            "duration" => null,
            "order_number" => 2,
            "is_section" => true,
            "is_free" => false,
        ]);

        Lesson::create([
            "course_id" => $reactCourse->course_id,
            "parent_id" => $reactSection2->lesson_id,
            "title" => "useState Hook Explained",
            "youtube_link" => "https://www.youtube.com/watch?v=dQw4w9WgXcQ",
            "duration" => "22:10",
            "order_number" => 1,
            "is_section" => false,
            "is_free" => false,
        ]);

        Lesson::create([
            "course_id" => $reactCourse->course_id,
            "parent_id" => $reactSection2->lesson_id,
            "title" => "useEffect Hook and Side Effects",
            "youtube_link" => "https://www.youtube.com/watch?v=dQw4w9WgXcQ",
            "duration" => "24:35",
            "order_number" => 2,
            "is_section" => false,
            "is_free" => false,
        ]);

        // Create Lessons for Laravel Course
        $laravelSection1 = Lesson::create([
            "course_id" => $laravelCourse->course_id,
            "parent_id" => null,
            "title" => "Getting Started with Laravel",
            "youtube_link" => null,
            "duration" => null,
            "order_number" => 1,
            "is_section" => true,
            "is_free" => false,
        ]);

        Lesson::create([
            "course_id" => $laravelCourse->course_id,
            "parent_id" => $laravelSection1->lesson_id,
            "title" => "Laravel Installation and Setup",
            "youtube_link" => "https://www.youtube.com/watch?v=dQw4w9WgXcQ",
            "duration" => "16:45",
            "order_number" => 1,
            "is_section" => false,
            "is_free" => true,
        ]);

        Lesson::create([
            "course_id" => $laravelCourse->course_id,
            "parent_id" => $laravelSection1->lesson_id,
            "title" => "Understanding MVC Architecture",
            "youtube_link" => "https://www.youtube.com/watch?v=dQw4w9WgXcQ",
            "duration" => "20:30",
            "order_number" => 2,
            "is_section" => false,
            "is_free" => false,
        ]);

        // Create Enrollments
        $enrollment1 = Enrollment::create([
            "user_id" => $student1->user_id,
            "course_id" => $reactCourse->course_id,
            "enrolled_at" => now()->subDays(10),
            "is_completed" => false,
            "completed_at" => null,
        ]);

        Enrollment::create([
            "user_id" => $student1->user_id,
            "course_id" => $flutterCourse->course_id,
            "enrolled_at" => now()->subDays(5),
            "is_completed" => false,
            "completed_at" => null,
        ]);

        Enrollment::create([
            "user_id" => $student2->user_id,
            "course_id" => $laravelCourse->course_id,
            "enrolled_at" => now()->subDays(7),
            "is_completed" => false,
            "completed_at" => null,
        ]);

        // Create Lesson Progress
        $reactLessons = $reactCourse->lessons()->videos()->get();
        if ($reactLessons->count() > 0) {
            LessonProgress::create([
                "user_id" => $student1->user_id,
                "lesson_id" => $reactLessons[0]->lesson_id,
                "is_completed" => true,
                "completed_at" => now()->subDays(9),
            ]);

            if ($reactLessons->count() > 1) {
                LessonProgress::create([
                    "user_id" => $student1->user_id,
                    "lesson_id" => $reactLessons[1]->lesson_id,
                    "is_completed" => true,
                    "completed_at" => now()->subDays(8),
                ]);
            }
        }

        // Create Payments
        Payment::create([
            "user_id" => $student1->user_id,
            "course_id" => $reactCourse->course_id,
            "amount" => 199000,
            "status" => "success",
            "payment_code" => "PAY-" . strtoupper(uniqid()),
            "paid_at" => now()->subDays(10),
        ]);

        Payment::create([
            "user_id" => $student2->user_id,
            "course_id" => $laravelCourse->course_id,
            "amount" => 399000,
            "status" => "success",
            "payment_code" => "PAY-" . strtoupper(uniqid()),
            "paid_at" => now()->subDays(7),
        ]);

        Payment::create([
            "user_id" => $student2->user_id,
            "course_id" => $reactCourse->course_id,
            "amount" => 199000,
            "status" => "pending",
            "payment_code" => "PAY-" . strtoupper(uniqid()),
            "paid_at" => null,
        ]);

        // Create Reviews
        Review::create([
            "user_id" => $student1->user_id,
            "course_id" => $reactCourse->course_id,
            "rating" => 5,
            "comment" =>
                "Amazing course! The instructor explains everything clearly and the examples are practical.",
        ]);

        Review::create([
            "user_id" => $student2->user_id,
            "course_id" => $laravelCourse->course_id,
            "rating" => 4,
            "comment" =>
                "Great content, but I wish there were more advanced topics covered.",
        ]);

        Review::create([
            "user_id" => $student1->user_id,
            "course_id" => $flutterCourse->course_id,
            "rating" => 5,
            "comment" => "Perfect for beginners! Highly recommended.",
        ]);
    }
}
