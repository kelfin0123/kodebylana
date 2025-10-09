<!DOCTYPE html>
<html lang="id" x-data="theme()" x-init="initTheme()" class="scroll-smooth">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>@yield('title', 'KodeByLana')</title>
  <meta name="description" content="@yield('meta_description', 'Portfolio – KodeByLana')" />
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
  @vite(['resources/css/app.css','resources/js/app.js'])
  @stack('head')
</head>

<body
  class="bg-white text-slate-900 dark:bg-slate-950 dark:text-slate-100 min-h-screen flex flex-col antialiased selection:bg-indigo-500/20 selection:text-indigo-600">

@php
  use Illuminate\Support\Facades\Schema;
  use App\Models\NavItem;

  // ambil menu dari DB kalau tabelnya ada; cache 60s
  $menuHeader = collect();
  if (class_exists(NavItem::class) && Schema::hasTable('nav_items')) {
      $menuHeader = cache()->remember('nav.header', 60, fn () =>
          NavItem::active()->header()
              ->whereNull('parent_id')
              ->with('children')
              ->orderBy('order')
              ->get()
      );
  }
  // fallback kalau belum ada data
  if ($menuHeader->isEmpty()) {
      $menuHeader = collect([
          (object)['label' => 'Projects',     'href' => route('projects.index')],
          (object)['label' => 'Services',     'href' => route('services.index')],
          (object)['label' => 'Testimonials', 'href' => route('testimonials.index')],
          (object)['label' => 'Blog',         'href' => route('blog.index')],
          (object)['label' => 'About',        'href' => route('about')],
          (object)['label' => 'Contact',      'href' => route('contact')],
      ]);
  }
@endphp

<!-- Scroll progress -->
<div x-data="{w:0}" x-init="
  const onScroll=()=>{ const h=document.documentElement;
    const max=h.scrollHeight-h.clientHeight; w=(max? (h.scrollTop/max)*100:0) };
  onScroll(); window.addEventListener('scroll', onScroll)" aria-hidden="true"
  class="fixed top-0 left-0 right-0 z-[60] h-[3px] bg-transparent">
  <div class="h-full bg-gradient-to-r from-indigo-500 via-fuchsia-500 to-cyan-400 transition-[width] duration-150"
       :style="`width:${w}%;`"></div>
</div>

