<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Testimonial;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        Testimonial::updateOrCreate(
            ['email' => 'raka@example.com'], // key unik kalau mau
            [
                'name'          => 'Raka Putra',
                'role'          => 'CTO',
                'company'       => 'Nusantara Tech',
                'link'          => 'https://nusantaratech.example',
                'rating'        => 5,
                'content'       => 'Kerja rapi, komunikasi cepat, hasil melebihi ekspektasi.',
                'project_title' => 'Company Profile + Blog',
                'is_published'  => true,
                'published_at'  => now(),
            ]
        );
    }
}
