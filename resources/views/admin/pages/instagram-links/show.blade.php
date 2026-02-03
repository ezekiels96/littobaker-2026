@extends('admin.layouts.app')

@section('title', 'instagram link')

@section('content')
<div class="flex flex-col gap-4">
    {{-- Header --}}
    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="font-gummy text-4xl font-extrabold lowercase text-lb-ink">instagram link</h1>
            <p class="font-gummy text-sm font-bold text-lb-muted lowercase">
                preview this tile as it’ll appear on the home page ♡
            </p>
        </div>

        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.instagram-links.edit', $link) }}"
               class="rounded-full px-5 py-3 font-gummy text-sm font-extrabold lowercase
                      bg-gradient-to-r from-lb-yellow to-lb-pink/30 shadow-lg border border-black/5 hover:shadow-xl transition">
                edit
            </a>

            <a href="{{ route('admin.instagram-links.index') }}"
               class="rounded-full px-5 py-3 font-gummy text-sm font-extrabold lowercase
                      border border-black/5 bg-white/70 hover:bg-white transition shadow-sm">
                back
            </a>
        </div>
    </div>

    {{-- Card --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        {{-- Preview tile --}}
        <div class="relative overflow-hidden rounded-3xl border border-black/5 bg-white/70 shadow-lg backdrop-blur">
            <div class="pointer-events-none absolute -top-16 -right-20 h-48 w-48 rounded-full bg-lb-pink/20 blur-3xl"></div>
            <div class="pointer-events-none absolute -bottom-16 -left-20 h-48 w-48 rounded-full bg-lb-yellow/20 blur-3xl"></div>

            <a href="{{ $link->post_url }}" target="_blank" rel="noopener"
               class="group block">
                <div class="relative aspect-square overflow-hidden">
                    @if($link->image_url)
                        <img src="{{ $link->image_url }}"
                             alt="preview"
                             class="h-full w-full object-cover transition duration-300 group-hover:scale-105"
                             onerror="this.style.display='none'; this.nextElementSibling.classList.remove('hidden');">
                        <div class="hidden h-full w-full bg-gradient-to-br from-rose-100 via-pink-50 to-amber-50"></div>
                    @else
                        <div class="h-full w-full bg-gradient-to-br from-rose-100 via-pink-50 to-amber-50"></div>
                    @endif

                    <div class="absolute inset-0 flex items-center justify-center bg-black/35 opacity-0 transition group-hover:opacity-100">
                        <span class="rounded-full bg-white/90 px-4 py-2 font-gummy text-sm font-extrabold lowercase text-lb-ink shadow">
                            view on instagram
                        </span>
                    </div>
                </div>

                <div class="p-5 text-center">
                    <div class="font-gummy text-xl font-extrabold lowercase text-lb-ink">
                        {{ $link->label ?: 'instagram post ♡' }}
                    </div>
                    <div class="mt-1 font-gummy text-sm font-bold lowercase text-lb-muted">
                        tap to open
                    </div>
                </div>
            </a>
        </div>

        {{-- Details --}}
        <div class="rounded-3xl border border-black/5 bg-white/70 p-6 shadow-lg backdrop-blur">
            <div class="font-gummy text-2xl font-extrabold lowercase text-lb-ink">details</div>

            <div class="mt-4 space-y-3 font-gummy font-bold text-lb-ink">
                <div>
                    <div class="text-xs tracking-[0.25em] uppercase text-lb-muted">label</div>
                    <div class="lowercase">{{ $link->label ?: '—' }}</div>
                </div>

                <div>
                    <div class="text-xs tracking-[0.25em] uppercase text-lb-muted">post url</div>
                    <a href="{{ $link->post_url }}" target="_blank" rel="noopener"
                       class="break-all text-sm text-lb-ink underline decoration-black/20 hover:decoration-black/40">
                        {{ $link->post_url }}
                    </a>
                </div>

                <div>
                    <div class="text-xs tracking-[0.25em] uppercase text-lb-muted">image url</div>
                    @if($link->image_url)
                        <a href="{{ $link->image_url }}" target="_blank" rel="noopener"
                           class="break-all text-sm text-lb-ink underline decoration-black/20 hover:decoration-black/40">
                            {{ $link->image_url }}
                        </a>
                    @else
                        <div class="text-sm lowercase text-lb-muted">none (uses gradient tile)</div>
                    @endif
                </div>

                <div class="flex flex-wrap gap-2 pt-2">
                    <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-extrabold lowercase border border-black/5 bg-white/70 shadow-sm">
                        order: {{ $link->sort_order }}
                    </span>

                    <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-extrabold lowercase border border-black/5 bg-white/70 shadow-sm">
                        {{ $link->is_active ? 'active' : 'hidden' }}
                    </span>
                </div>

                <div class="pt-4">
                    <form action="{{ route('admin.instagram-links.destroy', $link) }}" method="POST"
                          onsubmit="return confirm('Delete this link?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="rounded-full px-6 py-3 font-gummy text-sm font-extrabold lowercase
                                       border border-black/10 bg-white/70 hover:bg-white transition shadow-sm">
                            delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
