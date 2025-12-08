<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->string('soc_instagram')->nullable()->after('theme');
            $table->string('soc_tiktok')->nullable()->after('soc_instagram');
            $table->string('soc_twitter')->nullable()->after('soc_tiktok');
            $table->string('soc_facebook')->nullable()->after('soc_twitter');
            $table->string('soc_whatsapp')->nullable()->after('soc_facebook');
            $table->string('soc_youtube')->nullable()->after('soc_whatsapp');
        });
    }

    public function down()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn(['soc_instagram', 'soc_tiktok', 'soc_twitter', 'soc_facebook', 'soc_whatsapp', 'soc_youtube']);
        });
    }
};
