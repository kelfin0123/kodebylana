<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Storage;

class AdminProjectController extends Controller
{
    public function store(Request $request)
    {
        // Validasi input
        $data = $request->validate([
            'title'        => ['required', 'string', 'max:255'],
            'description'  => ['nullable', 'string'],
            'category'     => ['required', 'string', 'max:100'],
            'image'        => ['nullable', 'image', 'max:2048'],
            'demo_url'     => ['nullable', 'url'],
            'github_url'   => ['nullable', 'url'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        // Buat slug unik
        $data['slug'] = Str::slug($data['title']).'-'.Str::random(5);

        // Upload & resize gambar jika ada
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('projects', 'public');

            // Pastikan file tersimpan sebelum resize
            if (Storage::disk('public')->exists($path)) {
                $image = Image::read(storage_path("app/public/{$path}"))
                    ->scaleDown(width: 1200); // resize hanya jika >1200px
                $image->save();
            }

            $data['image'] = $path;
        }

        // Simpan ke database
        Project::create($data);

        return redirect()
            ->route('admin.projects.index')
            ->with('ok', 'Project berhasil dibuat.');
    }
}
