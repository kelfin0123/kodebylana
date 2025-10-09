<?php
// app/Models/Testimonial.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Testimonial extends Model
{
    protected $fillable = [
        'name','role','company','link','photo',
        'rating','content','project_title',
        'is_published','published_at',
    ];

    protected $casts = [
        'is_published' => 'bool',
        'rating'       => 'int',
        'published_at' => 'datetime',
    ];

    // Scope yang cuma ambil yang dipublish
    public function scopePublished(Builder $q): Builder
    {
        return $q->where('is_published', true);
    }
}
