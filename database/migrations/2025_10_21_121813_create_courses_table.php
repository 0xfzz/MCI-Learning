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
        Schema::create("courses", function (Blueprint $table) {
            $table->id("course_id");
            $table
                ->foreignId("instructor_id")
                ->constrained("users", "user_id")
                ->onDelete("cascade");
            $table
                ->foreignId("category_id")
                ->nullable()
                ->constrained("categories", "category_id")
                ->onDelete("set null");
            $table->string("title");
            $table->text("description")->nullable();
            $table->string("thumbnail")->nullable();
            $table->string("level")->nullable(); // beginner, intermediate, advanced
            $table->integer("price")->default(0);
            $table->integer("discount_price")->nullable();
            $table->boolean("is_paid")->default(false);
            $table->string("whatsapp_group")->nullable();
            $table->string("source_code_link")->nullable();
            $table->string("status")->default("draft"); // draft, published
            $table->timestamp("created_at")->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("courses");
    }
};
