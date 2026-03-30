<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('home_slides', function (Blueprint $table) {
            if (Schema::hasColumn('home_slides', 'background_class')) {
                $table->dropColumn('background_class');
            }
        });
    }

    public function down(): void
    {
        Schema::table('home_slides', function (Blueprint $table) {
            if (! Schema::hasColumn('home_slides', 'background_class')) {
                $table->string('background_class')->default('banner-img-one')->after('secondary_url');
            }
        });
    }
};
