<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("enrollments", function (Blueprint $table) {
            $table->id("enrollment_id");
            $table
                ->foreignId("user_id")
                ->constrained("users", "user_id")
                ->onDelete("cascade");
            $table
                ->foreignId("course_id")
                ->constrained("courses", "course_id")
                ->onDelete("cascade");
            $table->timestamp("enrolled_at")->useCurrent();
            $table->boolean("is_completed")->default(false);
            $table->timestamp("completed_at")->nullable();

            // Unique index to ensure a user can only enroll once per course
            $table->unique(["user_id", "course_id"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("enrollments");
    }
};
