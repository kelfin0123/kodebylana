<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // Tambahkan hanya jika belum ada (aman untuk SQLite/MySQL)
            if (!Schema::hasColumn('projects', 'image_url')) {
                $table->string('image_url')->nullable();      // cover image path/url
            }
            if (!Schema::hasColumn('projects', 'description')) {
                $table->text('description')->nullable();
            }
            if (!Schema::hasColumn('projects', 'demo_url')) {
                $table->string('demo_url')->nullable();
            }
            if (!Schema::hasColumn('projects', 'github_url')) {
                $table->string('github_url')->nullable();
            }
            if (!Schema::hasColumn('projects', 'is_published')) {
                $table->boolean('is_published')->default(false);
            }
            if (!Schema::hasColumn('projects', 'published_at')) {
                $table->timestamp('published_at')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // SQLite tidak mendukung drop column lama, jadi biarkan kosong
            // atau kondisional kalau DB kamu MySQL:
            // $table->dropColumn(['image_url','description','demo_url','github_url','is_published','published_at']);
        });
    }
};
