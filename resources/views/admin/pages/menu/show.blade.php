@extends('admin.layouts.app')

@section('content')
<div class="flex flex-col gap-4">
    {{-- Header --}}
    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="font-gummy text-4xl font-extrabold lowercase text-lb-ink">
                menu item details
            </h1>
            <p class="font-gummy text-sm font-bold text-lb-muted lowercase">
                view what customers will see ♡
            </p>
        </div>

        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.menu.edit', $menu) }}"
               class="rounded-full px-5 py-3 font-gummy text-sm font-extrabold lowercase
                      border border-black/5 bg-white/70 hover:bg-white transition shadow-sm">
                edit
            </a>

            <a href="{{ route('admin.menu.index') }}"
               class="rounded-full px-5 py-3 font-gummy text-sm font-extrabold lowercase
                      border border-black/5 bg-white/70 hover:bg-white transition shadow-sm">
                back to list
            </a>
        </div>
    </div>

    {{-- Details card --}}
    <div class="relative overflow-hidden rounded-3xl border border-black/5 bg-white/70 p-6 shadow-lg backdrop-blur">
        {{-- soft glow --}}
        <div class="pointer-events-none absolute -top-16 -right-20 h-48 w-48 rounded-full bg-lb-pink/20 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-16 -left-20 h-48 w-48 rounded-full bg-lb-yellow/20 blur-3xl"></div>

        <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
                <dt class="font-gummy text-xs font-bold tracking-[0.25em] text-lb-muted uppercase">name</dt>
                <dd class="mt-1 font-gummy text-lg font-extrabold lowercase text-lb-ink">
                    {{ $menu->name }}
                </dd>
            </div>

            <div>
                <dt class="font-gummy text-xs font-bold tracking-[0.25em] text-lb-muted uppercase">title</dt>
                <dd class="mt-1 font-gummy text-lg font-extrabold lowercase text-lb-ink">
                    {{ $menu->title }}
                </dd>
            </div>

            <div class="sm:col-span-2">
                <dt class="font-gummy text-xs font-bold tracking-[0.25em] text-lb-muted uppercase">description</dt>
                <dd class="mt-1 font-gummy text-base font-bold lowercase text-lb-ink/90">
                    {{ $menu->description ?: 'a sweet lil treat ♡' }}
                </dd>
            </div>

            <div>
                <dt class="font-gummy text-xs font-bold tracking-[0.25em] text-lb-muted uppercase">price</dt>
                <dd class="mt-2 inline-flex items-center rounded-full bg-gradient-to-r from-lb-yellow to-lb-pink/30
                           px-4 py-2 font-gummy text-base font-extrabold text-lb-ink shadow border border-black/5">
                    ${{ number_format((float)$menu->price, 2) }}
                </dd>
            </div>

            <div>
                <dt class="font-gummy text-xs font-bold tracking-[0.25em] text-lb-muted uppercase">quantity type</dt>
                <dd class="mt-2 inline-flex items-center rounded-full bg-white/80 px-4 py-2
                           font-gummy text-base font-extrabold lowercase text-lb-ink shadow-sm border border-black/5">
                    {{ $menu->quantity_type }}
                </dd>
            </div>
        </dl>
    </div>

    {{-- Images --}}
    <div class="rounded-3xl border border-black/5 bg-white/70 p-6 shadow-lg backdrop-blur">
        <div class="flex items-center justify-between gap-3">
            <h2 class="font-gummy text-2xl font-extrabold lowercase text-lb-ink">
                images
            </h2>
            <span class="font-gummy text-sm font-bold text-lb-muted lowercase">
                {{ $menu->images?->count() ?? 0 }} total
            </span>
        </div>

        @if($menu->images && $menu->images->count())
            <div class="mt-4 grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-4">
                @foreach($menu->images as $img)
                    @php $url = $img->image_url ?? null; @endphp

                    @if($url)
                        <a href="{{ $url }}" target="_blank" rel="noopener"
                           class="group relative overflow-hidden rounded-2xl border border-black/5 bg-white shadow-sm">
                            <img
                                src="{{ $url }}"
                                alt="{{ $menu->title }}"
                                class="h-40 w-full object-cover transition duration-200 group-hover:scale-[1.03]"
                                loading="lazy"
                                onerror="this.style.display='none'; this.nextElementSibling.classList.remove('hidden');"
                            >
                            {{-- fallback if broken --}}
                            <div class="hidden h-40 w-full items-center justify-center bg-gradient-to-br from-lb-yellow/30 to-lb-pink/20">
                                <div class="px-3 text-center font-gummy text-sm font-extrabold lowercase text-lb-ink">
                                    image link
                                </div>
                            </div>

                            <div class="absolute inset-x-0 bottom-0 bg-black/40 px-2 py-1 text-xs text-white opacity-0 transition group-hover:opacity-100">
                                open ↗
                            </div>
                        </a>
                    @endif
                @endforeach
            </div>

            {{-- URL list (optional but handy in admin) --}}
            <div class="mt-5">
                <div class="font-gummy text-xs font-bold tracking-[0.25em] text-lb-muted uppercase">
                    image urls
                </div>
                <ul class="mt-2 space-y-2">
                    @foreach($menu->images as $img)
                        @if(!empty($img->image_url))
                            <li class="rounded-2xl border border-black/5 bg-white/60 px-4 py-2">
                                <a href="{{ $img->image_url }}" target="_blank" rel="noopener"
                                   class="break-all font-gummy text-sm font-bold text-lb-ink hover:underline">
                                    {{ $img->image_url }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        @else
            <div class="mt-4 rounded-2xl border border-black/5 bg-white/60 p-6 text-center">
                <div class="font-gummy text-lg font-extrabold lowercase text-lb-ink">
                    no images yet
                </div>
                <div class="mt-1 font-gummy text-sm font-bold text-lb-muted lowercase">
                    add some image urls on the edit page ✨
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
