@extends('layouts.app')

@section('content')
@php
    $bg = 'bg-gradient-to-b from-rose-50 via-pink-50 to-amber-50';
@endphp

<section class="relative left-1/2 w-screen -translate-x-1/2 {{ $bg }} px-6 py-16 md:px-12">
    <div class="mx-auto max-w-6xl">

        {{-- Header --}}
        <div class="mb-10 text-center">
            <h1 class="font-['Sour_Gummy'] text-5xl font-extrabold text-[#1b1b18] drop-shadow-lg md:text-6xl lowercase">
                order form
            </h1>
            <p class="mt-3 font-['Sour_Gummy'] text-base text-[#5a5246] lowercase">
                browse below, add to cart, and we'll make your treats ♡
            </p>
            <div class="mt-4 flex flex-col items-center gap-3">
                <div class="inline-flex items-center gap-2 rounded-full border border-black/5 bg-white/70 px-5 py-2 text-xs font-semibold text-[#706f6c] shadow">
                    <span>🛒</span>
                    <span>click the cart button to review your order</span>
                </div>
                <div class="inline-flex flex-col items-center gap-1.5 rounded-2xl border border-black/5 bg-white/70 px-5 py-3 text-xs font-semibold text-[#706f6c] shadow">
                    <span>must place your order 48 hours in advance of pickup</span>
                    <span>pick up location will be sent the day of pickup or delivery service is available with fee</span>
                </div>
            </div>
        </div>

        <div class="mb-6 w-full max-w-md">
            <div class="relative">
                <div class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-[#5a5246]/70">🔎</div>
                <input
                    id="orderSearch"
                    type="text"
                    placeholder="search the menu..."
                    class="w-full rounded-full bg-white/80 px-12 py-3 font-['Sour_Gummy'] text-sm font-bold lowercase
                           text-[#1b1b18] shadow ring-1 ring-black/5 outline-none pr-12
                           focus:bg-white focus:ring-2 focus:ring-[#F46EE5]/30"
                >
                <button
                    id="clearOrderSearch"
                    type="button"
                    aria-label="clear search"
                    class="absolute right-3 top-1/2 hidden -translate-y-1/2 rounded-full bg-black/5 px-2 py-1
                           text-xs font-extrabold text-[#1b1b18] hover:bg-black/10"
                >
                    ✕
                </button>
            </div>
        </div>

        {{-- Menu Grid --}}
        <div id="orderGrid" class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($menus as $menu)
                @php
                    $images = $menu->images?->pluck('image_url')->filter()->values() ?? collect();
                    $first = $images->first() ?? null;
                    $unitLabel = match($menu->quantity_type) {
                        'dozen'  => 'dozen',
                        'pieces' => 'pieces',
                        'order'  => 'order',
                        default  => $menu->quantity_type,
                    };
                @endphp

                <article
                    class="order-card relative overflow-hidden rounded-3xl bg-white/90 shadow-xl ring-1 ring-black/5 backdrop-blur transition hover:-translate-y-0.5 hover:shadow-2xl flex flex-col"
                    data-title="{{ strtolower($menu->title) }}"
                    data-description="{{ strtolower($menu->description ?? '') }}"
                >

                    {{-- Glow --}}
                    <div class="pointer-events-none absolute -top-20 left-1/2 h-40 w-40 -translate-x-1/2 rounded-full bg-gradient-to-r from-[#FFC447]/30 to-[#F46EE5]/30 blur-3xl"></div>

                    {{-- Image --}}
                    <div class="relative h-48 w-full overflow-hidden rounded-t-3xl bg-rose-50">
                        @if($first)
                            <img src="{{ $first }}" alt="{{ $menu->title }}"
                                 class="h-full w-full object-cover">
                        @else
                            <div class="flex h-full w-full items-center justify-center text-6xl">🍰</div>
                        @endif
                        {{-- Price badge --}}
                        <div class="absolute bottom-3 left-3">
                            <span class="inline-flex items-center rounded-full bg-gradient-to-r from-[#FFC447] to-[#F46EE5] px-3 py-1 text-sm font-extrabold text-[#1b1b18] shadow">
                                ${{ number_format((float)$menu->price, 2) }}
                            </span>
                            <span class="ml-1 font-['Sour_Gummy'] text-xs font-bold text-white drop-shadow lowercase">
                                / {{ $unitLabel }}
                            </span>
                        </div>
                    </div>

                    {{-- Body --}}
                    <div class="flex flex-1 flex-col p-5">
                        <h2 class="font-['Sour_Gummy'] text-xl font-extrabold lowercase tracking-wide text-[#1b1b18]">
                            {{ $menu->title }}
                        </h2>
                        @if(!empty($menu->description))
                            <p class="mt-1 font-['Sour_Gummy'] text-sm leading-relaxed text-[#5a5246] lowercase line-clamp-3">
                                {{ $menu->description }}
                            </p>
                        @else
                            <p class="mt-1 font-['Sour_Gummy'] text-sm text-[#5a5246]/70 lowercase">a sweet lil treat ♡</p>
                        @endif

                        {{-- Add to Cart Controls --}}
                        <div class="mt-4 pt-4 border-t border-black/5 space-y-3">

                            {{-- Quantity --}}
                            <div class="flex items-center gap-3">
                                <label class="font-['Sour_Gummy'] text-xs font-bold lowercase text-[#706f6c] shrink-0">qty:</label>
                                <div class="flex items-center rounded-full border border-black/10 bg-white shadow-sm">
                                    <button type="button"
                                            class="qty-dec h-8 w-8 rounded-full font-bold text-[#1b1b18] hover:bg-rose-50 transition text-lg leading-none"
                                            data-menu-id="{{ $menu->id }}">−</button>
                                    <span class="qty-display font-['Sour_Gummy'] w-8 text-center text-sm font-extrabold text-[#1b1b18]"
                                          data-menu-id="{{ $menu->id }}">1</span>
                                    <button type="button"
                                            class="qty-inc h-8 w-8 rounded-full font-bold text-[#1b1b18] hover:bg-rose-50 transition text-lg leading-none"
                                            data-menu-id="{{ $menu->id }}">+</button>
                                </div>
                            </div>

                            {{-- Notes toggle --}}
                            <button type="button"
                                    class="notes-toggle font-['Sour_Gummy'] text-xs font-bold lowercase text-[#9a8e86] hover:text-[#F46EE5] transition"
                                    data-menu-id="{{ $menu->id }}">
                                + add a note / special request
                            </button>
                            <textarea
                                class="notes-field hidden w-full rounded-2xl border border-black/10 bg-white/70 px-4 py-2.5 text-sm text-[#1b1b18] placeholder:text-[#a09880] focus:outline-none focus:ring-2 focus:ring-[#F46EE5]/50 resize-none"
                                data-menu-id="{{ $menu->id }}"
                                rows="2"
                                placeholder="any allergies, preferences, or special requests ♡"></textarea>

                            {{-- Add Button --}}
                            <button type="button"
                                    class="add-btn w-full rounded-full bg-gradient-to-r from-[#8f7cfa] to-[#f46ee5] px-4 py-2.5 font-['Sour_Gummy'] text-sm font-extrabold lowercase text-white shadow-lg transition hover:scale-[1.02] active:scale-95"
                                    data-menu-id="{{ $menu->id }}">
                                add to cart 🛒
                            </button>

                            {{-- Feedback toast --}}
                            <div class="add-feedback hidden rounded-2xl bg-emerald-50 px-4 py-2 text-center font-['Sour_Gummy'] text-xs font-bold lowercase text-emerald-600"
                                 data-menu-id="{{ $menu->id }}">
                                added! ♡
                            </div>

                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        @if($menus->isEmpty())
            <div class="mt-10 rounded-3xl bg-white/70 p-8 text-center shadow ring-1 ring-black/5">
                <p class="font-['Sour_Gummy'] text-lg font-bold text-[#1b1b18] lowercase">no menu items yet!</p>
                <p class="mt-2 font-['Sour_Gummy'] text-sm text-[#5a5246] lowercase">check back soon ♡</p>
            </div>
        @endif

        <div id="orderNoResults" class="hidden mt-10 rounded-3xl bg-white/70 p-8 text-center shadow ring-1 ring-black/5">
            <p class="font-['Sour_Gummy'] text-lg font-bold text-[#1b1b18] lowercase">no matches 🥲</p>
            <p class="mt-2 font-['Sour_Gummy'] text-sm text-[#5a5246] lowercase">try a different search ♡</p>
        </div>

    </div>
</section>

<script>
(() => {
    // Order search
    const orderSearch = document.getElementById('orderSearch');
    const clearOrderSearch = document.getElementById('clearOrderSearch');
    const orderCards = Array.from(document.querySelectorAll('.order-card'));
    const orderNoResults = document.getElementById('orderNoResults');

    const normalize = (s) => (s || '').toLowerCase().trim();

    const updateClearOrderSearch = () => {
        const hasQuery = normalize(orderSearch?.value).length > 0;
        clearOrderSearch?.classList.toggle('hidden', !hasQuery);
    };

    const applyOrderFilter = () => {
        const q = normalize(orderSearch?.value);
        let visible = 0;

        orderCards.forEach(card => {
            const title = normalize(card.dataset.title);
            const desc = normalize(card.dataset.description);
            const show = !q || title.includes(q) || desc.includes(q);
            card.style.display = show ? '' : 'none';
            if (show) visible += 1;
        });

        orderNoResults?.classList.toggle('hidden', visible > 0);
        updateClearOrderSearch();
    };

    orderSearch?.addEventListener('input', applyOrderFilter);
    clearOrderSearch?.addEventListener('click', () => {
        orderSearch.value = '';
        applyOrderFilter();
        orderSearch.focus();
    });

    applyOrderFilter();

    // Quantity controls
    const quantities = {};

    document.querySelectorAll('.qty-dec').forEach(btn => {
        const id = btn.dataset.menuId;
        if (!quantities[id]) quantities[id] = 1;
        btn.addEventListener('click', () => {
            quantities[id] = Math.max(1, (quantities[id] || 1) - 1);
            document.querySelector(`.qty-display[data-menu-id="${id}"]`).textContent = quantities[id];
        });
    });

    document.querySelectorAll('.qty-inc').forEach(btn => {
        const id = btn.dataset.menuId;
        if (!quantities[id]) quantities[id] = 1;
        btn.addEventListener('click', () => {
            quantities[id] = Math.min(100, (quantities[id] || 1) + 1);
            document.querySelector(`.qty-display[data-menu-id="${id}"]`).textContent = quantities[id];
        });
    });

    // Notes toggle
    document.querySelectorAll('.notes-toggle').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.menuId;
            const field = document.querySelector(`.notes-field[data-menu-id="${id}"]`);
            field.classList.toggle('hidden');
            btn.textContent = field.classList.contains('hidden')
                ? '+ add a note / special request'
                : '− hide note';
        });
    });

    // Add to cart
    document.querySelectorAll('.add-btn').forEach(btn => {
        btn.addEventListener('click', async () => {
            const id       = btn.dataset.menuId;
            const qty      = quantities[id] || 1;
            const notesEl  = document.querySelector(`.notes-field[data-menu-id="${id}"]`);
            const notes    = notesEl ? notesEl.value.trim() : '';
            const feedback = document.querySelector(`.add-feedback[data-menu-id="${id}"]`);

            btn.disabled = true;
            btn.textContent = 'adding…';

            try {
                const data = await window.addToCart(id, qty, notes);
                if (data.success) {
                    btn.textContent = 'added! ♡';
                    btn.classList.remove('from-[#8f7cfa]', 'to-[#f46ee5]');
                    btn.classList.add('from-[#FFC447]', 'to-[#F46EE5]', 'text-[#1b1b18]');
                    feedback.classList.remove('hidden');
                    setTimeout(() => {
                        btn.disabled = false;
                        btn.textContent = 'add to cart 🛒';
                        btn.classList.add('from-[#8f7cfa]', 'to-[#f46ee5]');
                        btn.classList.remove('from-[#FFC447]', 'to-[#F46EE5]', 'text-[#1b1b18]');
                        btn.classList.add('text-white');
                        feedback.classList.add('hidden');
                    }, 2000);
                }
            } catch (e) {
                btn.disabled = false;
                btn.textContent = 'add to cart 🛒';
            }
        });
    });
})();
</script>
@endsection
