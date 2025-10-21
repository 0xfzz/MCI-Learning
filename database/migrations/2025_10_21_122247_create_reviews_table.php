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
        Schema::create("reviews", function (Blueprint $table) {
            $table->id("review_id");
            $table
                ->foreignId("user_id")
                ->constrained("users", "user_id")
                ->onDelete("cascade");
            $table
                ->foreignId("course_id")
                ->constrained("courses", "course_id")
                ->onDelete("cascade");
            $table->integer("rating"); // 1-5
            $table->text("comment")->nullable();
            $table->timestamps();

            // Unique index to ensure a user can only review a course once
            $table->unique(["user_id", "course_id"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("reviews");
    }
};
