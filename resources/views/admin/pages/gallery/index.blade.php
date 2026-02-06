@extends('admin.layouts.app')

@section('title', 'gallery')

@section('content')
<div class="flex flex-col gap-4">
    {{-- Header --}}
    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="font-gummy text-4xl font-extrabold lowercase text-lb-ink">
                gallery
            </h1>
            <p class="font-gummy text-sm font-bold text-lb-muted lowercase">
                upload pics, add tags, keep it cute ♡
            </p>
        </div>

        <a href="{{ route('admin.gallery.create') }}"
           class="inline-flex items-center justify-center rounded-full px-5 py-3
                  font-gummy text-sm font-extrabold lowercase
                  bg-gradient-to-r from-lb-yellow to-lb-pink/30
                  shadow-lg border border-black/5 hover:shadow-xl transition">
            + add photo
        </a>
    </div>

    {{-- Success --}}
    @if(session('success'))
        <div class="rounded-2xl border border-black/5 bg-white/70 p-4 shadow">
            <div class="font-gummy font-extrabold lowercase text-lb-ink">
                {{ session('success') }}
            </div>
        </div>
    @endif

    {{-- Empty --}}
    @if($items->isEmpty())
        <div class="rounded-3xl border border-black/5 bg-white/70 p-10 text-center shadow">
            <div class="font-gummy text-2xl font-extrabold lowercase text-lb-ink">
                no photos yet
            </div>
            <div class="mt-2 font-gummy text-sm font-bold text-lb-muted lowercase">
                add your first gallery item ✨
            </div>
            <div class="mt-6">
                <a href="{{ route('admin.gallery.create') }}"
                   class="inline-flex items-center justify-center rounded-full px-5 py-3
                          font-gummy text-sm font-extrabold lowercase
                          bg-gradient-to-r from-lb-yellow to-lb-pink/30
                          shadow-lg border border-black/5 hover:shadow-xl transition">
                    + add photo
                </a>
            </div>
        </div>
    @else
        {{-- Grid --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($items as $item)
                <div class="group relative overflow-hidden rounded-3xl border border-black/5 bg-white/70 shadow-lg backdrop-blur">
                    {{-- Glow --}}
                    <div class="pointer-events-none absolute -top-16 -right-20 h-48 w-48 rounded-full bg-lb-pink/20 blur-3xl"></div>
                    <div class="pointer-events-none absolute -bottom-16 -left-20 h-48 w-48 rounded-full bg-lb-yellow/20 blur-3xl"></div>

                    {{-- Image --}}
                    <div class="relative aspect-square overflow-hidden">
                        <img src="{{ $item->image_url }}"
                             alt="{{ $item->title ?? 'gallery item' }}"
                             class="h-full w-full object-cover transition duration-300 group-hover:scale-105"
                             loading="lazy">
                        <div class="absolute inset-0 bg-black/0 transition group-hover:bg-black/10"></div>
                    </div>

                    {{-- Info --}}
                    <div class="p-5">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <div class="font-gummy text-xl font-extrabold lowercase text-lb-ink truncate">
                                    {{ $item->title ?: 'sweet moment ♡' }}
                                </div>

                                @if(!empty($item->caption))
                                    <div class="mt-1 font-gummy text-sm font-bold lowercase text-lb-muted line-clamp-2">
                                        {{ $item->caption }}
                                    </div>
                                @endif
                            </div>

                            <span class="shrink-0 inline-flex items-center rounded-full px-3 py-1
                                         font-gummy text-xs font-extrabold lowercase border border-black/5 bg-white/70 shadow-sm">
                                {{ $item->is_active ? 'active' : 'hidden' }}
                            </span>
                        </div>

                        {{-- Tags --}}
                        @if($item->tags && $item->tags->count())
                            <div class="mt-3 flex flex-wrap gap-2">
                                @foreach($item->tags as $tag)
                                    <span class="inline-flex items-center rounded-full bg-white/80 px-3 py-1
                                                 font-gummy text-xs font-extrabold lowercase text-lb-ink
                                                 ring-1 ring-black/5 shadow-sm">
                                        {{ $tag->name }}
                                    </span>
                                @endforeach
                            </div>
                        @endif

                        {{-- Actions --}}
                        <div class="mt-4 flex flex-wrap gap-2">
                            <a href="{{ route('admin.gallery.show', $item) }}"
                               class="rounded-full px-4 py-2 font-gummy text-sm font-extrabold lowercase
                                      border border-black/5 bg-white/70 hover:bg-white transition shadow-sm">
                                view
                            </a>

                            <a href="{{ route('admin.gallery.edit', $item) }}"
                               class="rounded-full px-4 py-2 font-gummy text-sm font-extrabold lowercase
                                      border border-black/5 bg-white/70 hover:bg-white transition shadow-sm">
                                edit
                            </a>

                            <form action="{{ route('admin.gallery.destroy', $item) }}" method="POST"
                                  onsubmit="return confirm('Delete this photo?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="rounded-full px-4 py-2 font-gummy text-sm font-extrabold lowercase
                                               border border-black/10 bg-white/70 hover:bg-white transition shadow-sm">
                                    delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
