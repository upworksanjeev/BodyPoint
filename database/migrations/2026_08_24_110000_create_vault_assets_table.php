<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vault_assets', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->text('file_url');
            $table->text('image_url')->nullable();
            $table->string('category');
            $table->string('sub_category')->nullable();
            $table->string('group_name')->nullable();
            $table->string('file_type', 32);
            $table->date('published_at')->nullable();
            $table->json('tags')->nullable();
            $table->string('access_level', 32)->default('open');
            $table->string('pricing_key')->nullable();
            $table->boolean('is_frequently_used')->default(false);
            $table->boolean('is_newly_added')->default(false);
            $table->boolean('is_tour_starter')->default(false);
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['is_active', 'category']);
            $table->index(['is_active', 'file_type']);
            $table->index(['is_active', 'access_level']);
            $table->index(['is_frequently_used', 'is_active']);
            $table->index(['is_newly_added', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vault_assets');
    }
};
