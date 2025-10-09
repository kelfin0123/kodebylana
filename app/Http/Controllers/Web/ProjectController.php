<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(Request $request): View
    {
        $query = Project::query()
            ->where('is_published', true)
            ->when($request->filled('category'), fn ($q) =>
                $q->where('category', $request->string('category')))
            ->when($request->filled('q'), function ($q) use ($request) {
                $s = $request->string('q');
                $q->where(fn ($x) => $x->where('title', 'like', "%$s%")
                    ->orWhere('description', 'like', "%$s%"));
            });

        $projects   = $query->orderByDesc('published_at')->paginate(9)->withQueryString();
        $categories = Project::whereNotNull('category')
                        ->distinct()->orderBy('category')->pluck('category', 'category');

        return view('projects.index', compact('projects', 'categories'));
    }

    public function show(Project $project): View
    {
        abort_unless($project->is_published, 404);
        $related = Project::where('is_published', true)
            ->where('id', '!=', $project->id)
            ->when($project->category, fn ($q) => $q->where('category', $project->category))
            ->latest('published_at')->limit(3)->get();

        return view('projects.show', compact('project', 'related'));
    }
}
