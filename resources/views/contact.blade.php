@extends('layouts.app')

@section('title', 'Contact')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-14">
  {{-- Heading --}}
  <div class="text-center mb-10">
    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700 dark:bg-indigo-950/40 dark:text-indigo-300">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M1.5 8.67v6.66c0 .78.63 1.41 1.41 1.41h4.25v3.08c0 .53.61.8.97.43l3.51-3.51h8.45c.78 0 1.41-.63 1.41-1.41V8.67c0-.78-.63-1.41-1.41-1.41H2.91c-.78 0-1.41.63-1.41 1.41Z"/></svg>
      let’s talk
    </span>
    <h1 class="mt-3 text-3xl sm:text-4xl font-extrabold">
      Say hello — <span class="bg-gradient-to-r from-indigo-600 via-fuchsia-500 to-cyan-500 bg-clip-text text-transparent">kolaborasi</span> atau <span class="bg-gradient-to-r from-cyan-500 to-indigo-600 bg-clip-text text-transparent">penawaran</span>
    </h1>
    <p class="mt-2 text-slate-600 dark:text-slate-300 max-w-2xl mx-auto">
      Ceritakan kebutuhanmu. Biasanya saya merespon dalam <strong>24–48 jam</strong> pada hari kerja.
    </p>
  </div>

  {{-- Flash + Errors --}}
  @if(session('ok'))
    <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-800 dark:border-green-900/50 dark:bg-green-900/20 dark:text-green-200">
      {{ session('ok') }}
    </div>
  @endif

  @if($errors->any())
    <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-800 dark:border-red-900/50 dark:bg-red-900/20 dark:text-red-200">
      <ul class="list-disc list-inside text-sm space-y-1">
        @foreach($errors->all() as $e)
          <li>{{ $e }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="grid gap-8 md:grid-cols-5">
    {{-- Info side --}}
    <div class="md:col-span-2">
      <div class="rounded-2xl border border-slate-200/70 dark:border-slate-800/70 bg-white/70 dark:bg-slate-900/50 backdrop-blur-sm p-6 shadow-sm">
        <h2 class="font-semibold text-lg mb-3">Prefer chat dulu?</h2>
        <ul class="space-y-3 text-sm text-slate-600 dark:text-slate-300">
          <li class="flex items-start gap-3">
            <svg class="h-5 w-5 text-indigo-500 mt-0.5" viewBox="0 0 24 24" fill="currentColor"><path d="M2 5.75A2.75 2.75 0 0 1 4.75 3H19.5a.75.75 0 0 1 0 1.5H4.75c-.69 0-1.25.56-1.25 1.25v10.5c0 .69.56 1.25 1.25 1.25H18a.75.75 0 0 1 0 1.5H4.75A2.75 2.75 0 0 1 2 16.25V5.75Z"/><path d="M7 7.75A.75.75 0 0 1 7.75 7h12.5a.75.75 0 0 1 .75.75v9.5A2.75 2.75 0 0 1 18.25 20H10l-3.3 2.475A.75.75 0 0 1 6 21.85V7.75Z"/></svg>
            <div>
              <div class="font-medium text-slate-800 dark:text-slate-100">Email</div>
              <a href="mailto:hello@example.com" class="hover:underline">hello@example.com</a>
            </div>
          </li>
          <li class="flex items-start gap-3">
            <svg class="h-5 w-5 text-indigo-500 mt-0.5" viewBox="0 0 24 24" fill="currentColor"><path d="M2.25 6.75A2.25 2.25 0 0 1 4.5 4.5h15a2.25 2.25 0 0 1 2.25 2.25v10.5A2.25 2.25 0 0 1 19.5 19.5h-15A2.25 2.25 0 0 1 2.25 17.25V6.75Zm1.5 0v.443l8.421 5.053a.75.75 0 0 0 .758 0L21 7.193V6.75c0-.414-.336-.75-.75-.75h-15a.75.75 0 0 0-.75.75Z"/></svg>
            <div>
              <div class="font-medium text-slate-800 dark:text-slate-100">Respons</div>
              <p>Biasanya 24–48 jam, Senin–Jumat.</p>
            </div>
          </li>
          <li class="flex items-start gap-3">
            <svg class="h-5 w-5 text-indigo-500 mt-0.5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2a7 7 0 0 0-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 0 0-7-7Zm0 9.5a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5Z"/></svg>
            <div>
              <div class="font-medium text-slate-800 dark:text-slate-100">Lokasi</div>
              <p>Remote — Indonesia (GMT+7)</p>
            </div>
          </li>
        </ul>

        <div class="mt-6 pt-6 border-t border-slate-200 dark:border-slate-800">
          <h3 class="font-medium mb-2">Layanan yang sering diminta</h3>
          <div class="flex flex-wrap gap-2">
            <span class="px-2.5 py-1 rounded-lg text-xs bg-slate-100 dark:bg-slate-800">Web App</span>
            <span class="px-2.5 py-1 rounded-lg text-xs bg-slate-100 dark:bg-slate-800">Company Profile</span>
            <span class="px-2.5 py-1 rounded-lg text-xs bg-slate-100 dark:bg-slate-800">API & Integrasi</span>
            <span class="px-2.5 py-1 rounded-lg text-xs bg-slate-100 dark:bg-slate-800">UI & Optimization</span>
          </div>
        </div>
      </div>
    </div>

    {{-- Form side --}}
    <div class="md:col-span-3">
      <form method="POST" action="{{ route('contact.store') }}"
            class="rounded-2xl border border-slate-200/70 dark:border-slate-800/70 bg-white/70 dark:bg-slate-900/50 backdrop-blur-sm p-6 shadow-sm space-y-5"
            novalidate>
        @csrf

        <div>
          <label for="name" class="block text-sm font-medium mb-1">Nama <span class="text-red-500">*</span></label>
          <input
            id="name"
            type="text"
            name="name"
            value="{{ old('name') }}"
            required
            autocomplete="name"
            @error('name') aria-invalid="true" aria-describedby="name-error" @enderror
            class="block w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white/80 dark:bg-slate-900/70 px-4 py-3 text-slate-800 dark:text-slate-100 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-indigo-100 dark:focus:ring-indigo-900/30 focus:border-indigo-500 shadow-sm"
            placeholder="Nama lengkap">
          @error('name') <p id="name-error" class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="grid sm:grid-cols-2 gap-4">
          <div>
            <label for="email" class="block text-sm font-medium mb-1">Email <span class="text-red-500">*</span></label>
            <input
              id="email"
              type="email"
              name="email"
              value="{{ old('email') }}"
              required
              autocomplete="email"
              @error('email') aria-invalid="true" aria-describedby="email-error" @enderror
              class="block w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white/80 dark:bg-slate-900/70 px-4 py-3 text-slate-800 dark:text-slate-100 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-indigo-100 dark:focus:ring-indigo-900/30 focus:border-indigo-500 shadow-sm"
              placeholder="email@domain.com">
            @error('email') <p id="email-error" class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
          </div>

          <div>
            <label for="subject" class="block text-sm font-medium mb-1">Subjek</label>
            <input
              id="subject"
              type="text"
              name="subject"
              value="{{ old('subject') }}"
              autocomplete="off"
              @error('subject') aria-invalid="true" aria-describedby="subject-error" @enderror
              class="block w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white/80 dark:bg-slate-900/70 px-4 py-3 text-slate-800 dark:text-slate-100 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-indigo-100 dark:focus:ring-indigo-900/30 focus:border-indigo-500 shadow-sm"
              placeholder="Topik pesan">
            @error('subject') <p id="subject-error" class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
          </div>
        </div>

        <div>
          <label for="message" class="block text-sm font-medium mb-1">Pesan <span class="text-red-500">*</span></label>
          <textarea
            id="message"
            name="message"
            rows="6"
            required
            @error('message') aria-invalid="true" aria-describedby="message-error" @enderror
            class="block w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white/80 dark:bg-slate-900/70 px-4 py-3 text-slate-800 dark:text-slate-100 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-indigo-100 dark:focus:ring-indigo-900/30 focus:border-indigo-500 shadow-sm"
            placeholder="Tulis pesanmu…">{{ old('message') }}</textarea>
          @error('message') <p id="message-error" class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Consent (opsional) --}}
        <div class="flex items-start gap-3">
          <input id="consent" type="checkbox" name="consent" value="1"
                 class="mt-1 h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500"
                 @checked(old('consent'))>
          <label for="consent" class="text-sm text-slate-600 dark:text-slate-300">
            Saya setuju untuk dihubungi kembali terkait pesan ini.
          </label>
        </div>
        @error('consent') <p class="text-sm text-red-600">{{ $message }}</p> @enderror

        {{-- Honeypot anti-bot --}}
        <label class="sr-only" for="website">Website</label>
        <input id="website" type="text" name="website" class="sr-only" tabindex="-1" autocomplete="off" aria-hidden="true">

        <div class="pt-2">
          <button
            class="inline-flex items-center justify-center gap-2 w-full sm:w-auto rounded-xl px-5 py-3 font-medium text-white
                   bg-gradient-to-r from-indigo-600 via-fuchsia-500 to-cyan-500 hover:opacity-95
                   shadow-sm hover:shadow transition">
            Kirim Pesan
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-90" viewBox="0 0 24 24" fill="currentColor"><path d="M2.01 21 23 12 2.01 3 2 10l15 2-15 2 .01 7Z"/></svg>
          </button>
          <p class="mt-3 text-xs text-slate-500">
            Dengan mengirimkan formulir ini, Anda menyetujui pemrosesan data untuk keperluan tindak lanjut.
          </p>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
