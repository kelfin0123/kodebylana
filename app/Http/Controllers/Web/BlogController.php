<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        if (! Schema::hasTable('blog_posts')) {
            return view('blog.index', ['posts' => collect()]);
        }

        $q = $request->string('q');
        $posts = BlogPost::query()
            ->where('is_published', true)
            ->when($q, fn ($qr) =>
                $qr->where(function ($sub) use ($q) {
                    $sub->where('title', 'like', "%{$q}%")
                        ->orWhere('excerpt', 'like', "%{$q}%")
                        ->orWhere('body', 'like', "%{$q}%");
                })
            )
            ->latest('published_at')
            ->latest() // fallback jika published_at null
            ->paginate(9);

        return view('blog.index', compact('posts'));
    }

    public function show(string $slug)
    {
        abort_unless(Schema::hasTable('blog_posts'), 404);

        $post = BlogPost::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        // opsional: post terkait
        $related = BlogPost::where('is_published', true)
            ->where('id', '!=', $post->id)
            ->latest('published_at')->limit(3)->get();

        return view('blog.show', compact('post', 'related'));
    }
}
