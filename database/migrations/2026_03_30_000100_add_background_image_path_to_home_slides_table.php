<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('home_slides', function (Blueprint $table) {
            if (! Schema::hasColumn('home_slides', 'background_image_path')) {
                $table->string('background_image_path')->nullable()->after('secondary_url');
            }
        });
    }

    public function down(): void
    {
        Schema::table('home_slides', function (Blueprint $table) {
            if (Schema::hasColumn('home_slides', 'background_image_path')) {
                $table->dropColumn('background_image_path');
            }
        });
    }
};
