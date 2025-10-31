<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table): void {
            $table->string('status', 20)->default('pending')->after('comment');
            $table->timestamp('updated_at')->nullable()->after('created_at');
            $table->timestamp('approved_at')->nullable()->after('updated_at');
            $table->foreignId('approved_by')->nullable()->after('approved_at')->constrained('users', 'user_id')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table): void {
            $table->dropForeign(['approved_by']);
            $table->dropColumn(['status', 'updated_at', 'approved_at', 'approved_by']);
        });
    }
};
