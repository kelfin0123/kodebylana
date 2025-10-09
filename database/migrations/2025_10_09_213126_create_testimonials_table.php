<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('testimonials', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('role')->nullable();
            $t->string('company')->nullable();
            $t->string('link')->nullable();         // url company/portfolio
            $t->string('photo')->nullable();        // path di storage/app/public
            $t->tinyInteger('rating')->nullable();  // 0–5
            $t->string('project_title')->nullable();
            $t->text('content');                    // isi testimoni
            $t->boolean('is_published')->default(true)->index();
            $t->timestamp('published_at')->nullable()->index();
            $t->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('testimonials'); }
};