<!-- Sticky Glass Navbar -->
<header x-data="{open:false, scrolled:false}"
        x-init="window.addEventListener('scroll', ()=>scrolled=window.scrollY>10)"
        :class="scrolled ? 'shadow-lg/10 dark:shadow-none' : ''"
        class="sticky top-0 z-50 backdrop-blur supports-[backdrop-filter]:bg-white/70 dark:supports-[backdrop-filter]:bg-slate-900/60 bg-white/90 dark:bg-slate-950/80 border-b border-slate-200/60 dark:border-slate-800">
  <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
    <a href="{{ url('/') }}" class="font-extrabold text-xl tracking-tight flex items-center gap-2 group">
      <span
        class="inline-block bg-gradient-to-r from-indigo-500 via-fuchsia-500 to-cyan-400 bg-clip-text text-transparent">
        KodeByLana
      </span>
      <span
        class="w-1.5 h-1.5 rounded-full bg-indigo-500/70 group-hover:scale-125 transition"></span>
    </a>

    <!-- Desktop nav -->
    <nav class="hidden md:flex items-center gap-6 text-sm">
      @foreach($menuHeader as $item)
        @php
          $href = property_exists($item,'href') ? $item->href : ($item->href ?? ($item->route_name ? route($item->route_name,$item->params??[]) : '#'));
          $active = url()->current() === $href
                    || (property_exists($item,'route_name') && request()->routeIs($item->route_name));
        @endphp
        <a href="{{ $href }}"
           @if(isset($item->open_new_tab) && $item->open_new_tab) target="_blank" rel="noopener" @endif
           class="relative group inline-flex items-center gap-2 {{ $active ? 'text-indigo-600' : 'text-slate-700 dark:text-slate-300' }}">
          {{ $item->label }}
          <span class="absolute -bottom-1 left-0 h-0.5 w-0 bg-gradient-to-r from-indigo-500 via-fuchsia-500 to-cyan-400 transition-all duration-300 group-hover:w-full {{ $active ? 'w-full' : '' }}"></span>
        </a>
      @endforeach
    </nav>

    <div class="flex items-center gap-2">
      @auth
        <a href="{{ route('admin.dashboard') }}"
           class="hidden sm:inline-block text-xs px-3 py-1 rounded-full border dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800 transition">
          Admin
        </a>
      @endauth

      <!-- Theme toggle -->
      <button @click="toggle()"
              class="w-10 h-10 grid place-content-center rounded-full border dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800 transition"
              aria-label="Toggle theme">
        <svg x-show="!dark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
             class="w-5 h-5" fill="currentColor">
          <path d="M6.76 4.84l-1.8-1.79L3.17 4.84l1.79 1.79zm10.48 0l1.79-1.79l1.79 1.79l-1.79 1.79zM12 4V1v3zm0 19v-3v3zM4 12H1h3zm22 0h-3h3zM6.76 19.16l-1.8 1.79l-1.79-1.79l1.79-1.79zm10.48 0l1.79 1.79l1.79-1.79l-1.79-1.79zM12 7a5 5 0 1 0 0 10a5 5 0 0 0 0-10"/>
        </svg>
        <svg x-show="dark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
             class="w-5 h-5" fill="currentColor">
          <path d="M21.64 13A9 9 0 0 1 11 2.36a1 1 0 0 0-1.36-1.36A11 11 0 1 0 22.99 14.36A1 1 0 0 0 21.64 13"/>
        </svg>
      </button>

      <!-- Mobile burger -->
      <button @click="open=true" class="md:hidden w-10 h-10 grid place-content-center rounded-full border dark:border-slate-700">
        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
      </button>
    </div>
  </div>

  <!-- Mobile drawer -->
  <div x-cloak x-show="open" @keydown.escape.window="open=false">
    <div @click="open=false"
         class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-40"></div>
    <div x-transition:enter="transition duration-300"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         class="fixed left-3 right-3 top-3 z-50 rounded-2xl border border-slate-200/70 dark:border-slate-800
                bg-white/90 dark:bg-slate-950/90 backdrop-blur p-4">
      <div class="flex items-center justify-between">
        <div class="font-semibold">Menu</div>
        <button @click="open=false" class="w-9 h-9 grid place-content-center rounded-full hover:bg-slate-100 dark:hover:bg-slate-800">
          ✕
        </button>
      </div>
      <div class="mt-3 divide-y divide-slate-200/60 dark:divide-slate-800">
        @foreach($menuHeader as $item)
          @php
            $href = property_exists($item,'href') ? $item->href : ($item->href ?? ($item->route_name ? route($item->route_name,$item->params??[]) : '#'));
          @endphp
          <a href="{{ $href }}"
             @if(isset($item->open_new_tab) && $item->open_new_tab) target="_blank" rel="noopener" @endif
             class="block py-3 hover:text-indigo-600">
            {{ $item->label }}
          </a>
        @endforeach
      </div>
    </div>
  </div>
</header>

<!-- Page wrapper -->
<main class="flex-1" data-aos="fade-up">
  @yield('content')
</main>

<!-- Footer -->
<footer class="mt-16">
  <div class="h-px bg-gradient-to-r from-transparent via-slate-200 dark:via-slate-800 to-transparent"></div>
  <div class="max-w-6xl mx-auto px-4 py-10 text-center text-sm text-slate-500">
    © {{ date('Y') }} KodeByLana.com
  </div>
</footer>

<!-- Back to top -->
<button x-data="{show:false}"
        x-init="window.addEventListener('scroll',()=>show=window.scrollY>400)"
        x-show="show" @click="window.scrollTo({top:0,behavior:'smooth'})"
        x-transition
        class="fixed bottom-6 right-6 z-40 rounded-full border dark:border-slate-700 w-11 h-11 grid place-content-center
               bg-white/90 dark:bg-slate-900/90 backdrop-blur hover:scale-105 transition">
  ↑
</button>

{{-- JS libs --}}
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
function theme(){
  return {
    dark: false,
    initTheme(){
      // initial state (localStorage -> system -> default light)
      const saved = localStorage.theme;
      if (saved === 'dark' || (!saved && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        this.dark = true; document.documentElement.classList.add('dark');
      }
      // sync if OS changes
      window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
        if (!localStorage.theme) { this.dark = e.matches; document.documentElement.classList.toggle('dark', this.dark); }
      });
      // AOS
      document.addEventListener('DOMContentLoaded', () => {
        AOS.init({ once:true, duration:800, offset:120, easing:'ease-out-cubic' });
      });
    },
    toggle(){
      this.dark = !this.dark;
      document.documentElement.classList.toggle('dark', this.dark);
      localStorage.theme = this.dark ? 'dark' : 'light';
    }
  }
}
</script>

@stack('scripts')
</body>
</html>
