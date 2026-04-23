<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('home_slides', function (Blueprint $table) {
            if (! Schema::hasColumn('home_slides', 'hook_message')) {
                $table->string('hook_message')->nullable()->after('highlight_text');
            }

            if (! Schema::hasColumn('home_slides', 'hook_highlight_text')) {
                $table->string('hook_highlight_text')->nullable()->after('hook_message');
            }
        });
    }

    public function down(): void
    {
        Schema::table('home_slides', function (Blueprint $table) {
            if (Schema::hasColumn('home_slides', 'hook_highlight_text')) {
                $table->dropColumn('hook_highlight_text');
            }

            if (Schema::hasColumn('home_slides', 'hook_message')) {
                $table->dropColumn('hook_message');
            }
        });
    }
};
