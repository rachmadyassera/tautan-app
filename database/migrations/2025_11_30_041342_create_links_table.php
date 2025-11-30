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
        Schema::create('links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->constrained()->onDelete('cascade');
            $table->string('title'); // Teks tombol: "WhatsApp Saya"
            $table->string('url');   // Link: "wa.me/628..."
            $table->boolean('is_active')->default(true); // Bisa dimatikan tanpa dihapus
            $table->integer('position')->default(0); // Untuk urutan link
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('links');
    }
};
