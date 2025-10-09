@props(['title'=>null,'description'=>null,'image'=>null])
@php($site = \App\Models\Setting::first())
<title>{{ $title ? $title.' | ' : '' }}{{ $site->site_name ?? 'KodeByLana' }}</title>
<meta name="description" content="{{ $description ?? 'Portfolio & projects by KodeByLana' }}"/>
<meta property="og:title" content="{{ $title ?? ($site->site_name ?? 'KodeByLana') }}"/>
<meta property="og:description" content="{{ $description ?? '' }}"/>
@if($image)
<meta property="og:image" content="{{ asset('storage/'.$image) }}"/>
@endif