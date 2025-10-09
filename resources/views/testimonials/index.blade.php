@extends('layouts.app')

@section('title', 'Testimonials')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-14">
  {{-- Header --}}
  <header class="text-center">
    <h1 class="text-3xl sm:text-4xl font-extrabold">Testimonials</h1>
    <p class="mt-2 text-slate-600 dark:text-slate-300">
      Apa kata klien tentang KodeByLana.
    </p>
  </header>

  @php
    // Helper kecil untuk foto yang aman
    $photoUrl = function ($path) {
        if (blank($path)) return null;
        if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://', '/storage/'])) return $path;
        return \Illuminate\Support\Facades\Storage::disk('public')->url($path);
    };
  @endphp

  @if(($testimonials ?? collect())->count())
    <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
      @foreach($testimonials as $t)
        @php
          $img = $photoUrl($t->photo ?? null);
          $initial = strtoupper(mb_substr($t->name ?? 'U', 0, 1));
          $hasRating = isset($t->rating) && is_numeric($t->rating);
          $rating = $hasRating ? max(0, min(5, (int)$t->rating)) : null;
        @endphp

        <article class="rounded-2xl border border-slate-200/70 dark:border-slate-800/70 bg-white/70 dark:bg-slate-900/50 backdrop-blur p-5 shadow-sm">
          <div class="flex items-center gap-4">
            @if($img)
              <img src="{{ $img }}" alt="{{ $t->name ?? 'Client photo' }}" class="w-12 h-12 rounded-full object-cover">
            @else
              <div class="w-12 h-12 rounded-full bg-slate-200 dark:bg-slate-800 grid place-content-center text-slate-700 dark:text-slate-200 font-semibold">
                {{ $initial }}
              </div>
            @endif {{-- <- perbaiki: jangan ada '>' setelah @endif --}}
            <div class="min-w-0">
              <div class="font-semibold truncate">{{ $t->name }}</div>

              <div class="text-xs text-slate-500 flex items-center gap-1">
                @if(!empty($t->role))
                  <span class="truncate">{{ $t->role }}</span>
                @endif
                @if(!empty($t->company))
                  <span>&middot;</span>
                  @if(!empty($t->link))
                    <a href="{{ $t->link }}" target="_blank" rel="noopener" class="truncate hover:underline">{{ $t->company }}</a>
                  @else
                    <span class="truncate">{{ $t->company }}</span>
                  @endif
                @endif
              </div>

              @if($rating !== null)
                <div class="mt-1 flex items-center gap-0.5" aria-label="Rating {{ $rating }} of 5">
                  @for($i=1;$i<=5;$i++)
                    <svg class="h-4 w-4 {{ $i <= $rating ? 'text-amber-500' : 'text-slate-300 dark:text-slate-700' }}" viewBox="0 0 20 20" fill="currentColor">
                      <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.802 2.036a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.802-2.036a1 1 0 00-1.175 0l-2.802 2.036c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81H7.03a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                  @endfor
                </div>
              @endif
            </div>
          </div>

          <p class="mt-4 text-slate-700 dark:text-slate-300 leading-relaxed">
            <span class="text-slate-400">“</span>{{ $t->content }}<span class="text-slate-400">”</span>
          </p>

          @if(!empty($t->project_title) || !empty($t->created_at))
            <div class="mt-4 flex items-center justify-between text-xs text-slate-500">
              <div class="truncate">
                @if(!empty($t->project_title))
                  <span class="px-2 py-1 rounded-lg bg-slate-100 dark:bg-slate-800">{{ $t->project_title }}</span>
                @endif
              </div>
              @if(!empty($t->created_at))
                <time datetime="{{ $t->created_at->toDateString() }}">
                  {{ $t->created_at->format('M Y') }}
                </time>
              @endif
            </div>
          @endif
        </article>
      @endforeach
    </div>

    {{-- Pagination --}}
    <div class="mt-8">{{ $testimonials->withQueryString()->links() }}</div>
  @else
    <div class="mt-10 p-10 text-center rounded-2xl border border-dashed dark:border-slate-800">
      <div class="text-slate-600 dark:text-slate-300">Belum ada testimonial.</div>
      <a href="{{ route('contact') }}" class="mt-3 inline-flex items-center gap-2 px-4 py-2 rounded-xl border dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800 transition">
        Tinggalkan pesan
        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M2.01 21 23 12 2.01 3 2 10l15 2-15 2 .01 7Z"/></svg>
      </a>
    </div>
  @endif
</div>
@endsection
