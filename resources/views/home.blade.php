@extends('layouts.app')

@section('title','Welcome to KodeByLana')

@section('content')
  {{-- Hero --}}
  <section class="max-w-6xl mx-auto px-4 py-16 text-center">
    <h1 class="text-3xl sm:text-4xl font-extrabold">
      Welcome to
      <span class="bg-gradient-to-r from-indigo-500 via-fuchsia-500 to-cyan-400 bg-clip-text text-transparent">
        KodeByLana
      </span>
    </h1>
    <p class="mt-2 text-slate-600 dark:text-slate-300">
      Featured projects crafted with Laravel & Tailwind
    </p>

    <div class="mt-6 flex items-center justify-center gap-3">
      <a href="{{ route('projects.index') }}"
         class="px-4 py-2 rounded-lg bg-indigo-600 text-white hover:opacity-90 transition">
        Lihat Semua Project
      </a>
      <a href="{{ route('contact') }}"
         class="px-4 py-2 rounded-lg border dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800 transition">
        Kontak Saya
      </a>
    </div>
  </section>

  {{-- Featured Projects --}}
  <section class="max-w-6xl mx-auto px-4 pb-16" data-aos="fade-up">
    <div class="flex items-end justify-between mb-4">
      <h2 class="text-xl font-semibold">Featured Projects</h2>
      <a href="{{ route('projects.index') }}" class="text-sm text-indigo-600 hover:underline">Lihat semua →</a>
    </div>

    @if($projects->isEmpty())
      <div class="p-6 border rounded-xl text-center text-slate-500 dark:border-slate-800">
        Belum ada project. Tambahkan dari Admin untuk tampil di sini.
      </div>
    @else
      <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach($projects as $p)
          <a href="{{ route('projects.show', $p) }}"
             class="group block p-4 border rounded-xl dark:border-slate-800 hover:shadow-lg hover:-translate-y-0.5 transition"
             data-aos="zoom-in" data-aos-delay="{{ $loop->index * 50 }}">
            
            {{-- Gambar: pakai cover_url + fallback placeholder --}}
            <img
              src="{{ $p->cover_url }}"
              alt="{{ $p->title }}"
              loading="lazy"
              class="w-full aspect-[16/9] object-cover rounded-lg mb-3 bg-slate-100"
              onerror="this.onerror=null;this.src='{{ asset('images/placeholder.png') }}';"
            >

            <div class="text-xs text-slate-500 mb-1">{{ $p->category ?? 'General' }}</div>
            <h3 class="font-semibold text-lg group-hover:text-indigo-600 transition">{{ $p->title }}</h3>

            @if($p->description)
              <p class="text-sm text-slate-600 dark:text-slate-300 line-clamp-3 mt-1">
                {{ \Illuminate\Support\Str::limit($p->description, 140) }}
              </p>
            @endif

            <div class="flex gap-3 mt-3 text-sm">
              @if($p->demo_url)
                <a href="{{ $p->demo_url }}" target="_blank" rel="noopener" class="underline">Demo</a>
              @endif
              @if($p->github_url)
                <a href="{{ $p->github_url }}" target="_blank" rel="noopener" class="underline">GitHub</a>
              @endif
            </div>
          </a>
        @endforeach
      </div>
    @endif
  </section>
@endsection
