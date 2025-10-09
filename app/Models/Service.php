<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name','slug','category','icon','short_description','features',
        'price_monthly','price_yearly','sort_order','is_active',
    ];

    protected $casts = [
        'is_active' => 'bool',
        'features'  => 'array', // biar TagsInput enak
    ];

    // Scope untuk halaman publik & admin
    public function scopeActive($q)
    {
        return $q->where('is_active', true);
    }

    // Accessor label harga (dipakai di tabel Filament)
    public function getPriceMonthlyLabelAttribute(): string
    {
        return is_numeric($this->price_monthly)
            ? 'Rp ' . number_format((float) $this->price_monthly, 0, ',', '.')
            : '-';
    }

    public function getPriceYearlyLabelAttribute(): string
    {
        return is_numeric($this->price_yearly)
            ? 'Rp ' . number_format((float) $this->price_yearly, 0, ',', '.')
            : '-';
    }
}
