<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('public_visits')) {
            Schema::create('public_visits', function (Blueprint $table) {
                $table->id();
                $table->string('ip_address', 45);
                $table->date('visited_on');
                $table->string('user_agent', 500)->nullable();
                $table->timestamps();

                $table->unique(['ip_address', 'visited_on']);
                $table->index('visited_on');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('public_visits');
    }
};
