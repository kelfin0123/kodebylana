<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('slug')->unique();
    $table->string('category')->nullable();
    $table->string('icon')->nullable();
    $table->text('short_description')->nullable();
    $table->json('features')->nullable();
    $table->unsignedBigInteger('price_monthly')->nullable();
    $table->unsignedBigInteger('price_yearly')->nullable();
    $table->boolean('is_active')->default(true);
    $table->integer('sort_order')->default(0);
    $table->timestamps();
});

    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
