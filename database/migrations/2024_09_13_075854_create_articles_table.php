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
        // Create the 'articles' table if it doesn't already exist
        if (!Schema::hasTable('articles')) {
            Schema::create('articles', function (Blueprint $table) {
                $table->id();
                $table->string('author')->nullable();
                $table->string('title');
                $table->text('description')->nullable();
                $table->string('url')->unique();  // Ensure URL is unique
                $table->string('urlToImage')->nullable();
                $table->timestamp('publishedAt')->nullable();
                $table->longText('content')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the 'articles' table if it exists
        if (Schema::hasTable('articles')) {
            Schema::dropIfExists('articles');
        }
    }
};
