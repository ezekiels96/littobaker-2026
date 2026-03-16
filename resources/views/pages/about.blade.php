@extends('layouts.app')

@section('content')

{{-- ─── Hero / Intro ──────────────────────────────────────────────────────── --}}
<section class="relative left-1/2 w-screen -translate-x-1/2 overflow-hidden bg-gradient-to-b from-rose-50 via-pink-50 to-amber-50 px-6 py-20 md:px-12">

    {{-- Decorative blobs --}}
    <div class="pointer-events-none absolute -top-32 -left-24 h-96 w-96 rounded-full bg-[#FFC447]/20 blur-3xl"></div>
    <div class="pointer-events-none absolute -top-20 right-0 h-72 w-72 rounded-full bg-[#F46EE5]/20 blur-3xl"></div>
    <div class="pointer-events-none absolute bottom-0 left-1/2 h-64 w-64 -translate-x-1/2 rounded-full bg-[#b9a7ff]/15 blur-3xl"></div>

    <div class="relative mx-auto max-w-5xl">
        <div class="flex flex-col items-center gap-10 md:flex-row md:items-start md:gap-16">

            {{-- Photo --}}
            <div class="shrink-0">
                @if(!empty($about->image_url))
                    <div class="relative">
                        <div class="absolute -inset-1.5 rounded-[2rem] bg-gradient-to-br from-[#FFC447] via-[#F46EE5] to-[#b9a7ff] blur-sm opacity-60"></div>
                        <img src="{{ $about->image_url }}" alt="littobaker"
                             class="relative h-64 w-64 rounded-[2rem] object-cover shadow-2xl ring-4 ring-white md:h-80 md:w-80">
                    </div>
                @else
                    <div class="relative">
                        <div class="absolute -inset-1.5 rounded-[2rem] bg-gradient-to-br from-[#FFC447] via-[#F46EE5] to-[#b9a7ff] blur-sm opacity-40"></div>
                        <div class="relative flex h-64 w-64 items-center justify-center rounded-[2rem] bg-white shadow-2xl ring-4 ring-white md:h-80 md:w-80">
                            <span class="text-8xl">🍪</span>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Intro Text --}}
            <div class="flex-1 text-center md:text-left">
                <p class="mb-3 inline-flex items-center gap-2 rounded-full border border-black/5 bg-white/70 px-4 py-1.5 font-['Sour_Gummy'] text-xs font-bold lowercase tracking-widest text-[#706f6c] shadow-sm backdrop-blur">
                    <span>🍪</span> home bakery · sunnyvale, ca
                </p>
                <h1 class="font-['Sour_Gummy'] text-5xl font-extrabold lowercase leading-tight text-[#1b1b18] drop-shadow-sm md:text-6xl">
                    {{ $about->hero_heading ?: 'about littobaker' }}
                </h1>
                @if($about->hero_tagline)
                <p class="mt-4 font-['Sour_Gummy'] text-lg font-bold lowercase text-[#5a5246]">
                    {{ $about->hero_tagline }}
                </p>
                @endif

                {{-- CTA --}}
                <div class="mt-8 flex flex-wrap justify-center gap-3 md:justify-start">
                    <a href="{{ route('order-form') }}"
                       class="inline-flex items-center rounded-full bg-gradient-to-r from-[#8f7cfa] to-[#f46ee5] px-6 py-3 font-['Sour_Gummy'] text-sm font-extrabold lowercase text-white shadow-lg transition hover:scale-105">
                        place an order ♡
                    </a>
                    <a href="{{ route('menu.index') }}"
                       class="inline-flex items-center rounded-full border border-black/10 bg-white/80 px-6 py-3 font-['Sour_Gummy'] text-sm font-extrabold lowercase text-[#1b1b18] shadow transition hover:bg-white hover:scale-105">
                        view menu →
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ─── Rich Content ───────────────────────────────────────────────────────── --}}
@if(!empty($about->content))
<section class="relative left-1/2 w-screen -translate-x-1/2 bg-white px-6 py-16 md:px-12">
    <div class="mx-auto max-w-3xl">
        <div class="rich-content">
            {!! $about->content !!}
        </div>
    </div>
