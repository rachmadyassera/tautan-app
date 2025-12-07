<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('links', function (Blueprint $table) {
            // Default false artinya link biasa
            $table->boolean('is_header')->default(false)->after('url');

            // Kita ubah kolom url & thumbnail jadi nullable (boleh kosong)
            // Karena header tidak butuh URL
            $table->string('url')->nullable()->change();
            $table->string('thumbnail')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('links', function (Blueprint $table) {
            //
        });
    }
};
