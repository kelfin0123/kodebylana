<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NavItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'label',
        'position',
        'link_type',
        'route_name',
        'params',
        'url',
        'parent_id',
        'order',
        'open_new_tab',
        'is_active',
    ];

    protected $casts = [
        'params'       => 'array',
        'open_new_tab' => 'boolean',
        'is_active'    => 'boolean',
    ];

    // Relasi
    public function parent()
    {
        return $this->belongsTo(NavItem::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(NavItem::class, 'parent_id')->orderBy('order');
    }

    // Scopes
    public function scopeActive($q)  { return $q->where('is_active', true); }
    public function scopeHeader($q)  { return $q->where('position', 'header'); }
    public function scopeFooter($q)  { return $q->where('position', 'footer'); }

    // Helper URL untuk Blade
    public function getHrefAttribute(): string
    {
        if ($this->link_type === 'url' && $this->url) {
            return $this->url;
        }

        if ($this->link_type === 'route' && $this->route_name) {
            try {
                return route($this->route_name, $this->params ?? []);
            } catch (\Throwable $e) {
                return '#';
            }
        }

        return '#';
    }
}
