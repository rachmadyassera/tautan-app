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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title'); // Judul halaman, misal: "Link Bio Saya"
            $table->string('slug')->unique()->index(); // URL unik: biolink.com/slug
            $table->text('bio_text')->nullable();
            $table->string('avatar_path')->nullable();
            $table->string('theme')->default('light'); // Default tema putih
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
