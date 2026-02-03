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
                class="group relative overflow-hidden rounded-3xl bg-white/80 p-5 shadow-xl ring-1 ring-black/5 backdrop-blur transition hover:-translate-y-0.5 hover:shadow-2xl cursor-pointer"
                data-menu-card
                data-title="{{ e($menu->title) }}"
                data-description="{{ e($menu->description ?? '') }}"
                data-price="{{ number_format((float)$menu->price, 2) }}"
                data-unit="{{ e($unitLabel) }}"
                data-images='@json($images->values()->all())'
            >

                    {{-- Cute top glow --}}
                    <div class="pointer-events-none absolute -top-24 left-1/2 h-48 w-48 -translate-x-1/2 rounded-full bg-gradient-to-r from-[#FFC447]/40 to-[#F46EE5]/40 blur-3xl"></div>
                    <div class="pointer-events-none absolute inset-0 opacity-0 transition group-hover:opacity-100">
                        <div class="absolute inset-0 bg-white/20"></div>
                        <div class="absolute bottom-4 right-4 rounded-full bg-white/90 px-4 py-2 font-['Sour_Gummy'] text-sm font-extrabold lowercase text-[#1b1b18] shadow">
                            view ♡
                        </div>
                    </div>
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
{{-- Modal --}}
<div id="menuModal" class="fixed inset-0 z-50 hidden">
    {{-- Backdrop --}}
    <div id="menuModalBackdrop" class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>

    {{-- Panel --}}
    <div class="relative mx-auto flex min-h-screen max-w-4xl items-center px-4 py-10">
        <div class="w-full overflow-hidden rounded-3xl bg-white shadow-2xl ring-1 ring-black/10">
            <div class="flex items-center justify-between border-b border-black/5 px-6 py-4">
                <div class="min-w-0">
                    <h3 id="menuModalTitle" class="font-['Sour_Gummy'] text-2xl font-extrabold lowercase text-[#1b1b18] truncate">
                        title
                    </h3>
                    <p id="menuModalMeta" class="mt-1 font-['Sour_Gummy'] text-sm font-bold lowercase text-[#5a5246]">
                        $0.00 / unit
                    </p>
                </div>

                <button id="menuModalClose"
                        class="rounded-full bg-white px-4 py-2 font-['Sour_Gummy'] text-sm font-extrabold lowercase text-[#1b1b18] shadow ring-1 ring-black/10 hover:bg-rose-50">
                    close ✕
                </button>
            </div>

            <div class="grid grid-cols-1 gap-6 p-6 md:grid-cols-2">
                {{-- Big image --}}
                <div>
                    <div class="relative aspect-square overflow-hidden rounded-3xl bg-rose-50 ring-1 ring-black/5">
                        <img id="menuModalImg"
                             src=""
                             alt=""
                             class="h-full w-full object-cover"
                        >

                        <button type="button" id="menuModalPrev"
                                class="absolute left-3 top-1/2 -translate-y-1/2 rounded-full bg-white/90 px-3 py-2 font-bold shadow ring-1 ring-black/10 hover:bg-white">
                            ‹
                        </button>
                        <button type="button" id="menuModalNext"
                                class="absolute right-3 top-1/2 -translate-y-1/2 rounded-full bg-white/90 px-3 py-2 font-bold shadow ring-1 ring-black/10 hover:bg-white">
                            ›
                        </button>
                    </div>

                    <div id="menuModalThumbs" class="mt-3 flex gap-2 overflow-x-auto pb-1"></div>
                </div>

                {{-- Details --}}
                <div>
                    <p id="menuModalDesc"
                       class="font-['Sour_Gummy'] text-base leading-relaxed text-[#5a5246] lowercase">
                    </p>

                    <div class="mt-5 flex items-center gap-2">
                        <span id="menuModalPrice"
                              class="inline-flex items-center rounded-full bg-gradient-to-r from-[#FFC447] to-[#F46EE5] px-4 py-2 text-base font-extrabold text-[#1b1b18] shadow">
                            $0.00
                        </span>
                        <span id="menuModalUnit"
                              class="font-['Sour_Gummy'] text-base font-bold text-[#1b1b18] lowercase">
                            / unit
                        </span>
                    </div>

                    <a id="menuModalOrderLink"
                       href="{{ route('order-form') }}"
                       class="mt-6 inline-flex w-full items-center justify-center rounded-full bg-gradient-to-r from-[#8f7cfa] to-[#f46ee5] px-10 py-3 text-lg font-bold tracking-wide text-white shadow-xl transition hover:scale-[1.02]">
                        order this ♡
                    </a>

                    <p class="mt-3 text-center font-['Sour_Gummy'] text-xs font-bold lowercase text-[#5a5246]/70">
                        message us with the item name if you want custom changes ♡
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
(() => {
  const modal = document.getElementById('menuModal');
  const backdrop = document.getElementById('menuModalBackdrop');
  const closeBtn = document.getElementById('menuModalClose');

  const titleEl = document.getElementById('menuModalTitle');
  const metaEl = document.getElementById('menuModalMeta');
  const descEl = document.getElementById('menuModalDesc');
  const priceEl = document.getElementById('menuModalPrice');
  const unitEl = document.getElementById('menuModalUnit');

  const imgEl = document.getElementById('menuModalImg');
  const thumbsEl = document.getElementById('menuModalThumbs');
  const prevBtn = document.getElementById('menuModalPrev');
  const nextBtn = document.getElementById('menuModalNext');

  let images = [];
  let idx = 0;

  const open = () => {
    modal.classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
  };

  const close = () => {
    modal.classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
  };

  const render = () => {
    if (!images.length) return;

    imgEl.src = images[idx];
    imgEl.alt = titleEl.textContent || 'menu item image';

    // thumbs
    thumbsEl.innerHTML = '';
    images.forEach((url, i) => {
      const btn = document.createElement('button');
      btn.type = 'button';
      btn.className =
        'h-14 w-14 shrink-0 overflow-hidden rounded-2xl ring-1 ring-black/10 hover:ring-black/20 ' +
        (i === idx ? 'ring-black/30' : '');
      btn.innerHTML = `<img src="${url}" class="h-full w-full object-cover" loading="lazy" alt="">`;
      btn.addEventListener('click', () => { idx = i; render(); });
      thumbsEl.appendChild(btn);
    });

    // hide arrows if 1 image
    const showArrows = images.length > 1;
    prevBtn.style.display = showArrows ? 'block' : 'none';
    nextBtn.style.display = showArrows ? 'block' : 'none';
  };

  prevBtn.addEventListener('click', () => {
    idx = (idx - 1 + images.length) % images.length;
    render();
  });

  nextBtn.addEventListener('click', () => {
    idx = (idx + 1) % images.length;
    render();
  });

  closeBtn.addEventListener('click', close);
  backdrop.addEventListener('click', close);

  document.addEventListener('keydown', (e) => {
    if (modal.classList.contains('hidden')) return;
    if (e.key === 'Escape') close();
    if (e.key === 'ArrowLeft' && images.length > 1) prevBtn.click();
    if (e.key === 'ArrowRight' && images.length > 1) nextBtn.click();
  });

  // Open on card click
  document.querySelectorAll('[data-menu-card]').forEach((card) => {
    card.addEventListener('click', (e) => {
      // Don't trigger when clicking carousel buttons inside the small card
      if (e.target.closest('button')) return;

      const title = card.getAttribute('data-title') || '';
      const desc = card.getAttribute('data-description') || '';
      const price = card.getAttribute('data-price') || '';
      const unit = card.getAttribute('data-unit') || '';
      const imgs = JSON.parse(card.getAttribute('data-images') || '[]');

      titleEl.textContent = title;
      descEl.textContent = desc || 'a sweet lil treat ♡';
      priceEl.textContent = `$${price}`;
      unitEl.textContent = `/ ${unit}`;
      metaEl.textContent = `$${price} / ${unit}`;

      images = imgs.length ? imgs : [];
      idx = 0;

      // fallback if no images
      if (!images.length) {
        images = ['https://via.placeholder.com/800x800?text=littobaker'];
      }

      render();
      open();
    });
  });
})();
</script>

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
