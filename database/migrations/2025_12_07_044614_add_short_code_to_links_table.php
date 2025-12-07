<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('links', function (Blueprint $table) {
            // Kita buat unique agar tidak ada kode kembar
            // Kita buat nullable dulu biar data lama tidak error, nanti kita isi
            $table->string('short_code', 10)->unique()->nullable()->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('links', function (Blueprint $table) {
            $table->dropColumn('short_code');
        });
    }
};
