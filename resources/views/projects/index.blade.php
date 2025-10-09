@extends('layouts.app')

@section('title','Projects')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-12">

  <h1 class="text-3xl font-bold">Projects</h1>
  <p class="text-slate-600 dark:text-slate-300">Koleksi karya terbaru dan terbaik.</p>

  {{-- Filter --}}
  <form action="{{ route('projects.index') }}" method="get"
        class="flex flex-wrap items-center gap-3 mt-5">
    <select name="category" class="border rounded-md px-3 py-2 dark:bg-slate-900">
      <option value="">Semua Kategori</option>
      @foreach($categories as $cat)
        <option value="{{ $cat }}" @selected(request('category') === $cat)>{{ $cat }}</option>
      @endforeach
    </select>

    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul/deskripsi…"
           class="border rounded-md px-3 py-2 w-64 dark:bg-slate-900">

    <button class="px-4 py-2 rounded-md border dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800 transition">
      Filter
    </button>

    @if(request('category') || request('q'))
      <a href="{{ route('projects.index') }}"
         class="px-3 py-2 text-sm rounded-md hover:underline">
        Reset
      </a>
    @endif
  </form>

  {{-- Grid --}}
  <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3" data-aos="fade-up">
    @forelse ($projects as $p)
      <a href="{{ route('projects.show', $p) }}"
         class="group block p-4 border rounded-xl dark:border-slate-800 hover:shadow-lg hover:-translate-y-0.5 transition">
        
        {{-- Gambar: gunakan accessor cover_url + fallback placeholder --}}
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
    @empty
      <div class="col-span-full">
        <div class="p-6 border rounded-xl text-center text-slate-500 dark:border-slate-800">
          Belum ada project. Tambahkan dari Admin untuk tampil di sini.
        </div>
      </div>
    @endforelse
  </div>

  {{-- Pagination (tetap bawa query filter) --}}
  <div class="mt-8">
    {{ $projects->withQueryString()->links() }}
  </div>
</div>
@endsection
