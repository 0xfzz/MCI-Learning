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
        Schema::create("lessons", function (Blueprint $table) {
            $table->id("lesson_id");
            $table
                ->foreignId("course_id")
                ->constrained("courses", "course_id")
                ->onDelete("cascade");
            $table
                ->foreignId("parent_id")
                ->nullable()
                ->constrained("lessons", "lesson_id")
                ->onDelete("cascade");
            $table->string("title");
            $table->string("youtube_link")->nullable();
            $table->string("duration")->nullable();
            $table->integer("order_number");
            $table->boolean("is_section")->default(false); // true = section, false = video lesson
            $table->boolean("is_free")->default(false); // free preview
            $table->timestamp("created_at")->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("lessons");
    }
};
