@extends('layouts.app')

@section('title', $project->title . ' — Projects')

@section('content')
@php
    // Buat URL gambar yang aman (relatif -> /storage/..., kosong -> placeholder)
    $img = $project->image_url;
    if (blank($img)) {
        $img = asset('images/placeholder.png'); // siapkan /public/images/placeholder.png
    } elseif (!\Illuminate\Support\Str::startsWith($img, ['http://', 'https://', '/storage/'])) {
        $img = \Illuminate\Support\Facades\Storage::disk('public')->url($img);
    }
@endphp

{{-- Kontainer diperkecil dari max-w-5xl -> max-w-4xl --}}
<div class="max-w-4xl mx-auto px-4 py-10">
    {{-- Header --}}
    <div class="mb-6">
        <a href="{{ route('projects.index') }}"
           class="text-sm text-slate-500 hover:underline">&larr; Kembali ke Projects</a>
        <h1 class="mt-2 text-3xl font-bold">{{ $project->title }}</h1>
        <div class="mt-1 text-sm text-slate-500 flex items-center gap-2">
            <span class="inline-flex items-center rounded bg-slate-100 px-2 py-0.5 text-slate-700 dark:bg-slate-800 dark:text-slate-300">
                {{ $project->category ?? 'General' }}
            </span>
            @if($project->published_at)
                <span>•</span>
                <time datetime="{{ $project->published_at->toDateString() }}">
                    {{ $project->published_at->format('d M Y') }}
                </time>
            @endif
        </div>
    </div>

    {{-- Cover: dibuat sedikit lebih pendek + lazy load --}}
    <div class="aspect-[21/9] md:aspect-[16/9] w-full overflow-hidden rounded-xl border dark:border-slate-800 mb-6">
        <img
            src="{{ $img }}"
            alt="{{ $project->title }}"
            class="h-full w-full object-cover"
            loading="lazy"
            decoding="async"
        />
    </div>

    {{-- Action links --}}
    <div class="flex gap-3 mb-6">
        @if($project->demo_url)
            <a href="{{ $project->demo_url }}" target="_blank" rel="noopener"
               class="px-4 py-2 rounded-lg bg-indigo-600 text-white hover:opacity-90 transition">
                Lihat Demo
            </a>
        @endif
        @if($project->github_url)
            <a href="{{ $project->github_url }}" target="_blank" rel="noopener"
               class="px-4 py-2 rounded-lg border dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800 transition">
                Source di GitHub
            </a>
        @endif
    </div>

    {{-- Description --}}
    @if(filled($project->description))
        <article class="prose dark:prose-invert max-w-none">
            {!! nl2br(e($project->description)) !!}
        </article>
    @else
        <p class="text-slate-500">Tidak ada deskripsi.</p>
    @endif

    {{-- Related projects --}}
    @if(isset($related) && $related->isNotEmpty())
        <hr class="my-10 border-slate-200 dark:border-slate-800">
        <h2 class="text-xl font-semibold mb-4">Project Terkait</h2>
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($related as $r)
                @php
                    $rImg = $r->image_url;
                    if (blank($rImg)) {
                        $rImg = asset('images/placeholder.png');
                    } elseif (!\Illuminate\Support\Str::startsWith($rImg, ['http://','https://','/storage/'])) {
                        $rImg = \Illuminate\Support\Facades\Storage::disk('public')->url($rImg);
                    }
                @endphp
                <a href="{{ route('projects.show', $r) }}"
                   class="group block p-4 border rounded-xl dark:border-slate-800 hover:shadow-lg hover:-translate-y-0.5 transition">
                    {{-- Thumbnail diperkecil dari h-40 -> h-32/36 + lazy load --}}
                    <img
                        src="{{ $rImg }}"
                        alt="{{ $r->title }}"
                        class="w-full h-32 sm:h-36 object-cover rounded-lg mb-3"
                        loading="lazy"
                        decoding="async"
                    />
                    <div class="text-xs text-slate-500 mb-1">{{ $r->category ?? 'General' }}</div>
                    <h3 class="font-semibold group-hover:text-indigo-600 transition">{{ $r->title }}</h3>
                </a>
            @endforeach
        </div>
    @endif
</div>
@endsection
