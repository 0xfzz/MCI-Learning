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
        Schema::create("lesson_progress", function (Blueprint $table) {
            $table->id("progress_id");
            $table
                ->foreignId("user_id")
                ->constrained("users", "user_id")
                ->onDelete("cascade");
            $table
                ->foreignId("lesson_id")
                ->constrained("lessons", "lesson_id")
                ->onDelete("cascade");
            $table->boolean("is_completed")->default(false);
            $table->timestamp("completed_at")->nullable();

            // Unique index to ensure a user can only have one progress record per lesson
            $table->unique(["user_id", "lesson_id"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("lesson_progress");
    }
};
