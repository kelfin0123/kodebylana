<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{Cache, Schema};
use App\Models\{Project, Service, Testimonial, BlogPost, Contact};

class DashboardController extends Controller
{
    public function index()
    {
        $has = fn (string $t) => Schema::hasTable($t);

        $stats = [
            'projects'        => $has('projects')      ? Cache::remember('stats.projects', 60, fn () => Project::count()) : 0,
            'services'        => $has('services')      ? Cache::remember('stats.services', 60, fn () => Service::count()) : 0,
            'testimonials'    => $has('testimonials')  ? Cache::remember('stats.testimonials', 60, fn () => Testimonial::count()) : 0,
            'blog_posts'      => $has('blog_posts')    ? Cache::remember('stats.blog_posts', 60, fn () => BlogPost::count()) : 0,
            'unread_contacts' => $has('contacts')      ? Cache::remember('stats.contacts.unread', 60, fn () => Contact::where('is_read', false)->count()) : 0,
        ];

        $recentProjects = $has('projects')   ? Project::latest()->take(5)->get(['id','title','created_at']) : collect();
        $recentPosts    = $has('blog_posts') ? BlogPost::latest('published_at')->take(5)->get(['id','title','published_at']) : collect();
        $recentContacts = $has('contacts')   ? Contact::latest()->take(5)->get(['id','name','email','subject','is_read','created_at']) : collect();

        return view('admin.dashboard', compact('stats','recentProjects','recentPosts','recentContacts'));
    }
}
