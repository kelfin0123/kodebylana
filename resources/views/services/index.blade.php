@extends('layouts.app')

@section('title','Services')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-12">
  <h1 class="text-3xl font-bold">Services</h1>
  <p class="text-slate-600 dark:text-slate-300">Paket layanan pengembangan yang fleksibel.</p>

  @if($services->isEmpty())
    <div class="mt-6 p-6 border rounded-xl text-center text-slate-500 dark:border-slate-800">
      Belum ada layanan aktif.
    </div>
  @else
    <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
      @foreach($services as $s)
        <div class="p-5 border rounded-xl dark:border-slate-800 hover:shadow-lg transition">
          <div class="flex items-center gap-3">
            <div class="text-2xl">{{ $s->icon ?: '🧰' }}</div>
            <div>
              <div class="text-xs text-slate-500">{{ $s->category ?? 'General' }}</div>
              <h3 class="font-semibold text-lg">{{ $s->name }}</h3>
            </div>
          </div>

          @if($s->short_description)
            <p class="mt-3 text-sm text-slate-600 dark:text-slate-300">
              {{ $s->short_description }}
            </p>
          @endif

          @if(!empty($s->features))
            <ul class="mt-4 space-y-1 text-sm">
              @foreach($s->features as $f)
                <li class="flex items-center gap-2">
                  <span>✅</span>
                  <span>{{ $f }}</span>
                </li>
              @endforeach
            </ul>
          @endif

          <div class="mt-4 flex items-end justify-between">
            <div class="text-indigo-600 font-semibold">
              @if($s->price_monthly_label) <div>{{ $s->price_monthly_label }}</div> @endif
              @if($s->price_yearly_label)  <div class="text-sm text-slate-500 line-through/0">{{ $s->price_yearly_label }}</div> @endif
            </div>
            <a href="{{ route('contact') }}"
               class="px-4 py-2 rounded-lg border dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800 transition">
              Konsultasi
            </a>
          </div>
        </div>
      @endforeach
    </div>
  @endif
</div>
@endsection
