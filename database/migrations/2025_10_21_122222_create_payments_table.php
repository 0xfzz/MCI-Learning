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
        Schema::create("payments", function (Blueprint $table) {
            $table->id("payment_id");
            $table
                ->foreignId("user_id")
                ->constrained("users", "user_id")
                ->onDelete("cascade");
            $table
                ->foreignId("course_id")
                ->constrained("courses", "course_id")
                ->onDelete("cascade");
            $table->integer("amount");
            $table->string("status")->default("pending"); // pending, success, failed
            $table->string("bukti_transfer")->nullable(); // path/url to transfer receipt image
            $table->timestamp("paid_at")->nullable();
            $table->timestamp("created_at")->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("payments");
    }
};
