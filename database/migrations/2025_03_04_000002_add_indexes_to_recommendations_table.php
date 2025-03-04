<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('recommendations', function (Blueprint $table) {
            // Add indexes to frequently queried columns
            $table->index('user_id');
            $table->index('article_id');
            $table->index(['user_id', 'article_id']); // Composite index for queries that filter on both columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recommendations', function (Blueprint $table) {
            // Drop indexes
            $table->dropIndex(['user_id']);
            $table->dropIndex(['article_id']);
            $table->dropIndex(['user_id', 'article_id']);
        });
    }
}; 