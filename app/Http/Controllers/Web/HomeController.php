<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\{Project, BlogPost, Service, Testimonial, Setting};
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    public function index()
    {
        $settings     = Schema::hasTable('settings')      ? Setting::first() : null;

        // ambil 6 project publish, aman walau tabel belum ada
        $projects = Schema::hasTable('projects')
    ? Project::query()->where('is_published', true)->latest('published_at')->take(6)->get()
    : collect();


        $posts        = Schema::hasTable('blog_posts')
            ? BlogPost::where('is_published', true)->latest('published_at')->take(3)->get()
            : collect();

        $services     = Schema::hasTable('services')
            ? Service::where('is_active', true)->get()
            : collect();

        $testimonials = Schema::hasTable('testimonials')
            ? Testimonial::where('is_published', true)->latest()->take(10)->get()
            : collect();

        return view('home', compact('settings','projects','posts','services','testimonials'));
    }
}
