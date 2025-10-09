<?php

namespace Database\Seeders;

use App\Models\NavItem;
use Illuminate\Database\Seeder;

class NavItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['label'=>'Projects','position'=>'header','link_type'=>'route','route_name'=>'projects.index','order'=>10,'is_active'=>true],
            ['label'=>'Services','position'=>'header','link_type'=>'route','route_name'=>'services.index','order'=>20,'is_active'=>true],
            ['label'=>'Testimonials','position'=>'header','link_type'=>'route','route_name'=>'testimonials.index','order'=>30,'is_active'=>true],
            ['label'=>'Blog','position'=>'header','link_type'=>'route','route_name'=>'blog.index','order'=>40,'is_active'=>true],
            ['label'=>'About','position'=>'header','link_type'=>'route','route_name'=>'about','order'=>50,'is_active'=>true],
            ['label'=>'Contact','position'=>'header','link_type'=>'route','route_name'=>'contact','order'=>60,'is_active'=>true],
        ];

        foreach ($items as $data) {
            NavItem::firstOrCreate(
                ['label'=>$data['label'], 'position'=>$data['position']],
                $data
            );
        }
    }
}
