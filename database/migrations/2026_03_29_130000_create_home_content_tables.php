<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('home_slides')) {
            Schema::create('home_slides', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('highlight_text')->nullable();
                $table->text('description');
                $table->string('primary_label')->nullable();
                $table->string('primary_url')->nullable();
                $table->string('secondary_label')->nullable();
                $table->string('secondary_url')->nullable();
                $table->unsignedInteger('sort_order')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('process_steps')) {
            Schema::create('process_steps', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->text('description');
                $table->string('icon_class')->default('bx bxs-wrench');
                $table->unsignedInteger('sort_order')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('why_us_items')) {
            Schema::create('why_us_items', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->text('description');
                $table->string('icon_class')->default('bx bx-box');
                $table->unsignedInteger('sort_order')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('work_items')) {
            Schema::create('work_items', function (Blueprint $table) {
                $table->id();
                $table->string('title')->nullable();
                $table->string('image_path');
                $table->string('link_url')->nullable();
                $table->string('filter_classes')->nullable();
                $table->string('column_class')->default('col-sm-6 col-lg-3');
                $table->unsignedInteger('sort_order')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('faq_items')) {
            Schema::create('faq_items', function (Blueprint $table) {
                $table->id();
                $table->string('question');
                $table->text('answer');
                $table->unsignedInteger('sort_order')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('faq_items');
        Schema::dropIfExists('work_items');
        Schema::dropIfExists('why_us_items');
        Schema::dropIfExists('process_steps');
        Schema::dropIfExists('home_slides');
    }
};
