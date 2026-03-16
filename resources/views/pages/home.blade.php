@extends('layouts.app')

@section('content')
@php
    $home = \App\Models\HomeSetting::getInstance();
@endphp

<section class="relative isolate left-1/2 w-screen -translate-x-1/2 overflow-hidden rounded-none bg-gradient-to-r from-rose-100 via-pink-50 to-amber-50 px-6 py-24 text-center shadow-2xl md:px-12">
    @if($home->hero_image)
        <img src="{{ $home->hero_image }}" alt="" class="absolute inset-0 -z-20 h-full w-full object-cover">
    @endif
    <div class="relative mx-auto max-w-2xl space-y-6">
        <h2 class="font-['Sour_Gummy'] text-5xl font-extrabold text-white drop-shadow-lg md:text-6xl lowercase">
            {{ $home->hero_heading ?: 'delicious asian inspired sweet treats' }}
        </h2>
        <div class="flex flex-col items-center gap-3 sm:flex-row sm:justify-center">
            <a href="{{ route('menu.index') }}" class="inline-flex items-center justify-center rounded-full bg-gradient-to-r from-[#FFC447] to-[#F46EE5] px-10 py-3 text-lg font-bold tracking-wide text-[#1b1b18] shadow-xl transition hover:scale-105">
                View Menu
            </a>
        </div>
    </div>
</section>

<section class="relative left-1/2 w-screen -translate-x-1/2 bg-[#FFE5F0] px-6 py-16 md:px-12">
    <div class="mx-auto grid max-w-4xl grid-cols-1 gap-8 md:grid-cols-[0.7fr_0.7fr] md:items-center">
        @if($home->feature_image)
        <div class="aspect-square overflow-hidden rounded-3xl shadow-lg">
            <img src="{{ $home->feature_image }}" alt="" class="h-full w-full object-cover">
        </div>
        @endif
        <div class="space-y-6 text-left">
            <h3 class="font-['Sour_Gummy'] text-3xl font-extrabold text-[#1b1b18] drop-shadow-lg md:text-4xl lowercase">
                {{ $home->feature_heading ?: 'specially made with love with every order' }}
            </h3>
            @if($home->feature_text)
            <p class="font-['Sour_Gummy'] text-base leading-relaxed text-[#5a5246] lowercase">
                {{ $home->feature_text }}
            </p>
            @endif
            <a href="{{ route('order-form') }}" class="inline-flex items-center justify-center rounded-full bg-gradient-to-r from-[#8f7cfa] to-[#f46ee5] px-10 py-3 text-lg font-bold tracking-wide text-white shadow-xl transition hover:scale-105">
                Order Now
            </a>
        </div>
    </div>
</section>
{{-- Instagram manual preview (no widgets) --}}
<section class="relative left-1/2 w-screen -translate-x-1/2 bg-rose-50 px-6 py-16 md:px-12">
    <div class="mx-auto max-w-6xl">
        <div class="mb-10 text-center">
            <h3 class="font-['Sour_Gummy'] text-4xl font-extrabold text-[#1b1b18] drop-shadow-lg md:text-5xl lowercase">
                from our instagram ♡
            </h3>
            <p class="mt-3 font-['Sour_Gummy'] text-base text-[#5a5246] lowercase">
                the latest bakes + behind the scenes — @littobaker
            </p>
        </div>
@if($igPosts->isNotEmpty())
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach($igPosts as $post)
            <a href="{{ $post->post_url }}"
               target="_blank"
               rel="noopener"
               class="group relative overflow-hidden rounded-3xl bg-white/80 shadow-xl ring-1 ring-black/5 backdrop-blur
                      transition hover:-translate-y-0.5 hover:shadow-2xl">

                {{-- Cute glow --}}
                <div class="pointer-events-none absolute -top-24 left-1/2 h-48 w-48 -translate-x-1/2
                            rounded-full bg-gradient-to-r from-[#FFC447]/35 to-[#F46EE5]/30 blur-3xl"></div>

                <div class="relative aspect-square overflow-hidden">
                    @if($post->image_url)
                        <img
                            src="{{ $post->image_url }}"
                            alt="{{ $post->label ?? 'instagram post' }}"
                            class="h-full w-full object-cover transition duration-300 group-hover:scale-105"
                            loading="lazy"
                            onerror="this.style.display='none'; this.nextElementSibling.classList.remove('hidden');"
                        >
                        <div class="hidden h-full w-full bg-gradient-to-br from-rose-100 via-pink-50 to-amber-50"></div>
                    @else
                        {{-- fallback --}}
                        <div class="h-full w-full bg-gradient-to-br from-rose-100 via-pink-50 to-amber-50"></div>
                    @endif

                    {{-- Hover overlay --}}
                    <div class="absolute inset-0 flex items-center justify-center bg-black/35 opacity-0 transition group-hover:opacity-100">
                        <span class="rounded-full bg-white/90 px-4 py-2 font-['Sour_Gummy']
                                     text-sm font-extrabold lowercase text-[#1b1b18] shadow">
                            view on instagram
                        </span>
                    </div>
                </div>

                <div class="p-5 text-center">
                    <div class="font-['Sour_Gummy'] text-lg font-extrabold lowercase text-[#1b1b18]">
                        {{ $post->label ?? 'see this post ♡' }}
                    </div>
                    <div class="mt-1 font-['Sour_Gummy'] text-sm font-bold lowercase text-[#5a5246]">
                        tap to open
                    </div>
                </div>
            </a>
        @endforeach
    </div>
@endif


        <div class="mt-10 text-center">
            <a href="https://www.instagram.com/littobaker/" target="_blank" rel="noopener"
               class="inline-flex items-center justify-center rounded-full bg-gradient-to-r from-[#FFC447] to-[#F46EE5]
                      px-10 py-3 text-lg font-bold tracking-wide text-[#1b1b18] shadow-xl transition hover:scale-105">
                visit @littobaker
            </a>
        </div>
    </div>
</section>

@endsection
