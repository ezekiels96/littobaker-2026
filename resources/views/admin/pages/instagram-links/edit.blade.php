@extends('admin.layouts.app')

@section('title', 'edit instagram link')

@section('content')
<div class="flex flex-col gap-4">
    {{-- Header --}}
    <div class="flex items-end justify-between gap-3">
        <div>
            <h1 class="font-gummy text-4xl font-extrabold lowercase text-lb-ink">edit instagram link</h1>
            <p class="font-gummy text-sm font-bold text-lb-muted lowercase">update your home page preview ♡</p>
        </div>

        <a href="{{ route('admin.instagram-links.index') }}"
           class="rounded-full px-5 py-3 font-gummy text-sm font-extrabold lowercase
                  border border-black/5 bg-white/70 hover:bg-white transition shadow-sm">
            back
        </a>
    </div>

    {{-- Global error block --}}
    @if ($errors->any())
        <div class="rounded-3xl border border-black/5 bg-white/70 p-5 shadow-lg">
            <div class="font-gummy text-lg font-extrabold lowercase text-lb-ink">please fix:</div>
            <ul class="mt-2 list-disc pl-5 font-gummy text-sm font-bold text-lb-muted">
                @foreach ($errors->all() as $error)
                    <li class="lowercase">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.instagram-links.update', $link) }}"
          class="rounded-3xl border border-black/5 bg-white/70 p-6 shadow-lg backdrop-blur">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            {{-- Label --}}
            <div class="sm:col-span-2">
                <label class="block font-gummy text-xs font-bold tracking-[0.25em] text-lb-muted uppercase">
                    label
                </label>
                <input
                    name="label"
                    value="{{ old('label', $link->label) }}"
                    class="mt-2 w-full rounded-2xl border px-4 py-3 font-gummy font-bold lowercase shadow-sm outline-none transition
                        @error('label') border-red-400 bg-red-50/60 @else border-black/10 bg-white/70 focus:bg-white focus:border-black/20 @enderror"
                >
                @error('label')
                    <p class="mt-2 font-gummy text-sm font-extrabold lowercase text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-2 font-gummy text-xs font-bold text-lb-muted lowercase">example: “ube treats 💜”</p>
            </div>

            {{-- Post URL --}}
            <div class="sm:col-span-2">
                <label class="block font-gummy text-xs font-bold tracking-[0.25em] text-lb-muted uppercase">
                    instagram post url
                </label>
                <input
                    name="post_url"
                    value="{{ old('post_url', $link->post_url) }}"
                    required
                    class="mt-2 w-full rounded-2xl border px-4 py-3 font-gummy font-bold shadow-sm outline-none transition
                        @error('post_url') border-red-400 bg-red-50/60 @else border-black/10 bg-white/70 focus:bg-white focus:border-black/20 @enderror"
                >
                @error('post_url')
                    <p class="mt-2 font-gummy text-sm font-extrabold lowercase text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Image URL --}}
            <div class="sm:col-span-2">
                <label class="block font-gummy text-xs font-bold tracking-[0.25em] text-lb-muted uppercase">
                    image url (optional)
                </label>
                <input
                    name="image_url"
                    value="{{ old('image_url', $link->image_url) }}"
                    class="mt-2 w-full rounded-2xl border px-4 py-3 font-gummy font-bold shadow-sm outline-none transition
                        @error('image_url') border-red-400 bg-red-50/60 @else border-black/10 bg-white/70 focus:bg-white focus:border-black/20 @enderror"
                >
                @error('image_url')
                    <p class="mt-2 font-gummy text-sm font-extrabold lowercase text-red-600">{{ $message }}</p>
                @enderror

                <p class="mt-2 font-gummy text-xs font-bold text-lb-muted lowercase">
                    leave blank to use the cute gradient tile ♡
                </p>

                {{-- Preview --}}
                <div class="mt-4">
                    <div class="font-gummy text-xs font-bold tracking-[0.25em] text-lb-muted uppercase">preview</div>

                    <div class="mt-2 overflow-hidden rounded-3xl border border-black/5 bg-white/70 shadow-sm">
                        <div class="relative aspect-square">
                            @if(!empty(old('image_url', $link->image_url)))
                                <img
                                    src="{{ old('image_url', $link->image_url) }}"
                                    alt="preview"
                                    class="h-full w-full object-cover"
                                    onerror="this.style.display='none'; this.nextElementSibling.classList.remove('hidden');"
                                >
                                <div class="hidden h-full w-full bg-gradient-to-br from-rose-100 via-pink-50 to-amber-50"></div>
                            @else
                                <div class="h-full w-full bg-gradient-to-br from-rose-100 via-pink-50 to-amber-50"></div>
                            @endif

                            <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/45 to-transparent p-4">
                                <div class="font-gummy text-lg font-extrabold lowercase text-white drop-shadow">
                                    {{ old('label', $link->label) ?: 'instagram post ♡' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Active --}}
            <div class="sm:col-span-2 flex items-center gap-3">
                <input
                    type="checkbox"
                    name="is_active"
                    value="1"
                    {{ old('is_active', $link->is_active) ? 'checked' : '' }}
                    class="h-5 w-5 rounded border-black/20"
                >
                <span class="font-gummy text-sm font-extrabold lowercase text-lb-ink">
                    active (show on home)
                </span>
            </div>
        </div>

        {{-- Actions --}}
        <div class="mt-6 flex flex-wrap gap-2">
            <button type="submit"
                class="rounded-full px-6 py-3 font-gummy text-sm font-extrabold lowercase
                       bg-gradient-to-r from-lb-yellow to-lb-pink/30 shadow-lg border border-black/5 hover:shadow-xl transition">
                update
            </button>

            <a href="{{ route('admin.instagram-links.show', $link) }}"
               class="rounded-full px-6 py-3 font-gummy text-sm font-extrabold lowercase
                      border border-black/5 bg-white/70 hover:bg-white transition shadow-sm">
                view
            </a>

            <a href="{{ route('admin.instagram-links.index') }}"
               class="rounded-full px-6 py-3 font-gummy text-sm font-extrabold lowercase
                      border border-black/5 bg-white/70 hover:bg-white transition shadow-sm">
                cancel
            </a>
        </div>
    </form>
</div>
@endsection
