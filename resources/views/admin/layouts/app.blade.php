<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>littobaker admin — @yield('title', 'dashboard')</title>

    {{-- Tailwind CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Cute font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sour+Gummy:wght@400;700;800&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        gummy: ['"Sour Gummy"', 'ui-sans-serif', 'system-ui'],
                    },
                    colors: {
                        lb: {
                            ink: '#1b1b18',
                            muted: '#6a6156',
                            yellow: '#FFC447',
                            pink: '#F46EE5',
                            lilac: '#b9a7ff',
                            cream: '#fbf6ef',
                            cream2: '#fff7fb',
                        }
                    }
                }
            }
        }
    </script>
</head>

<body class="min-h-screen bg-gradient-to-b from-lb-cream via-lb-cream2 to-white text-lb-ink">
    {{-- soft glows --}}
    <div class="pointer-events-none fixed inset-0 -z-10">
        <div class="absolute -top-24 left-10 h-72 w-72 rounded-full bg-lb-yellow/30 blur-3xl"></div>
        <div class="absolute -top-24 right-10 h-72 w-72 rounded-full bg-lb-pink/20 blur-3xl"></div>
    </div>

    <div class="mx-auto w-full max-w-6xl px-6 py-6">
        {{-- Top Nav --}}
        <header class="rounded-3xl border border-black/5 bg-white/70 backdrop-blur px-4 py-4 shadow-xl">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                {{-- Brand --}}
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-3 no-underline">
                    <div class="grid h-12 w-12 place-items-center rounded-full border border-black/5 bg-gradient-to-br from-lb-yellow/80 to-lb-pink/30 shadow">
                        🍪
                    </div>
                    <div>
                        <div class="font-gummy text-2xl font-extrabold lowercase leading-tight">admin
                        </div>
                    </div>
                </a>

                @php
                    // Active states based on your exact URLs
                    $isDashboard = request()->is('admin/dashboard');
                    $isMenu      = request()->is('admin/menu*');
                    $isGallery   = request()->is('admin/gallery*');
                    $isInstagram = request()->is('admin/instagram-links*');


                    $baseLink = 'rounded-full px-4 py-2 font-gummy font-extrabold lowercase transition border';
                    $active   = 'bg-gradient-to-r from-lb-yellow to-lb-pink/30 shadow border-black/5';
                    $inactive = 'bg-white/60 hover:bg-white/90 border-black/5';
                @endphp

                {{-- Links + logout --}}
                <div class="flex flex-wrap items-center gap-2">
                    <a href="{{ route('admin.dashboard') }}"
                       class="{{ $baseLink }} {{ $isDashboard ? $active : $inactive }}">
                        dashboard
                    </a>

                    <a href="{{ route('admin.menu.index') }}"
                       class="{{ $baseLink }} {{ $isMenu ? $active : $inactive }}">
                        menu
                    </a>

                    <a href="{{ route('admin.gallery.index') }}"
                       class="{{ $baseLink }} {{ $isGallery ? $active : $inactive }}">
                        gallery
                    </a>
                    <a href="{{ route('admin.instagram-links.index') }}"
                    class="{{ $baseLink }} {{ $isInstagram ? $active : $inactive }}">
                        instagram
                    </a>

                    <a href="/"
                    class="{{ $baseLink }} {{ $inactive }}">
                        back to site
                    </a>

                    {{-- Logout --}}
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit"
                                class="rounded-full px-4 py-2 font-gummy font-extrabold lowercase
                                       border border-black/10 bg-white/70 hover:bg-white shadow-sm transition">
                            log out
                        </button>
                    </form>
                </div>
            </div>
        </header>

        {{-- Page content --}}
        <main class="mt-6">
            @yield('content')
        </main>
    </div>
</body>
</html>
