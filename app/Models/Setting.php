<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'site_name', 'logo_light', 'logo_dark', 'primary_color', 'socials',
    ];

    protected $casts = [
        'socials' => 'array',
    ];
}
