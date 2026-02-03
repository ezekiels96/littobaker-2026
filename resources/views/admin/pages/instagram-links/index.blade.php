@extends('admin.layouts.app')

@section('title', 'instagram links')

@section('content')
<div class="flex flex-col gap-4">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="font-gummy text-4xl font-extrabold lowercase text-lb-ink">instagram links</h1>
            <p class="font-gummy text-sm font-bold text-lb-muted lowercase">
                manage the homepage instagram preview strip ♡
            </p>
        </div>

        <a href="{{ route('admin.instagram-links.create') }}"
           class="inline-flex items-center justify-center rounded-full px-5 py-3 font-gummy text-sm font-extrabold lowercase
                  bg-gradient-to-r from-lb-yellow to-lb-pink/30 shadow-lg border border-black/5 hover:shadow-xl transition">
            + add link
        </a>
    </div>

    @if(session('success'))
        <div class="rounded-2xl border border-black/5 bg-white/70 p-4 shadow">
            <div class="font-gummy font-extrabold lowercase text-lb-ink">{{ session('success') }}</div>
        </div>
    @endif

    @if($links->isEmpty())
        <div class="rounded-3xl border border-black/5 bg-white/70 p-10 text-center shadow">
            <div class="font-gummy text-2xl font-extrabold lowercase text-lb-ink">no links yet</div>
            <div class="mt-2 font-gummy text-sm font-bold text-lb-muted lowercase">
                add 3–6 posts and they’ll show on the home page ✨
            </div>
        </div>
    @else
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($links as $link)
                <div class="relative overflow-hidden rounded-3xl border border-black/5 bg-white/70 p-5 shadow-lg backdrop-blur">
                    <div class="pointer-events-none absolute -top-16 -right-20 h-48 w-48 rounded-full bg-lb-pink/20 blur-3xl"></div>
                    <div class="pointer-events-none absolute -bottom-16 -left-20 h-48 w-48 rounded-full bg-lb-yellow/20 blur-3xl"></div>

                    <div class="flex items-start gap-4">
                        <div class="shrink-0">
                            @if($link->image_url)
                                <img src="{{ $link->image_url }}"
                                     alt="preview"
                                     class="h-20 w-20 rounded-2xl object-cover border border-black/5 shadow-sm"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            @endif

                            <div class="h-20 w-20 rounded-2xl border border-black/5 bg-gradient-to-br from-lb-yellow/40 to-lb-pink/30
                                        {{ $link->image_url ? 'hidden' : 'flex' }}
                                        items-center justify-center font-gummy text-2xl font-extrabold lowercase text-lb-ink">
                                📸
                            </div>
                        </div>

                        <div class="min-w-0 flex-1">
                            <div class="font-gummy text-xl font-extrabold lowercase text-lb-ink truncate">
                                {{ $link->label ?: 'instagram post' }}
                            </div>

                            <a href="{{ $link->post_url }}" target="_blank" rel="noopener"
                               class="mt-1 block font-gummy text-xs font-bold text-lb-muted break-all hover:underline">
                                {{ $link->post_url }}
                            </a>

                            <div class="mt-3 flex items-center gap-2">
                                <span class="inline-flex items-center rounded-full px-3 py-1 font-gummy text-xs font-extrabold lowercase
                                    border border-black/5 bg-white/70 shadow-sm">
                                    order: {{ $link->sort_order }}
                                </span>

                                <span class="inline-flex items-center rounded-full px-3 py-1 font-gummy text-xs font-extrabold lowercase
                                    border border-black/5 {{ $link->is_active ? 'bg-white/70' : 'bg-white/40 text-lb-muted' }} shadow-sm">
                                    {{ $link->is_active ? 'active' : 'hidden' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 flex flex-wrap gap-2">
                        <a href="{{ route('admin.instagram-links.show', $link) }}"
                           class="rounded-full px-4 py-2 font-gummy text-sm font-extrabold lowercase border border-black/5 bg-white/70 hover:bg-white transition shadow-sm">
                            view
                        </a>

                        <a href="{{ route('admin.instagram-links.edit', $link) }}"
                           class="rounded-full px-4 py-2 font-gummy text-sm font-extrabold lowercase border border-black/5 bg-white/70 hover:bg-white transition shadow-sm">
                            edit
                        </a>

                        <form action="{{ route('admin.instagram-links.destroy', $link) }}" method="POST"
                              onsubmit="return confirm('Delete this link?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="rounded-full px-4 py-2 font-gummy text-sm font-extrabold lowercase border border-black/10 bg-white/70 hover:bg-white transition shadow-sm">
                                delete
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
