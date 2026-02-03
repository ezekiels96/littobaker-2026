@extends('admin.layouts.app')

@section('content')
<div class="flex flex-col gap-4">
    {{-- Header --}}
    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="font-gummy text-4xl font-extrabold lowercase text-lb-ink">
                menu items
            </h1>
            <p class="font-gummy text-sm font-bold text-lb-muted lowercase">
                add, edit, and organize your sweet treats ♡
            </p>
        </div>

        <a href="{{ route('admin.menu.create') }}"
           class="inline-flex items-center justify-center rounded-full px-5 py-3
                  font-gummy text-sm font-extrabold lowercase
                  bg-gradient-to-r from-lb-yellow to-lb-pink/30
                  shadow-lg border border-black/5 hover:shadow-xl transition">
            + add new item
        </a>
    </div>

    {{-- Success message --}}
    @if(session('success'))
        <div class="rounded-2xl border border-black/5 bg-white/70 p-4 shadow">
            <div class="font-gummy font-extrabold lowercase text-lb-ink">
                {{ session('success') }}
            </div>
        </div>
    @endif

    {{-- Empty state --}}
    @if($menus->isEmpty())
        <div class="rounded-3xl border border-black/5 bg-white/70 p-10 text-center shadow">
            <div class="font-gummy text-2xl font-extrabold lowercase text-lb-ink">
                no menu items yet
            </div>
            <div class="mt-2 font-gummy text-sm font-bold text-lb-muted lowercase">
                add your first item and it’ll show up here ✨
            </div>
            <div class="mt-6">
                <a href="{{ route('admin.menu.create') }}"
                   class="inline-flex items-center justify-center rounded-full px-5 py-3
                          font-gummy text-sm font-extrabold lowercase
                          bg-gradient-to-r from-lb-yellow to-lb-pink/30
                          shadow-lg border border-black/5 hover:shadow-xl transition">
                    + add new item
                </a>
            </div>
        </div>
    @else
        {{-- Card grid --}}
<div id="menuGrid" class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
    @foreach($menus as $menu)
        @php
            $thumb = $menu->images->first()->image_url ?? null;
        @endphp

        <div
            class="relative overflow-hidden rounded-3xl border border-black/5 bg-white/70 p-5 shadow-lg backdrop-blur"
            data-id="{{ $menu->id }}"
        >
            {{-- soft glow --}}
            <div class="pointer-events-none absolute -top-16 -right-20 h-48 w-48 rounded-full bg-lb-pink/20 blur-3xl"></div>
            <div class="pointer-events-none absolute -bottom-16 -left-20 h-48 w-48 rounded-full bg-lb-yellow/20 blur-3xl"></div>

            <div class="flex items-start gap-4">
                {{-- Thumbnail --}}
                <div class="shrink-0">
                    @if($thumb)
                        <img
                            src="{{ $thumb }}"
                            alt="{{ $menu->title }}"
                            class="h-20 w-20 rounded-2xl object-cover border border-black/5 shadow-sm"
                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                        >
                    @endif

                    <div
                        class="h-20 w-20 rounded-2xl border border-black/5 bg-gradient-to-br from-lb-yellow/40 to-lb-pink/30
                               flex items-center justify-center font-gummy text-2xl font-extrabold lowercase text-lb-ink
                               {{ $thumb ? 'hidden' : 'flex' }}">
                        🍪
                    </div>
                </div>

                {{-- Text --}}
                <div class="min-w-0 flex-1">
                    <div class="font-gummy text-xl font-extrabold lowercase text-lb-ink truncate">
                        {{ $menu->title }}
                    </div>
                    <div class="mt-1 font-gummy text-sm font-bold text-lb-muted lowercase truncate">
                        {{ $menu->name }}
                    </div>

                    <div class="mt-3 flex items-center gap-2">
                        <div class="inline-flex items-center rounded-full bg-white/80 px-3 py-1
                                    font-gummy text-sm font-extrabold text-lb-ink border border-black/5 shadow-sm">
                            ${{ number_format((float)$menu->price, 2) }}
                        </div>
                        <div class="font-gummy text-xs font-bold text-lb-muted lowercase">
                            / {{ $menu->quantity_type }}
                        </div>
                    </div>
                </div>

                {{-- Drag handle --}}
                <button type="button"
                    class="drag-handle shrink-0 rounded-full border border-black/5 bg-white/70 px-3 py-2
                           font-gummy text-xs font-extrabold lowercase text-lb-ink shadow-sm hover:bg-white transition"
                    title="drag to reorder">
                    drag
                </button>
            </div>

            {{-- Actions --}}
            <div class="mt-4 flex flex-wrap gap-2">
                <a href="{{ route('admin.menu.show', $menu) }}"
                   class="rounded-full px-4 py-2 font-gummy text-sm font-extrabold lowercase
                          border border-black/5 bg-white/70 hover:bg-white transition shadow-sm">
                    view
                </a>

                <a href="{{ route('admin.menu.edit', $menu) }}"
                   class="rounded-full px-4 py-2 font-gummy text-sm font-extrabold lowercase
                          border border-black/5 bg-white/70 hover:bg-white transition shadow-sm">
                    edit
                </a>

                <form action="{{ route('admin.menu.destroy', $menu) }}" method="POST"
                      onsubmit="return confirm('Delete this item?')">
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
    @endforeach
</div>

    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script>
    const grid = document.getElementById('menuGrid');

    const saveOrder = async () => {
        const ids = Array.from(grid.querySelectorAll('[data-id]'))
            .map(el => Number(el.getAttribute('data-id')));

        await fetch(@json(route('admin.menu.reorder')), {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': @json(csrf_token()),
                'Accept': 'application/json'
            },
            body: JSON.stringify({ ids })
        });
    };

    new Sortable(grid, {
        animation: 150,
        handle: '.drag-handle',
        ghostClass: 'opacity-50',
        onEnd: () => saveOrder()
    });
</script>
@endsection

