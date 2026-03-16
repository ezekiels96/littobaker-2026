@extends('admin.layouts.app')

@section('title', 'add menu item')

@section('content')
<div class="flex flex-col gap-6">

    {{-- Header --}}
    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="font-gummy text-4xl font-extrabold lowercase text-lb-ink">add menu item</h1>
            <p class="font-gummy text-sm font-bold lowercase text-lb-muted">fill in the details for your new treat ♡</p>
        </div>
        <a href="{{ route('admin.menu.index') }}"
           class="rounded-full px-5 py-3 font-gummy text-sm font-extrabold lowercase border border-black/5 bg-white/70 hover:bg-white transition shadow-sm">
            back to list
        </a>
    </div>

    {{-- Errors --}}
    @if($errors->any())
        <div class="rounded-3xl border border-rose-100 bg-rose-50 p-5 shadow-sm">
            <p class="font-gummy text-sm font-extrabold lowercase text-rose-600">please fix the errors below:</p>
            <ul class="mt-2 list-disc pl-5 font-gummy text-sm font-bold lowercase text-rose-500 space-y-0.5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.menu.store') }}" method="POST"
          class="rounded-3xl border border-black/5 bg-white/70 p-6 shadow-lg backdrop-blur">
        @csrf

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

            {{-- Name --}}
            <div>
                <label class="block font-gummy text-xs font-bold uppercase tracking-[0.25em] text-lb-muted">name</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       placeholder="e.g. pandan cookies"
                       class="mt-2 w-full rounded-2xl border px-4 py-3 font-gummy font-bold lowercase shadow-sm outline-none transition
                           @error('name') border-red-400 bg-red-50/60 @else border-black/10 bg-white/70 focus:border-black/20 focus:bg-white @enderror">
                @error('name') <p class="mt-2 font-gummy text-sm font-extrabold lowercase text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Title --}}
            <div>
                <label class="block font-gummy text-xs font-bold uppercase tracking-[0.25em] text-lb-muted">title <span class="normal-case text-lb-muted/50">(displayed on site)</span></label>
                <input type="text" name="title" value="{{ old('title') }}" required
                       placeholder="e.g. pandan cookies"
                       class="mt-2 w-full rounded-2xl border px-4 py-3 font-gummy font-bold lowercase shadow-sm outline-none transition
                           @error('title') border-red-400 bg-red-50/60 @else border-black/10 bg-white/70 focus:border-black/20 focus:bg-white @enderror">
                @error('title') <p class="mt-2 font-gummy text-sm font-extrabold lowercase text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Description --}}
            <div class="sm:col-span-2">
                <label class="block font-gummy text-xs font-bold uppercase tracking-[0.25em] text-lb-muted">description</label>
                <textarea name="description" rows="3"
                          placeholder="describe this treat in a few words ♡"
                          class="mt-2 w-full rounded-2xl border px-4 py-3 font-gummy font-bold lowercase shadow-sm outline-none transition resize-none
                              @error('description') border-red-400 bg-red-50/60 @else border-black/10 bg-white/70 focus:border-black/20 focus:bg-white @enderror">{{ old('description') }}</textarea>
                @error('description') <p class="mt-2 font-gummy text-sm font-extrabold lowercase text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Price --}}
            <div>
                <label class="block font-gummy text-xs font-bold uppercase tracking-[0.25em] text-lb-muted">price ($)</label>
                <div class="relative mt-2">
                    <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 font-gummy font-bold text-lb-muted">$</span>
                    <input type="number" step="0.01" min="0" name="price" value="{{ old('price') }}" required
                           placeholder="0.00"
                           class="w-full rounded-2xl border py-3 pl-8 pr-4 font-gummy font-bold shadow-sm outline-none transition
                               @error('price') border-red-400 bg-red-50/60 @else border-black/10 bg-white/70 focus:border-black/20 focus:bg-white @enderror">
                </div>
                @error('price') <p class="mt-2 font-gummy text-sm font-extrabold lowercase text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Quantity Type --}}
            <div>
                <label class="block font-gummy text-xs font-bold uppercase tracking-[0.25em] text-lb-muted">quantity type</label>
                <select name="quantity_type" required
                        class="mt-2 w-full rounded-2xl border px-4 py-3 font-gummy font-bold lowercase shadow-sm outline-none transition
                            @error('quantity_type') border-red-400 bg-red-50/60 @else border-black/10 bg-white/70 focus:border-black/20 focus:bg-white @enderror">
                    <option value="">select one</option>
                    <option value="dozen"  {{ old('quantity_type') === 'dozen'  ? 'selected' : '' }}>dozen</option>
                    <option value="order"  {{ old('quantity_type') === 'order'  ? 'selected' : '' }}>order</option>
                    <option value="pieces" {{ old('quantity_type') === 'pieces' ? 'selected' : '' }}>pieces</option>
                </select>
                @error('quantity_type') <p class="mt-2 font-gummy text-sm font-extrabold lowercase text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Image URLs --}}
            <div class="sm:col-span-2">
                <label class="block font-gummy text-xs font-bold uppercase tracking-[0.25em] text-lb-muted">image urls <span class="normal-case text-lb-muted/50">(one per line)</span></label>
                <textarea name="image_urls" id="imageUrlsInput" rows="4"
                          placeholder="https://res.cloudinary.com/...&#10;https://res.cloudinary.com/..."
                          class="mt-2 w-full rounded-2xl border px-4 py-3 font-gummy font-bold shadow-sm outline-none transition resize-none
                              @error('image_urls') border-red-400 bg-red-50/60 @else border-black/10 bg-white/70 focus:border-black/20 focus:bg-white @enderror">{{ old('image_urls') }}</textarea>
                <p class="mt-1.5 font-gummy text-xs font-bold lowercase text-lb-muted/70">paste one cloudinary (or direct image) url per line</p>
                @error('image_urls') <p class="mt-2 font-gummy text-sm font-extrabold lowercase text-red-600">{{ $message }}</p> @enderror

                {{-- Live preview grid --}}
                <div id="imgPreviewGrid" class="mt-4 hidden">
                    <p class="font-gummy text-xs font-bold uppercase tracking-[0.25em] text-lb-muted mb-3">preview</p>
                    <div id="imgPreviewList" class="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-4"></div>
                </div>

                {{-- Old-value preview on validation failure --}}
                @php
                    $oldUrls = collect(preg_split('/\r\n|\r|\n/', old('image_urls', '')))
                        ->map(fn($u) => trim($u))->filter()->values();
                @endphp
                @if($oldUrls->count())
                    <div class="mt-4">
                        <p class="font-gummy text-xs font-bold uppercase tracking-[0.25em] text-lb-muted mb-3">preview</p>
                        <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-4">
                            @foreach($oldUrls as $url)
                                <div class="relative overflow-hidden rounded-2xl border border-black/5 bg-white shadow-sm">
                                    <img src="{{ $url }}" alt="preview"
                                         class="h-36 w-full object-cover"
                                         loading="lazy"
                                         onerror="this.style.display='none'; this.nextElementSibling.classList.remove('hidden')">
                                    <div class="hidden h-36 w-full flex items-center justify-center bg-gradient-to-br from-lb-yellow/30 to-lb-pink/20">
                                        <span class="font-gummy text-sm font-extrabold lowercase text-lb-ink">bad link</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Actions --}}
        <div class="mt-6 flex flex-wrap gap-3">
            <button type="submit"
                    class="rounded-full bg-gradient-to-r from-lb-yellow to-lb-pink/30 px-8 py-3 font-gummy text-sm font-extrabold lowercase shadow-lg border border-black/5 transition hover:scale-[1.02] hover:shadow-xl">
                create item ♡
            </button>
            <a href="{{ route('admin.menu.index') }}"
               class="rounded-full border border-black/5 bg-white/70 px-6 py-3 font-gummy text-sm font-extrabold lowercase shadow-sm transition hover:bg-white">
                cancel
            </a>
        </div>
    </form>
