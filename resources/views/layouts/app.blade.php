<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $title ?? 'littobaker' }} - Home Bakery Sunnyvale, CA</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        <!-- Google Fonts: Sour Gummy -->
        <link href="https://fonts.googleapis.com/css2?family=Sour+Gummy&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#FDFDFC] text-[#1b1b18] font-['Instrument_Sans']">

        <!-- Hero Section -->
        <section class="bg-gradient-to-b from-[#f7f3ef] to-[#fffaf6] px-4 py-12 text-center">
            <div class="mx-auto flex max-w-3xl flex-wrap items-center justify-center gap-6">
                <div class="flex h-24 w-24 items-center justify-center rounded-full bg-[#FFE5E5] text-4xl text-[#F53003] shadow-inner">
                    🍪
                </div>
                <div class="text-left">
                    <p class="text-xs uppercase tracking-[0.45em] text-[#706f6c]">Home Bakery</p>
                    <h1 class="text-4xl font-semibold tracking-tight text-[#1b1b18] sm:text-5xl">littobaker</h1>
                </div>
            </div>
            <p class="mt-4 text-xs uppercase tracking-[0.35em] text-[#706f6c]">HOME BAKERY SUNNYVALE, CA</p>
        </section>

        <!-- Navigation Menu -->
        <nav class="sticky top-0 z-30 border-b border-[#e3e3e0] bg-white shadow-sm">
            <div class="mx-auto max-w-4xl">
                <div class="flex items-center justify-between px-4 py-3 md:hidden">
                    <button id="mobileMenuToggle"
                            class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-black/10 bg-white text-[#1b1b18] shadow-sm transition hover:bg-[#fdf7f3]"
                            aria-label="Toggle navigation menu"
                            aria-expanded="false"
                            aria-controls="mobileMenuPanel">
                        <svg id="menuOpenIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M4 12h16M4 17h16" />
                        </svg>
                        <svg id="menuCloseIcon" xmlns="http://www.w3.org/2000/svg" class="hidden h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <a href="{{ route('home') }}" class="font-semibold uppercase tracking-[0.28em] text-[11px] text-[#1b1b18]">littobaker</a>

                    <button class="cart-toggle inline-flex items-center gap-1.5 rounded-full bg-gradient-to-r from-[#FFC447] to-[#F46EE5] px-3 py-1.5 text-xs font-bold text-[#1b1b18] shadow transition hover:scale-105 hover:shadow-md"
                            aria-label="Open cart">
                        <span class="text-sm">🛒</span>
                        <span class="min-w-[18px] rounded-full bg-[#1b1b18] px-1.5 py-0.5 text-center text-[10px] font-bold text-white cart-badge">
                            {{ count(session('cart', [])) > 0 ? array_sum(array_column(session('cart', []), 'quantity')) : '0' }}
                        </span>
                    </button>
                </div>

                <div id="mobileMenuPanel" class="hidden border-t border-black/5 bg-[#fffaf6] px-4 pb-4 md:hidden">
                    <div class="grid gap-1 pt-3">
                        <a href="{{ route('home') }}" @class([
                            'rounded-2xl px-4 py-3 text-xs font-semibold uppercase tracking-[0.25em] transition',
                            'bg-white text-[#F53003] ring-1 ring-[#F53003]/20' => Route::is('home'),
                            'text-[#1b1b18] hover:bg-white/80' => ! Route::is('home'),
                        ])>Home</a>
                        <a href="{{ route('about') }}" @class([
                            'rounded-2xl px-4 py-3 text-xs font-semibold uppercase tracking-[0.25em] transition',
                            'bg-white text-[#F53003] ring-1 ring-[#F53003]/20' => Route::is('about'),
                            'text-[#1b1b18] hover:bg-white/80' => ! Route::is('about'),
                        ])>About</a>
                        <a href="{{ route('menu.index') }}" @class([
                            'rounded-2xl px-4 py-3 text-xs font-semibold uppercase tracking-[0.25em] transition',
                            'bg-white text-[#F53003] ring-1 ring-[#F53003]/20' => Route::is('menu') || Route::is('menu.*'),
                            'text-[#1b1b18] hover:bg-white/80' => ! (Route::is('menu') || Route::is('menu.*')),
                        ])>Menu</a>
                        <a href="{{ route('gallery') }}" @class([
                            'rounded-2xl px-4 py-3 text-xs font-semibold uppercase tracking-[0.25em] transition',
                            'bg-white text-[#F53003] ring-1 ring-[#F53003]/20' => Route::is('gallery'),
                            'text-[#1b1b18] hover:bg-white/80' => ! Route::is('gallery'),
                        ])>Gallery</a>
                        <a href="{{ route('order-form') }}" @class([
                            'rounded-2xl px-4 py-3 text-xs font-semibold uppercase tracking-[0.25em] transition',
                            'bg-white text-[#F53003] ring-1 ring-[#F53003]/20' => Route::is('order-form'),
                            'text-[#1b1b18] hover:bg-white/80' => ! Route::is('order-form'),
                        ])>Order Form</a>
                        <a href="{{ route('contact') }}" @class([
                            'rounded-2xl px-4 py-3 text-xs font-semibold uppercase tracking-[0.25em] transition',
                            'bg-white text-[#F53003] ring-1 ring-[#F53003]/20' => Route::is('contact'),
                            'text-[#1b1b18] hover:bg-white/80' => ! Route::is('contact'),
                        ])>Contact</a>
                    </div>
                </div>

                <div class="relative hidden flex-wrap items-center justify-center md:flex">
                    <a href="{{ route('home') }}" @class([
                        'px-6 py-4 text-xs font-semibold uppercase tracking-[0.25em] transition duration-200 border-b-2',
                        'text-[#F53003] border-[#F53003]' => Route::is('home'),
                        'text-[#1b1b18] border-transparent hover:text-[#F53003]' => ! Route::is('home'),
                    ])>Home</a>
                    <a href="{{ route('about') }}" @class([
                        'px-6 py-4 text-xs font-semibold uppercase tracking-[0.25em] transition duration-200 border-b-2',
                        'text-[#F53003] border-[#F53003]' => Route::is('about'),
                        'text-[#1b1b18] border-transparent hover:text-[#F53003]' => ! Route::is('about'),
                    ])>About</a>
                    <a href="{{ route('menu.index') }}" @class([
                        'px-6 py-4 text-xs font-semibold uppercase tracking-[0.25em] transition duration-200 border-b-2',
                        'text-[#F53003] border-[#F53003]' => Route::is('menu') || Route::is('menu.*'),
                        'text-[#1b1b18] border-transparent hover:text-[#F53003]' => ! (Route::is('menu') || Route::is('menu.*')),
                    ])>Menu</a>
                    <a href="{{ route('gallery') }}" @class([
                        'px-6 py-4 text-xs font-semibold uppercase tracking-[0.25em] transition duration-200 border-b-2',
                        'text-[#F53003] border-[#F53003]' => Route::is('gallery'),
                        'text-[#1b1b18] border-transparent hover:text-[#F53003]' => ! Route::is('gallery'),
                    ])>Gallery</a>
                    <a href="{{ route('order-form') }}" @class([
                        'px-6 py-4 text-xs font-semibold uppercase tracking-[0.25em] transition duration-200 border-b-2',
                        'text-[#F53003] border-[#F53003]' => Route::is('order-form'),
                        'text-[#1b1b18] border-transparent hover:text-[#F53003]' => ! Route::is('order-form'),
                    ])>Order Form</a>
                    <a href="{{ route('contact') }}" @class([
                        'px-6 py-4 text-xs font-semibold uppercase tracking-[0.25em] transition duration-200 border-b-2',
                        'text-[#F53003] border-[#F53003]' => Route::is('contact'),
                        'text-[#1b1b18] border-transparent hover:text-[#F53003]' => ! Route::is('contact'),
                    ])>Contact</a>

                    <button class="cart-toggle absolute right-3 top-1/2 -translate-y-1/2 flex items-center gap-1.5 rounded-full bg-gradient-to-r from-[#FFC447] to-[#F46EE5] px-3 py-1.5 text-xs font-bold text-[#1b1b18] shadow transition hover:scale-105 hover:shadow-md"
                            aria-label="Open cart">
                        <span class="text-sm">🛒</span>
                        <span class="min-w-[18px] rounded-full bg-[#1b1b18] px-1.5 py-0.5 text-center text-[10px] font-bold text-white cart-badge">
                            {{ count(session('cart', [])) > 0 ? array_sum(array_column(session('cart', []), 'quantity')) : '0' }}
                        </span>
                    </button>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="mx-auto max-w-6xl px-4 pt-0">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-[#1b1b18] py-10 text-center text-sm text-white">
            <div class="mx-auto max-w-4xl space-y-2">
                <p>&copy; 2026 littobaker. All rights reserved.</p>
                <p class="text-xs uppercase tracking-[0.3em] text-white/70">Home Bakery · Sunnyvale, CA</p>
            </div>
        </footer>

        <!-- ============================================================ -->
        <!-- CART DRAWER                                                   -->
        <!-- ============================================================ -->

        <!-- Overlay -->
        <div id="cartOverlay" class="fixed inset-0 z-40 hidden bg-black/40 backdrop-blur-sm transition-opacity"></div>

        <!-- Drawer -->
        <div id="cartDrawer"
             class="fixed top-0 right-0 z-50 flex h-full w-full max-w-md flex-col bg-white shadow-2xl translate-x-full transition-transform duration-300 ease-out">

            <!-- Drawer Header -->
            <div class="flex items-center justify-between border-b border-black/5 bg-gradient-to-r from-[#fff7fb] to-[#fbf6ef] px-5 py-4">
                <div>
                    <h2 class="font-['Sour_Gummy'] text-2xl font-extrabold lowercase text-[#1b1b18]">your cart 🛒</h2>
                    <p id="cartDrawerMeta" class="font-['Sour_Gummy'] text-xs font-bold lowercase text-[#706f6c]">0 items</p>
                </div>
                <button id="cartClose"
                        class="rounded-full bg-white px-4 py-2 font-['Sour_Gummy'] text-sm font-extrabold lowercase text-[#1b1b18] shadow ring-1 ring-black/10 hover:bg-rose-50 transition">
                    close ✕
                </button>
            </div>

            <!-- Cart Items -->
            <div id="cartItems" class="flex-1 overflow-y-auto px-5 py-4 space-y-3">
                <!-- Empty state -->
                <div id="cartEmpty" class="flex flex-col items-center justify-center h-full text-center py-16">
                    <div class="text-5xl mb-4">🍪</div>
                    <p class="font-['Sour_Gummy'] text-lg font-extrabold lowercase text-[#1b1b18]">your cart is empty</p>
                    <p class="mt-1 font-['Sour_Gummy'] text-sm lowercase text-[#706f6c]">add some treats from the order form ♡</p>
                    <a href="{{ route('order-form') }}"
                       class="mt-6 inline-flex rounded-full bg-gradient-to-r from-[#FFC447] to-[#F46EE5] px-6 py-2.5 font-['Sour_Gummy'] text-sm font-extrabold lowercase text-[#1b1b18] shadow transition hover:scale-105"
                       onclick="closeCart()">
                        browse order form →
                    </a>
                </div>
            </div>

            <!-- Checkout Form + Total (hidden when empty) -->
            <div id="cartFooter" class="hidden border-t border-black/5 bg-[#fbf6ef] px-5 py-5 space-y-4">
                <!-- Total -->
                <div class="flex items-center justify-between">
                    <span class="font-['Sour_Gummy'] text-base font-extrabold lowercase text-[#1b1b18]">total</span>
                    <span id="cartTotal" class="font-['Sour_Gummy'] text-2xl font-extrabold text-[#1b1b18]">$0.00</span>
                </div>

                <!-- Checkout toggle -->
                <button id="checkoutToggle"
                        class="w-full rounded-full bg-gradient-to-r from-[#8f7cfa] to-[#f46ee5] px-6 py-3 font-['Sour_Gummy'] text-base font-extrabold lowercase text-white shadow-lg transition hover:scale-[1.02]">
                    place order ♡
                </button>

                <!-- Checkout Form -->
                <div id="checkoutForm" class="hidden space-y-3">
                    <p class="font-['Sour_Gummy'] text-xs font-bold lowercase text-[#706f6c] text-center">fill in your details and we'll be in touch!</p>
                    <div class="grid grid-cols-2 gap-2">
                        <input type="text" id="co_name" placeholder="your name *"
                               class="col-span-2 rounded-2xl border border-black/10 bg-white px-4 py-2.5 text-sm placeholder:text-[#a09880] focus:outline-none focus:ring-2 focus:ring-[#F46EE5]/50">
                        <input type="email" id="co_email" placeholder="email *"
                               class="rounded-2xl border border-black/10 bg-white px-4 py-2.5 text-sm placeholder:text-[#a09880] focus:outline-none focus:ring-2 focus:ring-[#F46EE5]/50">
                        <input type="tel" id="co_phone" placeholder="phone"
                               class="rounded-2xl border border-black/10 bg-white px-4 py-2.5 text-sm placeholder:text-[#a09880] focus:outline-none focus:ring-2 focus:ring-[#F46EE5]/50">
                        <input type="text" id="co_date" placeholder="date needed (e.g. Apr 5)"
                               class="col-span-2 rounded-2xl border border-black/10 bg-white px-4 py-2.5 text-sm placeholder:text-[#a09880] focus:outline-none focus:ring-2 focus:ring-[#F46EE5]/50">
                        <textarea id="co_message" placeholder="any extra notes or requests ♡" rows="2"
                                  class="col-span-2 rounded-2xl border border-black/10 bg-white px-4 py-2.5 text-sm placeholder:text-[#a09880] focus:outline-none focus:ring-2 focus:ring-[#F46EE5]/50 resize-none"></textarea>
                    </div>
                    <div id="coError" class="hidden rounded-2xl bg-rose-50 px-4 py-2.5 text-sm text-rose-600 font-semibold"></div>
                    <button id="submitOrder"
                            class="w-full rounded-full bg-gradient-to-r from-[#FFC447] to-[#F46EE5] px-6 py-3 font-['Sour_Gummy'] text-base font-extrabold lowercase text-[#1b1b18] shadow-lg transition hover:scale-[1.02] disabled:opacity-60">
                        send order! 🍪
                    </button>
                </div>

                <!-- Success State -->
                <div id="checkoutSuccess" class="hidden text-center space-y-2 py-4">
                    <div class="text-4xl">🎉</div>
                    <p class="font-['Sour_Gummy'] text-lg font-extrabold lowercase text-[#1b1b18]">order sent!</p>
                    <p class="font-['Sour_Gummy'] text-sm lowercase text-[#706f6c]">we'll be in touch soon ♡</p>
                </div>
            </div>
        </div>

        <!-- Cart JS -->
        <script>
        (() => {
            const cartToggles = document.querySelectorAll('.cart-toggle');
            const drawer    = document.getElementById('cartDrawer');
            const overlay   = document.getElementById('cartOverlay');
            const closeBtn  = document.getElementById('cartClose');
            const badges    = document.querySelectorAll('.cart-badge');
            const itemsEl   = document.getElementById('cartItems');
            const emptyEl   = document.getElementById('cartEmpty');
            const footerEl  = document.getElementById('cartFooter');
            const metaEl    = document.getElementById('cartDrawerMeta');
            const totalEl   = document.getElementById('cartTotal');
            const chkToggle = document.getElementById('checkoutToggle');
            const chkForm   = document.getElementById('checkoutForm');
            const chkSucc   = document.getElementById('checkoutSuccess');
            const submitBtn = document.getElementById('submitOrder');
            const coError   = document.getElementById('coError');
            const mobileMenuToggle = document.getElementById('mobileMenuToggle');
            const mobileMenuPanel  = document.getElementById('mobileMenuPanel');
            const menuOpenIcon     = document.getElementById('menuOpenIcon');
            const menuCloseIcon    = document.getElementById('menuCloseIcon');

            let cartData = [];

            const csrf = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

            function openCart()  { drawer.classList.remove('translate-x-full'); overlay.classList.remove('hidden'); document.body.classList.add('overflow-hidden'); fetchCart(); }
            function closeCart() { drawer.classList.add('translate-x-full'); overlay.classList.add('hidden'); document.body.classList.remove('overflow-hidden'); }
            window.closeCart = closeCart;

            cartToggles.forEach(btn => btn.addEventListener('click', openCart));
            closeBtn.addEventListener('click', closeCart);
            overlay.addEventListener('click', closeCart);

            if (mobileMenuToggle && mobileMenuPanel) {
                mobileMenuToggle.addEventListener('click', () => {
                    const isHidden = mobileMenuPanel.classList.toggle('hidden');
                    mobileMenuToggle.setAttribute('aria-expanded', isHidden ? 'false' : 'true');
                    menuOpenIcon?.classList.toggle('hidden', !isHidden);
                    menuCloseIcon?.classList.toggle('hidden', isHidden);
                });

                mobileMenuPanel.querySelectorAll('a').forEach(link => {
                    link.addEventListener('click', () => {
                        mobileMenuPanel.classList.add('hidden');
                        mobileMenuToggle.setAttribute('aria-expanded', 'false');
                        menuOpenIcon?.classList.remove('hidden');
                        menuCloseIcon?.classList.add('hidden');
                    });
                });
            }

            chkToggle.addEventListener('click', () => {
                chkForm.classList.toggle('hidden');
                chkToggle.textContent = chkForm.classList.contains('hidden') ? 'place order ♡' : 'hide form ↑';
            });

            function fetchCart() {
                fetch('{{ route("cart.get") }}')
                    .then(r => r.json())
                    .then(data => { cartData = data.cart; renderCart(data); });
            }

            function renderCart(data) {
                badges.forEach(badge => {
                    badge.textContent = data.count;
                });
                metaEl.textContent = data.count === 1 ? '1 item' : data.count + ' items';
                totalEl.textContent = '$' + parseFloat(data.total).toFixed(2);

                if (!data.cart.length) {
                    emptyEl.classList.remove('hidden');
                    footerEl.classList.add('hidden');
                    // Clear items except empty state
                    [...itemsEl.children].forEach(c => { if (c !== emptyEl) c.remove(); });
                    return;
                }

                emptyEl.classList.add('hidden');
                footerEl.classList.remove('hidden');

                // Rebuild items
                [...itemsEl.children].forEach(c => { if (c !== emptyEl) c.remove(); });

                data.cart.forEach(item => {
                    const el = document.createElement('div');
                    el.className = 'group flex gap-3 rounded-2xl bg-white p-3 shadow ring-1 ring-black/5';
                    el.dataset.menuId = item.id;
                    el.innerHTML = `
                        <div class="h-16 w-16 shrink-0 overflow-hidden rounded-xl bg-rose-50">
                            ${item.image
                                ? `<img src="${item.image}" alt="${escHtml(item.title)}" class="h-full w-full object-cover">`
                                : `<div class="flex h-full w-full items-center justify-center text-2xl">🍰</div>`}
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="font-['Sour_Gummy'] text-sm font-extrabold lowercase text-[#1b1b18] truncate">${escHtml(item.title)}</p>
                            <p class="font-['Sour_Gummy'] text-xs font-bold lowercase text-[#706f6c]">$${parseFloat(item.price).toFixed(2)} / ${escHtml(item.quantity_type)}</p>
                            ${item.notes ? `<p class="mt-0.5 text-xs text-[#9a8e86] italic truncate">${escHtml(item.notes)}</p>` : ''}
                            <div class="mt-2 flex items-center gap-2">
                                <button class="qty-btn h-6 w-6 rounded-full bg-[#f3f0eb] text-sm font-bold leading-none hover:bg-[#F46EE5]/20 transition" data-action="dec">−</button>
                                <span class="qty-val font-['Sour_Gummy'] text-sm font-extrabold text-[#1b1b18] w-5 text-center">${item.quantity}</span>
                                <button class="qty-btn h-6 w-6 rounded-full bg-[#f3f0eb] text-sm font-bold leading-none hover:bg-[#F46EE5]/20 transition" data-action="inc">+</button>
                            </div>
                        </div>
                        <div class="flex flex-col items-end justify-between">
                            <button class="remove-btn rounded-full p-1 text-xs text-[#ccc] hover:text-rose-400 transition" title="Remove">✕</button>
                            <span class="font-['Sour_Gummy'] text-sm font-extrabold text-[#1b1b18]">$${(parseFloat(item.price) * item.quantity).toFixed(2)}</span>
                        </div>
                    `;

                    const qtyVal = el.querySelector('.qty-val');

                    el.querySelectorAll('.qty-btn').forEach(btn => {
                        btn.addEventListener('click', () => {
                            const cur = parseInt(qtyVal.textContent);
                            const next = btn.dataset.action === 'inc' ? cur + 1 : cur - 1;
                            cartAction('/cart/update', { menu_id: item.id, quantity: next })
                                .then(updateBadgeAndRender);
                        });
                    });

                    el.querySelector('.remove-btn').addEventListener('click', () => {
                        cartAction('/cart/remove', { menu_id: item.id })
                            .then(updateBadgeAndRender);
                    });

                    itemsEl.appendChild(el);
                });
            }

            function updateBadgeAndRender(data) {
                badges.forEach(badge => {
                    badge.textContent = data.cart_count;
                });
                fetchCart();
            }

            function cartAction(url, body) {
                return fetch(url, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf },
                    body: JSON.stringify(body),
                }).then(r => r.json());
            }

            function escHtml(str) {
                return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
            }

            // Expose addToCart globally for order-form page
            window.addToCart = function(menuId, quantity, notes) {
                return cartAction('/cart/add', { menu_id: menuId, quantity, notes })
                    .then(data => {
                        badges.forEach(badge => {
                            badge.textContent = data.cart_count;
                        });
                        return data;
                    });
            };

            submitBtn.addEventListener('click', () => {
                const name    = document.getElementById('co_name').value.trim();
                const email   = document.getElementById('co_email').value.trim();
                const phone   = document.getElementById('co_phone').value.trim();
                const date    = document.getElementById('co_date').value.trim();
                const message = document.getElementById('co_message').value.trim();

                coError.classList.add('hidden');

                if (!name) { showError('Please enter your name.'); return; }
                if (!email || !email.includes('@')) { showError('Please enter a valid email.'); return; }

                submitBtn.disabled = true;
                submitBtn.textContent = 'sending… 🍪';

                cartAction('/cart/checkout', { name, email, phone, date, message })
                    .then(data => {
                        if (data.success) {
                            chkForm.classList.add('hidden');
                            chkToggle.classList.add('hidden');
                            chkSucc.classList.remove('hidden');
                            badges.forEach(badge => {
                                badge.textContent = '0';
                            });
                            setTimeout(() => {
                                closeCart();
                                chkSucc.classList.add('hidden');
                                chkToggle.classList.remove('hidden');
                                chkToggle.textContent = 'place order ♡';
                                submitBtn.disabled = false;
                                submitBtn.textContent = 'send order! 🍪';
                            }, 3000);
                        } else {
                            showError(data.message || 'Something went wrong.');
                            submitBtn.disabled = false;
                            submitBtn.textContent = 'send order! 🍪';
                        }
                    })
                    .catch(() => {
                        showError('Network error. Please try again.');
                        submitBtn.disabled = false;
                        submitBtn.textContent = 'send order! 🍪';
                    });
            });

            function showError(msg) {
                coError.textContent = msg;
                coError.classList.remove('hidden');
            }

            // Initialize badge on page load
            fetch('{{ route("cart.get") }}')
                .then(r => r.json())
                .then(data => {
                    badges.forEach(badge => {
                        badge.textContent = data.count;
                    });
                });
        })();
        </script>

    </body>
</html>
