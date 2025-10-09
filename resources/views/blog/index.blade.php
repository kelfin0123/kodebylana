@extends('layouts.app')

@section('content')
@php use Illuminate\Support\Str; @endphp

<div class="max-w-6xl mx-auto px-4 py-14">
  <header class="flex items-end justify-between">
    <div>
      <h1 class="text-3xl font-bold">Blog</h1>
      <p class="text-slate-600 dark:text-slate-300">Catatan, tips, dan studi kasus.</p>
    </div>
    <form method="GET" action="{{ route('blog.index') }}" class="hidden md:block">
      <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari artikel…"
             class="rounded-xl">
    </form>
  </header>

  @if(($posts ?? collect())->count())
    <div class="grid gap-6 mt-8 md:grid-cols-3">
      @foreach($posts as $post)
        <article class="rounded-2xl border dark:border-slate-800 overflow-hidden hover:-translate-y-1 transition">
          <a href="{{ route('blog.show', $post->slug) }}" class="block">
            @if($post->cover)
              <img src="{{ asset('storage/'.$post->cover) }}" alt="{{ $post->title }}"
                   class="w-full h-40 object-cover">
            @else
              <div class="w-full h-40 bg-slate-200 dark:bg-slate-800"></div>
            @endif
            <div class="p-5">
              <div class="text-xs text-slate-500">
                {{ optional($post->published_at)->format('d M Y') ?? $post->created_at->format('d M Y') }}
              </div>
              <h3 class="mt-1 font-semibold line-clamp-2">{{ $post->title }}</h3>
              <p class="mt-2 text-sm text-slate-600 dark:text-slate-300 line-clamp-2">
                {{ $post->excerpt ? $post->excerpt : Str::limit(strip_tags($post->body ?? ''), 140) }}
              </p>
            </div>
          </a>
        </article>
      @endforeach
    </div>

    @if(method_exists($posts, 'links'))
      <div class="mt-10">{{ $posts->withQueryString()->links() }}</div>
    @endif
  @else
    <div class="mt-10 p-8 text-center rounded-2xl border dark:border-slate-800">
      Belum ada artikel.
    </div>
  @endif
</div>
@endsection
