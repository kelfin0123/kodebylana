<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Project extends Model
{
    protected $fillable = [
        'title','slug','category','description','image_url',
        'demo_url','github_url','is_published','published_at',
    ];

    protected $casts = [
        'is_published' => 'bool',
        'published_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::saving(function (Project $model) {
            if (blank($model->slug) && filled($model->title)) {
                $model->slug = Str::slug($model->title);
            }

            if ($model->is_published && is_null($model->published_at)) {
                $model->published_at = now();
            }
        });
    }

    /**
     * URL aman untuk cover:
     * - bila kosong -> pakai placeholder
     * - bila sudah http/https atau diawali /storage -> kembalikan apa adanya
     * - bila path relatif (projects/xxx.jpg) -> ubah ke /storage/projects/xxx.jpg
     */
    public function getCoverUrlAttribute(): string
    {
        $path = $this->image_url;

        if (blank($path)) {
            return asset('images/placeholder.png'); // siapkan file ini di public/images/placeholder.png
        }

        if (Str::startsWith($path, ['http://', 'https://', '/storage/'])) {
            return $path;
        }

        // contoh: "projects/abc.jpg" => "/storage/projects/abc.jpg"
        return Storage::disk('public')->url($path);
    }
}
