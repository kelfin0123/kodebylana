@extends('layouts.app')

@section('title', 'About')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-14 space-y-14">

  {{-- HERO --}}
  <section class="grid md:grid-cols-2 gap-10 items-center">
    <div>
      <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700 dark:bg-indigo-950/40 dark:text-indigo-300">
        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2a10 10 0 1 0 10 10A10.011 10.011 0 0 0 12 2Zm0 18a8 8 0 1 1 8-8 8.009 8.009 0 0 1-8 8Z"/><path d="M11 6h2v7h-2zm0 9h2v2h-2z"/></svg>
        Available for freelance
      </span>

      <h1 class="mt-3 text-4xl sm:text-5xl font-extrabold leading-tight">
        Hi, I’m <span class="bg-gradient-to-r from-indigo-600 via-fuchsia-500 to-cyan-500 bg-clip-text text-transparent">Lana</span> —
        Laravel/Tailwind developer who ships fast & clean.
      </h1>

      <p class="mt-4 text-slate-600 dark:text-slate-300">
        I craft robust backends and delightful UIs using Laravel, Blade/Livewire, and Tailwind. My north star:
        <em>clear code, smooth UX, measurable results</em>.
      </p>

      <div class="mt-6 flex flex-wrap items-center gap-3">
        <a href="{{ route('contact') }}"
           class="inline-flex items-center gap-2 rounded-xl px-5 py-3 font-medium text-white
                  bg-gradient-to-r from-indigo-600 via-fuchsia-500 to-cyan-500 hover:opacity-95 shadow-sm hover:shadow transition">
          Let’s work together
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M2.01 21 23 12 2.01 3 2 10l15 2-15 2 .01 7Z"/></svg>
        </a>

        <a href="{{ asset('cv.pdf') }}" target="_blank"
           class="rounded-xl px-5 py-3 font-medium border border-slate-200 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800 transition">
          Download CV
        </a>
      </div>
    </div>

    <div class="relative">
      <div class="aspect-[4/3] rounded-3xl overflow-hidden ring-1 ring-slate-200/80 dark:ring-slate-800/80 shadow-sm">
        <img
          src="https://images.unsplash.com/photo-1526378722484-bd91ca387e72?q=80&w=1200&auto=format&fit=crop"
          alt="Workspace"
          class="w-full h-full object-cover">
      </div>

      {{-- quick stats card --}}
      <div class="absolute -bottom-6 -left-6 bg-white/80 dark:bg-slate-900/80 backdrop-blur rounded-2xl px-4 py-3 shadow ring-1 ring-slate-200 dark:ring-slate-800">
        <div class="flex items-center gap-4">
          <div>
            <div class="text-2xl font-extrabold">40+</div>
            <div class="text-xs text-slate-500">projects shipped</div>
          </div>
          <div class="h-8 w-px bg-slate-200 dark:bg-slate-800"></div>
          <div>
            <div class="text-2xl font-extrabold">5<sup class="text-xs">yrs</sup></div>
            <div class="text-xs text-slate-500">experience</div>
          </div>
          <div class="h-8 w-px bg-slate-200 dark:bg-slate-800"></div>
          <div>
            <div class="text-2xl font-extrabold">98%</div>
            <div class="text-xs text-slate-500">happy clients</div>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- SKILLS + TOOLS --}}
  <section class="grid md:grid-cols-2 gap-10">
    <div>
      <h2 class="text-xl font-semibold">Core Skills</h2>
      <p class="mt-1 text-slate-600 dark:text-slate-300">What I use daily to deliver value.</p>

      <div class="mt-4 grid grid-cols-2 sm:grid-cols-3 gap-2">
        @foreach(['Laravel','Blade','Livewire','Tailwind CSS','Alpine.js','MySQL','SQLite','Redis','REST API'] as $s)
          <span class="px-3 py-2 rounded-xl text-sm text-slate-700 dark:text-slate-200 bg-slate-100/80 dark:bg-slate-800/60 border border-slate-200/70 dark:border-slate-700/70">
            {{ $s }}
          </span>
        @endforeach
      </div>

      {{-- mini meters (pure CSS) --}}
      <div class="mt-6 space-y-3">
        @php
          $meters = [
            ['Laravel', 95], ['Tailwind', 92], ['Livewire/Blade', 90], ['DB/SQL', 88],
          ];
        @endphp
        @foreach($meters as [$label,$val])
          <div>
            <div class="flex justify-between text-xs mb-1"><span>{{ $label }}</span><span>{{ $val }}%</span></div>
            <div class="h-2 rounded-full bg-slate-200 dark:bg-slate-800 overflow-hidden">
              <div class="h-2 rounded-full bg-gradient-to-r from-indigo-600 via-fuchsia-500 to-cyan-500" style="width: {{ $val }}%"></div>
            </div>
          </div>
        @endforeach
      </div>
    </div>

    <div>
      <h2 class="text-xl font-semibold">Tooling I love</h2>
      <p class="mt-1 text-slate-600 dark:text-slate-300">Reliable tools = faster delivery.</p>

      <div class="mt-4 grid grid-cols-2 sm:grid-cols-3 gap-2">
        @foreach(['VSCode','Docker','Postman','Figma','GitHub','Linux'] as $t)
          <span class="px-3 py-2 rounded-xl text-sm border border-slate-200/70 dark:border-slate-700/70 hover:bg-slate-50 dark:hover:bg-slate-800 transition">
            {{ $t }}
          </span>
        @endforeach
      </div>

      <div class="mt-6 rounded-2xl p-5 bg-gradient-to-br from-indigo-50 to-cyan-50 dark:from-indigo-950/30 dark:to-cyan-950/20 ring-1 ring-slate-200 dark:ring-slate-800">
        <h3 class="font-semibold mb-1">What you get working with me</h3>
        <ul class="text-sm text-slate-600 dark:text-slate-300 space-y-1.5">
          <li>• Clean, maintainable Laravel code</li>
          <li>• Pixel-perfect Tailwind UI, dark-mode ready</li>
          <li>• Clear milestones & frequent updates</li>
          <li>• Performance & SEO awareness</li>
        </ul>
      </div>
    </div>
  </section>

  {{-- TIMELINE / EXPERIENCE --}}
  <section>
    <h2 class="text-xl font-semibold">Experience</h2>
    <div class="mt-5 relative">
      <div class="absolute left-3 top-0 bottom-0 w-px bg-slate-200 dark:bg-slate-800"></div>

      @php
        $xp = [
          ['title'=>'Senior Laravel Developer', 'company'=>'Freelance / Remote', 'time'=>'2023 — Now', 'desc'=>'Designing APIs, multi-tenant dashboards, and real-time features with Livewire.'],
          ['title'=>'Full-stack Developer', 'company'=>'Startup Studio', 'time'=>'2021 — 2023', 'desc'=>'Built internal tools, marketing sites, and payment integrations.'],
          ['title'=>'Web Developer', 'company'=>'Agency', 'time'=>'2019 — 2021', 'desc'=>'Delivered landing pages, company profiles, and CMS with Laravel.'],
        ];
      @endphp

      <div class="space-y-6">
        @foreach($xp as $i)
          <div class="pl-10 relative">
            <span class="absolute left-0 h-6 w-6 rounded-full bg-white dark:bg-slate-900 ring-2 ring-indigo-500"></span>
            <div class="rounded-2xl ring-1 ring-slate-200 dark:ring-slate-800 p-4 bg-white/70 dark:bg-slate-900/50 backdrop-blur">
              <div class="flex flex-wrap items-baseline gap-2">
                <div class="font-semibold">{{ $i['title'] }}</div>
                <span class="text-slate-400">—</span>
                <div class="text-slate-600 dark:text-slate-300">{{ $i['company'] }}</div>
                <div class="ml-auto text-xs text-slate-500">{{ $i['time'] }}</div>
              </div>
              <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">{{ $i['desc'] }}</p>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- TESTIMONIALS (static, no JS) --}}
  <section>
    <h2 class="text-xl font-semibold">What clients say</h2>
    <div class="mt-5 grid md:grid-cols-3 gap-4">
      @foreach([
        ['q'=>'Delivers features ahead of schedule, communicates clearly.', 'a'=>'CTO, SaaS Startup'],
        ['q'=>'Clean codebase and helpful documentation—handover was a breeze.', 'a'=>'Founder, Agency'],
        ['q'=>'UI feels premium and the site is blazing fast. Great experience.', 'a'=>'Product Lead'],
      ] as $t)
        <blockquote class="rounded-2xl ring-1 ring-slate-200 dark:ring-slate-800 p-5 bg-white/70 dark:bg-slate-900/50">
          <p class="text-slate-700 dark:text-slate-200">“{{ $t['q'] }}”</p>
          <footer class="mt-3 text-xs text-slate-500">— {{ $t['a'] }}</footer>
        </blockquote>
      @endforeach
    </div>
  </section>

  {{-- CTA --}}
  <section class="rounded-3xl p-6 sm:p-8 bg-gradient-to-br from-indigo-600 via-fuchsia-500 to-cyan-500 text-white">
    <div class="grid md:grid-cols-2 gap-6 items-center">
      <div>
        <h3 class="text-2xl font-extrabold">Have a project in mind?</h3>
        <p class="mt-1 text-white/90">Tell me your goals. I’ll propose a clear, pragmatic plan—and ship on time.</p>
      </div>
      <div class="flex md:justify-end gap-3">
        <a href="{{ route('contact') }}"
           class="inline-flex items-center gap-2 rounded-xl bg-white text-slate-900 px-5 py-3 font-medium hover:bg-white/90 transition">
          Start a conversation
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M2.01 21 23 12 2.01 3 2 10l15 2-15 2 .01 7Z"/></svg>
        </a>
        <a href="{{ asset('cv.pdf') }}" target="_blank"
           class="inline-flex items-center gap-2 rounded-xl ring-1 ring-white/60 px-5 py-3 font-medium hover:bg-white/10 transition">
          View CV
        </a>
      </div>
    </div>
  </section>

</div>
@endsection
