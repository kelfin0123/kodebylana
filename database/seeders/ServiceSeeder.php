<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        Service::updateOrCreate(
            ['slug' => 'landing-page'],
            [
                'name' => 'Landing Page',
                'category' => 'Web',
                'icon' => '🚀',
                'short_description' => 'Landing page cepat, cantik, dan SEO-friendly.',
                'features' => ['Tailwind CSS','SEO dasar','Deploy gratis Netlify'],
                'price_monthly' => 0,
                'price_yearly'  => 0,
                'is_active' => true,
                'sort_order' => 1,
            ]
        );

        Service::updateOrCreate(
            ['slug' => 'company-profile'],
            [
                'name' => 'Company Profile',
                'category' => 'Web',
                'icon' => '🏢',
                'short_description' => 'Website profil perusahaan dengan CMS sederhana.',
                'features' => ['Laravel','Panel Admin','Form kontak'],
                'price_monthly' => 0,
                'price_yearly'  => 0,
                'is_active' => true,
                'sort_order' => 2,
            ]
        );
    }
}