</div>

<script>
(() => {
    const textarea = document.getElementById('imageUrlsInput');
    const grid     = document.getElementById('imgPreviewGrid');
    const list     = document.getElementById('imgPreviewList');

    function renderPreviews() {
        const urls = textarea.value
            .split(/\r?\n/)
            .map(u => u.trim())
            .filter(Boolean);

        list.innerHTML = '';

        if (!urls.length) { grid.classList.add('hidden'); return; }

        grid.classList.remove('hidden');
        urls.forEach(url => {
            const wrap = document.createElement('div');
            wrap.className = 'relative overflow-hidden rounded-2xl border border-black/5 bg-white shadow-sm';
            wrap.innerHTML = `
                <img src="${url}" alt="preview"
                     class="h-36 w-full object-cover"
                     loading="lazy"
                     onerror="this.style.display='none'; this.nextElementSibling.classList.remove('hidden')">
                <div class="hidden h-36 w-full flex items-center justify-center bg-gradient-to-br from-yellow-100 to-pink-100">
                    <span class="font-gummy text-sm font-extrabold lowercase text-gray-600">bad link</span>
                </div>`;
            list.appendChild(wrap);
        });
    }

    let debounce;
    textarea.addEventListener('input', () => {
        clearTimeout(debounce);
        debounce = setTimeout(renderPreviews, 400);
    });

    renderPreviews();
})();
</script>
@endsection
