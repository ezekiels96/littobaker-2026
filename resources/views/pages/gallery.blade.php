@extends('layouts.app')

@section('content')
@php
    $bg = 'bg-gradient-to-b from-rose-50 via-pink-50 to-amber-50';
@endphp

<section class="relative left-1/2 w-screen -translate-x-1/2 {{ $bg }} px-6 py-14 md:px-12">
    <div class="mx-auto max-w-6xl">
        {{-- Header --}}
        <div class="mb-10 text-center">
            <h1 class="font-['Sour_Gummy'] text-5xl font-extrabold text-[#1b1b18] drop-shadow-lg md:text-6xl lowercase">
                gallery
            </h1>
            <p class="mt-3 font-['Sour_Gummy'] text-base text-[#5a5246] lowercase">
                a peek at our bakes + custom orders ♡
            </p>
        </div>

        {{-- Controls --}}
        <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            {{-- Search --}}
            <div class="relative w-full md:max-w-md">
                <div class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-[#5a5246]/70">🔎</div>
                <input
                    id="gallerySearch"
                    type="text"
                    placeholder="search by title, caption, tag..."
                    class="w-full rounded-full bg-white/80 px-12 py-3 font-['Sour_Gummy'] text-sm font-bold lowercase
                           text-[#1b1b18] shadow ring-1 ring-black/5 outline-none
                           focus:bg-white focus:ring-2 focus:ring-[#F46EE5]/30"
                >
            </div>

            {{-- Active tag pill --}}
            <div class="flex items-center justify-between gap-3">
                <div id="activeTagPill" class="hidden rounded-full bg-white/80 px-4 py-2 font-['Sour_Gummy'] text-sm font-extrabold lowercase text-[#1b1b18] shadow ring-1 ring-black/5">
                    tag: <span id="activeTagName" class="ml-1 text-[#F53003]"></span>
                    <button id="clearTag" type="button" class="ml-3 rounded-full bg-black/5 px-2 py-1 text-xs font-extrabold hover:bg-black/10">x</button>
                </div>
            </div>
        </div>

        {{-- Tag chips --}}
        <div class="mb-8 flex flex-wrap gap-2">
            <button
                type="button"
                data-tag=""
                class="tag-chip rounded-full bg-white/80 px-4 py-2 font-['Sour_Gummy'] text-sm font-extrabold lowercase
                       text-[#1b1b18] shadow ring-1 ring-black/5 transition hover:-translate-y-0.5 hover:bg-white"
            >
                all
            </button>

            @foreach($tags as $tag)
                <button
                    type="button"
                    data-tag="{{ strtolower($tag->name) }}"
                    class="tag-chip rounded-full bg-white/70 px-4 py-2 font-['Sour_Gummy'] text-sm font-extrabold lowercase
                           text-[#1b1b18] shadow ring-1 ring-black/5 transition hover:-translate-y-0.5 hover:bg-white"
                >
                    {{ $tag->name }}
                </button>
            @endforeach
        </div>

        {{-- Grid --}}
        <div id="galleryGrid" class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse($items as $item)
                @php
                    $itemTags = $item->tags?->pluck('name')->map(fn($t) => strtolower($t))->values() ?? collect();
                    $title = $item->title ?? '';
                    $caption = $item->caption ?? '';
                    $img = $item->image_url;
                @endphp

                <article
                    class="gallery-card group relative overflow-hidden rounded-3xl bg-white/80 shadow-xl ring-1 ring-black/5 backdrop-blur
                           transition hover:-translate-y-0.5 hover:shadow-2xl cursor-pointer"
                    data-title="{{ strtolower($title) }}"
                    data-caption="{{ strtolower($caption) }}"
                    data-tags="{{ e($itemTags->implode(',')) }}"
                    data-img="{{ e($img) }}"
                    data-fulltitle="{{ e($title) }}"
                    data-fullcaption="{{ e($caption) }}"
                >
                    {{-- glow --}}
                    <div class="pointer-events-none absolute -top-24 left-1/2 h-48 w-48 -translate-x-1/2 rounded-full bg-gradient-to-r from-[#FFC447]/35 to-[#F46EE5]/30 blur-3xl"></div>

                    <div class="relative aspect-square overflow-hidden">
                        <img
                            src="{{ $img }}"
                            alt="{{ $title ?: 'gallery image' }}"
                            class="h-full w-full object-cover transition duration-300 group-hover:scale-105"
                            loading="lazy"
                            onerror="this.style.display='none'; this.parentElement.classList.add('bg-gradient-to-br','from-rose-100','via-pink-50','to-amber-50');"
                        >

                        <div class="absolute inset-0 flex items-center justify-center bg-black/35 opacity-0 transition group-hover:opacity-100">
                            <span class="rounded-full bg-white/90 px-4 py-2 font-['Sour_Gummy']
                                         text-sm font-extrabold lowercase text-[#1b1b18] shadow">
                                view ♡
                            </span>
                        </div>
                    </div>

                    <div class="p-5">
                        <div class="font-['Sour_Gummy'] text-lg font-extrabold lowercase text-[#1b1b18]">
                            {{ $title ?: 'sweet treat ♡' }}
                        </div>

                        @if(!empty($caption))
                            <div class="mt-1 line-clamp-2 font-['Sour_Gummy'] text-sm font-bold lowercase text-[#5a5246]">
                                {{ $caption }}
                            </div>
                        @else
                            <div class="mt-1 font-['Sour_Gummy'] text-sm font-bold lowercase text-[#5a5246]/70">
                                tap to view closer ♡
                            </div>
                        @endif

                        @if($itemTags->isNotEmpty())
                            <div class="mt-3 flex flex-wrap gap-1.5">
                                @foreach($itemTags->take(3) as $t)
                                    <span class="rounded-full bg-white/80 px-3 py-1 text-xs font-extrabold lowercase text-[#1b1b18] ring-1 ring-black/5">
                                        {{ $t }}
                                    </span>
                                @endforeach
                                @if($itemTags->count() > 3)
                                    <span class="rounded-full bg-white/60 px-3 py-1 text-xs font-extrabold lowercase text-[#5a5246] ring-1 ring-black/5">
                                        +{{ $itemTags->count() - 3 }}
                                    </span>
                                @endif
                            </div>
                        @endif
                    </div>
                </article>
            @empty
                <div class="col-span-full rounded-3xl bg-white/70 p-8 text-center shadow ring-1 ring-black/5">
                    <p class="font-['Sour_Gummy'] text-lg font-bold text-[#1b1b18] lowercase">
                        no gallery items yet!
                    </p>
                    <p class="mt-2 font-['Sour_Gummy'] text-sm text-[#5a5246] lowercase">
                        check back soon ♡
                    </p>
                </div>
            @endforelse
        </div>

        {{-- Empty results message --}}
        <div id="noResults" class="hidden mt-8 rounded-3xl bg-white/70 p-8 text-center shadow ring-1 ring-black/5">
            <p class="font-['Sour_Gummy'] text-lg font-bold text-[#1b1b18] lowercase">
                no matches 🥲
            </p>
            <p class="mt-2 font-['Sour_Gummy'] text-sm text-[#5a5246] lowercase">
                try a different tag or search term ♡
            </p>
        </div>
    </div>
</section>

{{-- Modal / Lightbox --}}
<div id="galleryModal" class="fixed inset-0 z-[60] hidden">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" data-close></div>

    <div class="relative mx-auto flex min-h-screen max-w-4xl items-center px-6 py-10">
        <div class="relative w-full overflow-hidden rounded-3xl bg-white shadow-2xl ring-1 ring-black/10">
            <button
                type="button"
                class="absolute right-4 top-4 z-10 rounded-full bg-white/90 px-3 py-2 font-['Sour_Gummy'] text-sm font-extrabold lowercase text-[#1b1b18] shadow hover:bg-white"
                data-close
            >
                close ✕
            </button>

            <div class="grid grid-cols-1 lg:grid-cols-2">
                <div class="relative bg-black/5">
                    <img id="modalImg" src="" alt="" class="h-full w-full object-cover lg:h-[520px]">

                    <button id="modalPrev" type="button"
                            class="absolute left-3 top-1/2 -translate-y-1/2 rounded-full bg-white/90 px-3 py-2 font-bold shadow hover:bg-white">
                        ‹
                    </button>
                    <button id="modalNext" type="button"
                            class="absolute right-3 top-1/2 -translate-y-1/2 rounded-full bg-white/90 px-3 py-2 font-bold shadow hover:bg-white">
                        ›
                    </button>
                </div>

                <div class="p-6">
                    <div id="modalTitle" class="font-['Sour_Gummy'] text-3xl font-extrabold lowercase text-[#1b1b18]">
                        sweet treat ♡
                    </div>
                    <div id="modalCaption" class="mt-2 font-['Sour_Gummy'] text-base font-bold lowercase text-[#5a5246]">
                    </div>

                    <div id="modalTags" class="mt-5 flex flex-wrap gap-2"></div>

                    <div class="mt-6">
                        <button type="button" data-close
                                class="rounded-full bg-gradient-to-r from-[#FFC447] to-[#F46EE5]
                                       px-8 py-3 font-['Sour_Gummy'] text-sm font-extrabold lowercase text-[#1b1b18] shadow transition hover:scale-105">
                            done ♡
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- JS: live filter + modal --}}
<script>
(() => {
    const searchEl = document.getElementById('gallerySearch');
    const chips = document.querySelectorAll('.tag-chip');
    const cards = Array.from(document.querySelectorAll('.gallery-card'));
    const noResults = document.getElementById('noResults');

    const activePill = document.getElementById('activeTagPill');
    const activeName = document.getElementById('activeTagName');
    const clearTag = document.getElementById('clearTag');

    let activeTag = '';
    let visibleCards = cards;
    let modalIndex = 0;

    // Modal elements
    const modal = document.getElementById('galleryModal');
    const modalImg = document.getElementById('modalImg');
    const modalTitle = document.getElementById('modalTitle');
    const modalCaption = document.getElementById('modalCaption');
    const modalTags = document.getElementById('modalTags');
    const modalPrev = document.getElementById('modalPrev');
    const modalNext = document.getElementById('modalNext');

    const normalize = (s) => (s || '').toLowerCase().trim();

    const setChipActiveStyles = () => {
        chips.forEach(chip => {
            const tag = chip.getAttribute('data-tag') || '';
            const isActive = tag === activeTag;
            chip.classList.toggle('bg-white', isActive);
            chip.classList.toggle('bg-white/70', !isActive);
            chip.classList.toggle('ring-2', isActive);
            chip.classList.toggle('ring-[#F46EE5]/30', isActive);
        });

        if (activeTag) {
            activePill.classList.remove('hidden');
            activeName.textContent = activeTag;
        } else {
            activePill.classList.add('hidden');
            activeName.textContent = '';
        }
    };

    const applyFilter = () => {
        const q = normalize(searchEl.value);
        visibleCards = [];

        cards.forEach(card => {
            const title = normalize(card.dataset.title);
            const caption = normalize(card.dataset.caption);
            const tags = normalize(card.dataset.tags); // csv string
            const matchesTag = !activeTag || tags.split(',').includes(activeTag);
            const matchesText = !q || title.includes(q) || caption.includes(q) || tags.includes(q);

            const show = matchesTag && matchesText;
            card.style.display = show ? '' : 'none';
            if (show) visibleCards.push(card);
        });

        noResults.classList.toggle('hidden', visibleCards.length > 0);
    };

    // chip clicks
    chips.forEach(chip => {
        chip.addEventListener('click', () => {
            activeTag = normalize(chip.getAttribute('data-tag') || '');
            setChipActiveStyles();
            applyFilter();
        });
    });

    clearTag?.addEventListener('click', () => {
        activeTag = '';
        setChipActiveStyles();
        applyFilter();
    });

    searchEl?.addEventListener('input', applyFilter);

    // Modal helpers
    const openModalAt = (idx) => {
        if (!visibleCards.length) return;
        modalIndex = Math.max(0, Math.min(idx, visibleCards.length - 1));

        const card = visibleCards[modalIndex];
        const img = card.dataset.img;
        const title = card.dataset.fulltitle || 'sweet treat ♡';
        const caption = card.dataset.fullcaption || '';
        const tagsCsv = (card.dataset.tags || '').split(',').filter(Boolean);

        modalImg.src = img;
        modalTitle.textContent = title || 'sweet treat ♡';
        modalCaption.textContent = caption || '♡';

        modalTags.innerHTML = '';
        tagsCsv.forEach(t => {
            const span = document.createElement('span');
            span.className = 'rounded-full bg-white/80 px-3 py-1 text-xs font-extrabold lowercase text-[#1b1b18] ring-1 ring-black/5';
            span.textContent = t;
            modalTags.appendChild(span);
        });

        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    };

    const closeModal = () => {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    };

    const prev = () => openModalAt((modalIndex - 1 + visibleCards.length) % visibleCards.length);
    const next = () => openModalAt((modalIndex + 1) % visibleCards.length);

    // open modal on card click
    cards.forEach(card => {
        card.addEventListener('click', () => {
            // find visible index
            const idx = visibleCards.indexOf(card);
            openModalAt(idx >= 0 ? idx : 0);
        });
    });

    modalPrev?.addEventListener('click', prev);
    modalNext?.addEventListener('click', next);

    // close on overlay / close buttons
    modal.querySelectorAll('[data-close]').forEach(el => el.addEventListener('click', closeModal));

    // keyboard
    window.addEventListener('keydown', (e) => {
        if (modal.classList.contains('hidden')) return;
        if (e.key === 'Escape') closeModal();
        if (e.key === 'ArrowLeft') prev();
        if (e.key === 'ArrowRight') next();
    });

    // init
    setChipActiveStyles();
    applyFilter();
})();
</script>
@endsection
