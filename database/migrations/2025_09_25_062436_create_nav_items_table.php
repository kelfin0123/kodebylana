<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('nav_items', function (Blueprint $table) {
            $table->id();
            $table->string('label', 100);
            $table->string('position', 20);              // header | footer
            $table->string('link_type', 10);             // route | url
            $table->string('route_name')->nullable();    // bila link_type = route
            $table->json('params')->nullable();          // route params (akan di-cast array)
            $table->string('url')->nullable();           // bila link_type = url

            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('nav_items')
                ->nullOnDelete();                        // hapus parent → child.parent_id = null

            $table->integer('order')->default(0);
            $table->boolean('open_new_tab')->default(false);
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nav_items');
    }
};
