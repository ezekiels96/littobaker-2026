@extends('admin.layouts.app')

@section('content')
<div class="flex flex-col gap-4">
    {{-- Header --}}
    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="font-gummy text-4xl font-extrabold lowercase text-lb-ink">
                edit menu item
            </h1>
            <p class="font-gummy text-sm font-bold text-lb-muted lowercase">
                update the yummy details ♡
            </p>
        </div>

        <a href="{{ route('admin.menu.index') }}"
           class="rounded-full px-5 py-3 font-gummy text-sm font-extrabold lowercase
                  border border-black/5 bg-white/70 hover:bg-white transition shadow-sm">
            back to list
        </a>
    </div>

    {{-- Global error block --}}
    @if ($errors->any())
        <div class="rounded-3xl border border-black/5 bg-white/70 p-5 shadow-lg">
            <div class="font-gummy text-lg font-extrabold lowercase text-lb-ink">
                please fix the errors below:
            </div>
            <ul class="mt-2 list-disc pl-5 font-gummy text-sm font-bold text-lb-muted">
                @foreach ($errors->all() as $error)
                    <li class="lowercase">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.menu.update', $menu) }}" method="POST"
          class="rounded-3xl border border-black/5 bg-white/70 p-6 shadow-lg backdrop-blur">
        @csrf
        @method('PUT')

        @php
            $existingUrls = $menu->images->pluck('image_url')->filter()->implode("\n");
            $imageUrlsValue = old('image_urls', $existingUrls);

            // For preview grid: prefer old input if validation failed, otherwise DB
            $previewUrls = collect(preg_split('/\r\n|\r|\n/', $imageUrlsValue))
                ->map(fn($u) => trim($u))
                ->filter()
                ->values();
        @endphp

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            {{-- Name --}}
            <div>
                <label class="block font-gummy text-xs font-bold tracking-[0.25em] text-lb-muted uppercase">
                    name
                </label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $menu->name) }}"
                    class="mt-2 w-full rounded-2xl border px-4 py-3 font-gummy font-bold lowercase shadow-sm outline-none transition
                        @error('name') border-red-400 bg-red-50/60 @else border-black/10 bg-white/70 focus:border-black/20 focus:bg-white @enderror"
                    required
                >
                @error('name')
                    <p class="mt-2 font-gummy text-sm font-extrabold lowercase text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Title --}}
            <div>
                <label class="block font-gummy text-xs font-bold tracking-[0.25em] text-lb-muted uppercase">
                    title
                </label>
                <input
                    type="text"
                    name="title"
                    value="{{ old('title', $menu->title) }}"
                    class="mt-2 w-full rounded-2xl border px-4 py-3 font-gummy font-bold lowercase shadow-sm outline-none transition
                        @error('title') border-red-400 bg-red-50/60 @else border-black/10 bg-white/70 focus:border-black/20 focus:bg-white @enderror"
                    required
                >
                @error('title')
                    <p class="mt-2 font-gummy text-sm font-extrabold lowercase text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Description --}}
            <div class="sm:col-span-2">
                <label class="block font-gummy text-xs font-bold tracking-[0.25em] text-lb-muted uppercase">
                    description
                </label>
                <textarea
                    name="description"
                    rows="4"
                    class="mt-2 w-full rounded-2xl border px-4 py-3 font-gummy font-bold lowercase shadow-sm outline-none transition
                        @error('description') border-red-400 bg-red-50/60 @else border-black/10 bg-white/70 focus:border-black/20 focus:bg-white @enderror"
                >{{ old('description', $menu->description) }}</textarea>
                @error('description')
                    <p class="mt-2 font-gummy text-sm font-extrabold lowercase text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Price --}}
            <div>
                <label class="block font-gummy text-xs font-bold tracking-[0.25em] text-lb-muted uppercase">
                    price
                </label>
                <input
                    type="number"
                    step="0.01"
                    name="price"
                    value="{{ old('price', $menu->price) }}"
                    class="mt-2 w-full rounded-2xl border px-4 py-3 font-gummy font-bold shadow-sm outline-none transition
                        @error('price') border-red-400 bg-red-50/60 @else border-black/10 bg-white/70 focus:border-black/20 focus:bg-white @enderror"
                    required
                >
                @error('price')
                    <p class="mt-2 font-gummy text-sm font-extrabold lowercase text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Quantity Type --}}
            <div>
                <label class="block font-gummy text-xs font-bold tracking-[0.25em] text-lb-muted uppercase">
                    quantity type
                </label>
                <select
                    name="quantity_type"
                    class="mt-2 w-full rounded-2xl border px-4 py-3 font-gummy font-bold lowercase shadow-sm outline-none transition
                        @error('quantity_type') border-red-400 bg-red-50/60 @else border-black/10 bg-white/70 focus:border-black/20 focus:bg-white @enderror"
                    required
                >
                    <option value="">select one</option>
                    <option value="dozen"  {{ old('quantity_type', $menu->quantity_type) === 'dozen' ? 'selected' : '' }}>dozen</option>
                    <option value="order"  {{ old('quantity_type', $menu->quantity_type) === 'order' ? 'selected' : '' }}>order</option>
                    <option value="pieces" {{ old('quantity_type', $menu->quantity_type) === 'pieces' ? 'selected' : '' }}>pieces</option>
                </select>
                @error('quantity_type')
                    <p class="mt-2 font-gummy text-sm font-extrabold lowercase text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Image URLs --}}
            <div class="sm:col-span-2">
                <label class="block font-gummy text-xs font-bold tracking-[0.25em] text-lb-muted uppercase">
                    image urls (one per line)
                </label>
                <textarea
                    name="image_urls"
                    rows="5"
                    class="mt-2 w-full rounded-2xl border px-4 py-3 font-gummy font-bold shadow-sm outline-none transition
                        @error('image_urls') border-red-400 bg-red-50/60 @else border-black/10 bg-white/70 focus:border-black/20 focus:bg-white @enderror"
                >{{ $imageUrlsValue }}</textarea>

                <p class="mt-2 font-gummy text-xs font-bold text-lb-muted lowercase">
                    tip: paste one image link per line (google drive direct links won’t preview unless they are direct image urls).
                </p>

                @error('image_urls')
                    <p class="mt-2 font-gummy text-sm font-extrabold lowercase text-red-600">{{ $message }}</p>
                @enderror

                {{-- Preview grid --}}
                @if($previewUrls->count())
                    <div class="mt-4">
                        <div class="font-gummy text-xs font-bold tracking-[0.25em] text-lb-muted uppercase">
                            preview
                        </div>

                        <div class="mt-3 grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-4">
                            @foreach($previewUrls as $url)
                                <a href="{{ $url }}" target="_blank" rel="noopener"
                                   class="group relative overflow-hidden rounded-2xl border border-black/5 bg-white shadow-sm">
                                    <img
                                        src="{{ $url }}"
                                        alt="preview"
                                        class="h-36 w-full object-cover transition duration-200 group-hover:scale-[1.03]"
                                        loading="lazy"
                                        onerror="this.style.display='none'; this.nextElementSibling.classList.remove('hidden');"
                                    >
                                    <div class="hidden h-36 w-full items-center justify-center bg-gradient-to-br from-lb-yellow/30 to-lb-pink/20">
                                        <div class="px-3 text-center font-gummy text-sm font-extrabold lowercase text-lb-ink">
                                            bad link
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Actions --}}
        <div class="mt-6 flex flex-wrap gap-2">
            <button type="submit"
                    class="rounded-full px-6 py-3 font-gummy text-sm font-extrabold lowercase
                           bg-gradient-to-r from-lb-yellow to-lb-pink/30 shadow-lg border border-black/5 hover:shadow-xl transition">
                update
            </button>

            <a href="{{ route('admin.menu.index') }}"
               class="rounded-full px-6 py-3 font-gummy text-sm font-extrabold lowercase
                      border border-black/5 bg-white/70 hover:bg-white transition shadow-sm">
                cancel
            </a>
        </div>
    </form>
</div>
@endsection
