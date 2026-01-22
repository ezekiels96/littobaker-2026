<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
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
        <nav class="border-b border-[#e3e3e0] bg-white shadow-sm">
            <div class="mx-auto flex max-w-4xl flex-wrap justify-center">
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
                <a href="{{ route('menu') }}" @class([
                    'px-6 py-4 text-xs font-semibold uppercase tracking-[0.25em] transition duration-200 border-b-2',
                    'text-[#F53003] border-[#F53003]' => Route::is('menu'),
                    'text-[#1b1b18] border-transparent hover:text-[#F53003]' => ! Route::is('menu'),
                ])>Menu</a>
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
            </div>
        </nav>

        <!-- Main Content -->
        <main class="mx-auto max-w-6xl px-4 pb-16 pt-0">
            @yield('content')
        </main>

        <!-- Chatbox Placeholder -->
        <div class="fixed bottom-6 right-6 flex h-16 w-16 items-center justify-center rounded-full bg-[#F53003] text-2xl text-white shadow-xl ring-4 ring-[#F53003]/20" title="Open Chat">
            💬
        </div>

        <!-- Footer -->
        <footer class="mt-20 bg-[#1b1b18] py-10 text-center text-sm text-white">
            <div class="mx-auto max-w-4xl space-y-2">
                <p>&copy; 2026 littobaker. All rights reserved.</p>
                <p class="text-xs uppercase tracking-[0.3em] text-white/70">Home Bakery · Sunnyvale, CA</p>
            </div>
        </footer>
    </body>
</html>
