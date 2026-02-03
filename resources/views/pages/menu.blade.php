@extends('layouts.app')

@section('content')
@php
    // Soft pastel background like home
    $bg = 'bg-gradient-to-b from-rose-50 via-pink-50 to-amber-50';
@endphp

<section class="relative left-1/2 w-screen -translate-x-1/2 {{ $bg }} px-6 py-16 md:px-12">
    <div class="mx-auto max-w-6xl">
        <div class="mb-10 text-center">
            <h1 class="font-['Sour_Gummy'] text-5xl font-extrabold text-[#1b1b18] drop-shadow-lg md:text-6xl lowercase">
                menu
            </h1>
            <p class="mt-3 font-['Sour_Gummy'] text-base text-[#5a5246] lowercase">
                asian-inspired sweet treats made with love ♡
            </p>
        </div>

        {{-- Grid --}}
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($menus as $menu)
                @php
                    $images = $menu->images?->pluck('image_url')->filter()->values() ?? collect();
                    $first = $images->first() ?? 'https://res.cloudinary.com/dtbjsvd1l/image/upload/v1769070837/IMG_4829_bltwzk.jpg?auto=format&fit=crop&w=800&q=80';

                    $unitLabel = match($menu->quantity_type) {
                        'dozen'  => 'dozen',
                        'pieces' => 'pieces',
                        'order'  => 'order',
                        default  => $menu->quantity_type,
                    };
                @endphp

                <article
                    class="group relative overflow-hidden rounded-3xl bg-white/80 p-5 shadow-xl ring-1 ring-black/5 backdrop-blur transition hover:-translate-y-0.5 hover:shadow-2xl"
                    data-menu-card
                    data-images='@json($images->all())'
                >
                    {{-- Cute top glow --}}
                    <div class="pointer-events-none absolute -top-24 left-1/2 h-48 w-48 -translate-x-1/2 rounded-full bg-gradient-to-r from-[#FFC447]/40 to-[#F46EE5]/40 blur-3xl"></div>

                    <div class="flex gap-4">
                        {{-- Image block --}}
                        <div class="relative h-24 w-24 shrink-0 overflow-hidden rounded-2xl bg-white shadow-md ring-1 ring-black/5">
                            <img
                                data-active-img
                                src="{{ $first }}"
                                alt="{{ $menu->title }}"
                                class="h-full w-full object-cover"
                                loading="lazy"
                            >

                            @if($images->count() > 1)
                                {{-- Prev/Next buttons --}}
                                <button
                                    type="button"
                                    data-prev
                                    class="absolute left-1 top-1/2 -translate-y-1/2 rounded-full bg-white/80 px-2 py-1 text-xs font-bold text-[#1b1b18] shadow hover:bg-white"
                                    aria-label="Previous image"
                                >
                                    ‹
                                </button>
                                <button
                                    type="button"
                                    data-next
                                    class="absolute right-1 top-1/2 -translate-y-1/2 rounded-full bg-white/80 px-2 py-1 text-xs font-bold text-[#1b1b18] shadow hover:bg-white"
                                    aria-label="Next image"
                                >
                                    ›
                                </button>

                                {{-- Dots --}}
                                <div class="absolute bottom-1 left-1/2 flex -translate-x-1/2 gap-1">
                                    @for($i = 0; $i < $images->count(); $i++)
                                        <span
                                            data-dot="{{ $i }}"
                                            class="h-1.5 w-1.5 rounded-full bg-white/70 ring-1 ring-black/10"
                                        ></span>
                                    @endfor
                                </div>
                            @endif
                        </div>

                        {{-- Text --}}
                        <div class="min-w-0 flex-1">
                            <h2 class="font-['Sour_Gummy'] text-xl font-extrabold lowercase tracking-wide text-[#1b1b18]">
                                {{ $menu->title }}
                            </h2>

                            @if(!empty($menu->description))
                                <p class="mt-1 line-clamp-3 font-['Sour_Gummy'] text-sm leading-relaxed text-[#5a5246] lowercase">
                                    {{ $menu->description }}
                                </p>
                            @else
                                <p class="mt-1 font-['Sour_Gummy'] text-sm text-[#5a5246]/70 lowercase">
                                    a sweet lil treat ♡
                                </p>
                            @endif

                            <div class="mt-3 flex items-center gap-2">
                                <span class="inline-flex items-center rounded-full bg-gradient-to-r from-[#FFC447] to-[#F46EE5] px-3 py-1 text-sm font-extrabold text-[#1b1b18] shadow">
                                    ${{ number_format((float)$menu->price, 2) }}
                                </span>
                                <span class="font-['Sour_Gummy'] text-sm font-bold text-[#1b1b18] lowercase">
                                    / {{ $unitLabel }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Optional: tiny thumbnail strip if multiple images --}}
                    @if($images->count() > 1)
                        <div class="mt-4 flex gap-2 overflow-x-auto pb-1">
                            @foreach($images as $idx => $url)
                                <button
                                    type="button"
                                    data-thumb="{{ $idx }}"
                                    class="h-10 w-10 shrink-0 overflow-hidden rounded-xl ring-1 ring-black/10 hover:ring-black/20"
                                    aria-label="View image {{ $idx + 1 }}"
                                >
                                    <img src="{{ $url }}" alt="" class="h-full w-full object-cover" loading="lazy">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </article>
            @endforeach
        </div>

        @if($menus->isEmpty())
            <div class="mt-10 rounded-3xl bg-white/70 p-8 text-center shadow ring-1 ring-black/5">
                <p class="font-['Sour_Gummy'] text-lg font-bold text-[#1b1b18] lowercase">
                    no menu items yet!
                </p>
                <p class="mt-2 font-['Sour_Gummy'] text-sm text-[#5a5246] lowercase">
                    check back soon ♡
                </p>
            </div>
        @endif
    </div>
</section>

{{-- Tiny JS: per-card image carousel --}}
<script>
    document.querySelectorAll('[data-menu-card]').forEach((card) => {
        const images = JSON.parse(card.getAttribute('data-images') || '[]');
        if (!images.length) return;

        let idx = 0;
        const imgEl = card.querySelector('[data-active-img]');
        const dots = card.querySelectorAll('[data-dot]');
        const thumbs = card.querySelectorAll('[data-thumb]');

        const render = () => {
            imgEl.src = images[idx];
            dots.forEach((d, i) => d.className =
                'h-1.5 w-1.5 rounded-full ring-1 ring-black/10 ' + (i === idx ? 'bg-white' : 'bg-white/70')
            );
        };

        const prevBtn = card.querySelector('[data-prev]');
        const nextBtn = card.querySelector('[data-next]');

        prevBtn?.addEventListener('click', () => { idx = (idx - 1 + images.length) % images.length; render(); });
        nextBtn?.addEventListener('click', () => { idx = (idx + 1) % images.length; render(); });

        thumbs.forEach((btn) => {
            btn.addEventListener('click', () => {
                idx = Number(btn.getAttribute('data-thumb')) || 0;
                render();
            });
        });

        render();
    });
</script>
@endsection