</section>
@endif

{{-- ─── Values / Fun Facts strip ───────────────────────────────────────────── --}}
<section class="relative left-1/2 w-screen -translate-x-1/2 bg-gradient-to-r from-[#fff7fb] via-[#fbf6ef] to-[#fff7fb] px-6 py-14 md:px-12">
    <div class="mx-auto max-w-5xl">
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">

            <div class="group relative overflow-hidden rounded-3xl bg-white/80 p-6 shadow-lg ring-1 ring-black/5 text-center transition hover:-translate-y-0.5 hover:shadow-xl">
                <div class="pointer-events-none absolute -top-16 left-1/2 h-32 w-32 -translate-x-1/2 rounded-full bg-[#FFC447]/30 blur-2xl"></div>
                <div class="mb-4 text-4xl">🧁</div>
                <h3 class="font-['Sour_Gummy'] text-xl font-extrabold lowercase text-[#1b1b18]">made with love</h3>
                <p class="mt-2 font-['Sour_Gummy'] text-sm font-bold lowercase text-[#706f6c]">every treat is handcrafted in small batches with care ♡</p>
            </div>

            <div class="group relative overflow-hidden rounded-3xl bg-white/80 p-6 shadow-lg ring-1 ring-black/5 text-center transition hover:-translate-y-0.5 hover:shadow-xl">
                <div class="pointer-events-none absolute -top-16 left-1/2 h-32 w-32 -translate-x-1/2 rounded-full bg-[#F46EE5]/20 blur-2xl"></div>
                <div class="mb-4 text-4xl">🌸</div>
                <h3 class="font-['Sour_Gummy'] text-xl font-extrabold lowercase text-[#1b1b18]">asian-inspired</h3>
                <p class="mt-2 font-['Sour_Gummy'] text-sm font-bold lowercase text-[#706f6c]">unique flavors blending eastern and western dessert traditions ♡</p>
            </div>

            <div class="group relative overflow-hidden rounded-3xl bg-white/80 p-6 shadow-lg ring-1 ring-black/5 text-center transition hover:-translate-y-0.5 hover:shadow-xl">
                <div class="pointer-events-none absolute -top-16 left-1/2 h-32 w-32 -translate-x-1/2 rounded-full bg-[#b9a7ff]/25 blur-2xl"></div>
                <div class="mb-4 text-4xl">✨</div>
                <h3 class="font-['Sour_Gummy'] text-xl font-extrabold lowercase text-[#1b1b18]">custom orders</h3>
                <p class="mt-2 font-['Sour_Gummy'] text-sm font-bold lowercase text-[#706f6c]">special requests welcome — let's make something sweet ♡</p>
            </div>

        </div>
    </div>
</section>

{{-- ─── CTA Banner ─────────────────────────────────────────────────────────── --}}
<section class="relative left-1/2 w-screen -translate-x-1/2 bg-[#1b1b18] px-6 py-14 md:px-12 text-center">
    <div class="mx-auto max-w-2xl">
        <p class="font-['Sour_Gummy'] text-3xl font-extrabold lowercase text-white">ready to treat yourself? 🍪</p>
        <p class="mt-3 font-['Sour_Gummy'] text-base font-bold lowercase text-white/60">browse the menu and place a custom order today</p>
        <div class="mt-8 flex flex-wrap justify-center gap-4">
            <a href="{{ route('order-form') }}"
               class="inline-flex items-center rounded-full bg-gradient-to-r from-[#FFC447] to-[#F46EE5] px-8 py-3.5 font-['Sour_Gummy'] text-base font-extrabold lowercase text-[#1b1b18] shadow-xl transition hover:scale-105">
                order now ♡
            </a>
            <a href="{{ route('contact') }}"
               class="inline-flex items-center rounded-full border border-white/20 bg-white/10 px-8 py-3.5 font-['Sour_Gummy'] text-base font-extrabold lowercase text-white shadow transition hover:bg-white/20">
                get in touch →
            </a>
        </div>
    </div>
</section>

@endsection
