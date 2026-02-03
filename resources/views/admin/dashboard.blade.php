@extends('admin.layouts.app')

@section('title', 'dashboard')

@section('content')
<div class="flex flex-col gap-6">
    {{-- Header --}}
    <div class="rounded-3xl border border-black/5 bg-white/70 p-6 shadow-lg backdrop-blur">
        <h1 class="font-gummy text-4xl font-extrabold lowercase text-lb-ink">
            admin dashboard
        </h1>
    </div>

    {{-- Cards --}}
    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
        <a href="{{ route('admin.gallery.index') }}"
           class="group relative overflow-hidden rounded-3xl border border-black/5 bg-white/70 p-8 shadow-lg backdrop-blur transition hover:-translate-y-0.5 hover:shadow-xl">
            {{-- glow --}}
            <div class="pointer-events-none absolute -top-20 -left-20 h-56 w-56 rounded-full bg-lb-lilac/20 blur-3xl"></div>
            <div class="pointer-events-none absolute -bottom-20 -right-20 h-56 w-56 rounded-full bg-lb-pink/20 blur-3xl"></div>

            <div class="flex items-center gap-4">
                <div class="grid h-14 w-14 place-items-center rounded-2xl border border-black/5 bg-gradient-to-br from-lb-yellow/60 to-lb-pink/20 shadow">
                    <span class="text-2xl">🖼️</span>
                </div>

                <div class="min-w-0">
                    <div class="font-gummy text-2xl font-extrabold lowercase text-lb-ink">
                        manage gallery
                    </div>
                    <div class="mt-1 font-gummy text-sm font-bold lowercase text-lb-muted">
                        upload photos, organize, and keep it pretty ✨
                    </div>
                </div>
            </div>

            <div class="mt-6 inline-flex items-center rounded-full border border-black/5 bg-white/70 px-4 py-2 font-gummy text-sm font-extrabold lowercase shadow-sm transition group-hover:bg-white">
                open gallery →
            </div>
        </a>

        <a href="{{ route('admin.menu.index') }}"
           class="group relative overflow-hidden rounded-3xl border border-black/5 bg-white/70 p-8 shadow-lg backdrop-blur transition hover:-translate-y-0.5 hover:shadow-xl">
            {{-- glow --}}
            <div class="pointer-events-none absolute -top-20 -left-20 h-56 w-56 rounded-full bg-lb-yellow/25 blur-3xl"></div>
            <div class="pointer-events-none absolute -bottom-20 -right-20 h-56 w-56 rounded-full bg-lb-pink/20 blur-3xl"></div>

            <div class="flex items-center gap-4">
                <div class="grid h-14 w-14 place-items-center rounded-2xl border border-black/5 bg-gradient-to-br from-lb-yellow/60 to-lb-pink/20 shadow">
                    <span class="text-2xl">🍰</span>
                </div>

                <div class="min-w-0">
                    <div class="font-gummy text-2xl font-extrabold lowercase text-lb-ink">
                        manage menu
                    </div>
                    <div class="mt-1 font-gummy text-sm font-bold lowercase text-lb-muted">
                        add treats, update prices, and keep it fresh ♡
                    </div>
                </div>
            </div>

            <div class="mt-6 inline-flex items-center rounded-full border border-black/5 bg-white/70 px-4 py-2 font-gummy text-sm font-extrabold lowercase shadow-sm transition group-hover:bg-white">
                open menu →
            </div>
        </a>
        <a href="{{ route('admin.instagram-links.index') }}"
   class="group relative overflow-hidden rounded-3xl border border-black/5 bg-white/70 p-8 shadow-lg backdrop-blur transition hover:-translate-y-0.5 hover:shadow-xl">
    <div class="pointer-events-none absolute -top-20 -left-20 h-56 w-56 rounded-full bg-lb-lilac/20 blur-3xl"></div>
    <div class="pointer-events-none absolute -bottom-20 -right-20 h-56 w-56 rounded-full bg-lb-pink/20 blur-3xl"></div>

    <div class="flex items-center gap-4">
        <div class="grid h-14 w-14 place-items-center rounded-2xl border border-black/5 bg-gradient-to-br from-lb-yellow/60 to-lb-pink/20 shadow">
            <span class="text-2xl">📸</span>
        </div>

        <div class="min-w-0">
            <div class="font-gummy text-2xl font-extrabold lowercase text-lb-ink">
                instagram links
            </div>
            <div class="mt-1 font-gummy text-sm font-bold lowercase text-lb-muted">
                manage the home ig preview strip ♡
            </div>
        </div>
    </div>

    <div class="mt-6 inline-flex items-center rounded-full border border-black/5 bg-white/70 px-4 py-2 font-gummy text-sm font-extrabold lowercase shadow-sm transition group-hover:bg-white">
        open instagram →
    </div>
</a>

    </div>
</div>
@endsection
