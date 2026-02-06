@extends('admin.layouts.app')

@section('content')
@php
    $tags = $gallery->tags?->pluck('name') ?? collect();
@endphp

<div class="mx-auto max-w-4xl">
    {{-- Header --}}
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="font-gummy text-4xl font-extrabold lowercase text-lb-ink">gallery item</h1>
            <p class="mt-1 font-gummy text-sm font-bold lowercase text-lb-muted">
                preview + details ♡
            </p>
        </div>

        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.gallery.edit', $gallery) }}"
               class="inline-flex items-center justify-center rounded-full px-5 py-3
                      font-gummy text-sm font-extrabold lowercase
                      bg-gradient-to-r from-lb-yellow to-lb-pink/30
                      shadow-lg border border-black/5 hover:shadow-xl transition">
                edit
            </a>

            <a href="{{ route('admin.gallery.index') }}"
               class="inline-flex items-center justify-center rounded-full px-5 py-3
                      font-gummy text-sm font-extrabold lowercase
                      border border-black/10 bg-white/70 hover:bg-white shadow-sm transition">
                back
            </a>

            <form action="{{ route('admin.gallery.destroy', $gallery) }}" method="POST"
                  onsubmit="return confirm('Delete this gallery item?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="inline-flex items-center justify-center rounded-full px-5 py-3
                               font-gummy text-sm font-extrabold lowercase
                               border border-black/10 bg-white/70 hover:bg-white shadow-sm transition">
                    delete
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        {{-- Image preview --}}
        <div class="relative overflow-hidden rounded-3xl border border-black/5 bg-white/70 shadow-xl">
            <div class="pointer-events-none absolute -top-24 -right-24 h-72 w-72 rounded-full bg-lb-pink/20 blur-3xl"></div>
            <div class="pointer-events-none absolute -bottom-24 -left-24 h-72 w-72 rounded-full bg-lb-yellow/20 blur-3xl"></div>

            <div class="relative">
                @if(!empty($gallery->image_url))
                    <img
                        src="{{ $gallery->image_url }}"
                        alt="{{ $gallery->title ?? 'gallery image' }}"
                        class="h-[420px] w-full object-cover"
                        onerror="this.style.display='none'; this.parentElement.insertAdjacentHTML('beforeend', '<div class=&quot;p-8 font-gummy font-bold lowercase text-lb-muted&quot;>image failed to load 🥲</div>');"
                    >
                @else
                    <div class="p-10 font-gummy text-lg font-extrabold lowercase text-lb-muted">
                        no image url
                    </div>
                @endif
            </div>

            @if(!empty($gallery->image_url))
                <div class="border-t border-black/5 p-4">
                    <a href="{{ $gallery->image_url }}" target="_blank" rel="noopener"
                       class="font-gummy text-sm font-extrabold lowercase text-lb-ink underline decoration-lb-pink/40 underline-offset-4">
                        open image in new tab
                    </a>
                </div>
            @endif
        </div>

        {{-- Details --}}
        <div class="rounded-3xl border border-black/5 bg-white/70 p-6 shadow-xl">
            <div class="flex flex-col gap-4">
                <div>
                    <div class="font-gummy text-xs font-extrabold uppercase tracking-widest text-lb-muted">title</div>
                    <div class="mt-1 font-gummy text-2xl font-extrabold lowercase text-lb-ink">
                        {{ $gallery->title ?? '—' }}
                    </div>
                </div>

                <div>
                    <div class="font-gummy text-xs font-extrabold uppercase tracking-widest text-lb-muted">caption</div>
                    <div class="mt-1 font-gummy text-sm font-bold lowercase leading-relaxed text-lb-ink/90">
                        {{ $gallery->caption ?? '—' }}
                    </div>
                </div>

                <div>
                    <div class="font-gummy text-xs font-extrabold uppercase tracking-widest text-lb-muted">status</div>
                    <div class="mt-2 inline-flex items-center rounded-full px-4 py-2 font-gummy text-sm font-extrabold lowercase
                                {{ $gallery->is_active ? 'bg-lb-yellow/30 text-lb-ink' : 'bg-black/5 text-lb-muted' }}">
                        {{ $gallery->is_active ? 'active' : 'inactive' }}
                    </div>
                </div>

                <div>
                    <div class="font-gummy text-xs font-extrabold uppercase tracking-widest text-lb-muted">tags</div>

                    @if($tags->isNotEmpty())
                        <div class="mt-2 flex flex-wrap gap-2">
                            @foreach($tags as $tag)
                                <span class="inline-flex items-center rounded-full bg-white/80 px-3 py-1
                                             font-gummy text-sm font-extrabold lowercase text-lb-ink
                                             ring-1 ring-black/10">
                                    {{ $tag }}
                                </span>
                            @endforeach
                        </div>
                    @else
                        <div class="mt-2 font-gummy text-sm font-bold lowercase text-lb-muted">
                            no tags
                        </div>
                    @endif
                </div>

                <div>
                    <div class="font-gummy text-xs font-extrabold uppercase tracking-widest text-lb-muted">sort order</div>
                    <div class="mt-1 font-gummy text-sm font-extrabold lowercase text-lb-ink">
                        {{ $gallery->sort_order ?? '—' }}
                    </div>
                </div>

                <div class="pt-2">
                    <div class="font-gummy text-xs font-extrabold uppercase tracking-widest text-lb-muted">created</div>
                    <div class="mt-1 font-gummy text-sm font-bold lowercase text-lb-ink/80">
                        {{ optional($gallery->created_at)->format('M j, Y g:ia') ?? '—' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
