@extends('admin.layouts.app')

@section('content')
<div class="mx-auto max-w-3xl">
    {{-- Header --}}
    <div class="mb-6">
        <h1 class="font-gummy text-4xl font-extrabold lowercase text-lb-ink">add gallery item</h1>
        <p class="mt-1 font-gummy text-sm font-bold lowercase text-lb-muted">
            paste a cloudinary image url + optional tags ✨
        </p>
    </div>

    {{-- Global error block --}}
    @if ($errors->any())
        <div class="mb-6 rounded-3xl border border-red-200 bg-white/70 p-5 shadow">
            <div class="font-gummy text-lg font-extrabold lowercase text-red-700">
                please fix the errors below:
            </div>
            <ul class="mt-2 list-disc pl-5 font-gummy text-sm font-bold text-red-700">
                @foreach ($errors->all() as $error)
                    <li class="lowercase">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.gallery.store') }}" method="POST"
          class="relative overflow-hidden rounded-3xl border border-black/5 bg-white/70 p-6 shadow-xl backdrop-blur">
        @csrf

        {{-- soft glows --}}
        <div class="pointer-events-none absolute -top-24 -right-24 h-72 w-72 rounded-full bg-lb-pink/20 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-24 -left-24 h-72 w-72 rounded-full bg-lb-yellow/20 blur-3xl"></div>

        <div class="relative flex flex-col gap-5">
            {{-- Title --}}
            <div>
                <label class="font-gummy text-sm font-extrabold lowercase text-lb-ink">title (optional)</label>
                <input
                    type="text"
                    name="title"
                    value="{{ old('title') }}"
                    class="mt-2 w-full rounded-2xl border border-black/10 bg-white/80 px-4 py-3 shadow-sm
                           focus:outline-none focus:ring-2 focus:ring-lb-pink/40"
                    placeholder="ex: pandan cookies"
                >
                @error('title')
                    <p class="mt-2 font-gummy text-sm font-bold lowercase text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Caption --}}
            <div>
                <label class="font-gummy text-sm font-extrabold lowercase text-lb-ink">caption (optional)</label>
                <textarea
                    name="caption"
                    rows="4"
                    class="mt-2 w-full rounded-2xl border border-black/10 bg-white/80 px-4 py-3 shadow-sm
                           focus:outline-none focus:ring-2 focus:ring-lb-pink/40"
                    placeholder="a cute lil caption ♡"
                >{{ old('caption') }}</textarea>
                @error('caption')
                    <p class="mt-2 font-gummy text-sm font-bold lowercase text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Image URL --}}
            <div>
                <label class="font-gummy text-sm font-extrabold lowercase text-lb-ink">image url (cloudinary)</label>
                <input
                    type="url"
                    name="image_url"
                    value="{{ old('image_url') }}"
                    class="mt-2 w-full rounded-2xl border border-black/10 bg-white/80 px-4 py-3 shadow-sm
                           focus:outline-none focus:ring-2 focus:ring-lb-pink/40"
                    placeholder="https://res.cloudinary.com/.../image.jpg"
                    required
                >
                <p class="mt-2 font-gummy text-xs font-bold lowercase text-lb-muted">
                    tip: paste the secure_url from cloudinary
                </p>
                @error('image_url')
                    <p class="mt-2 font-gummy text-sm font-bold lowercase text-red-600">{{ $message }}</p>
                @enderror

                {{-- Preview --}}
                @php $previewUrl = old('image_url'); @endphp
                @if(!empty($previewUrl))
                    <div class="mt-4">
                        <div class="font-gummy text-sm font-extrabold lowercase text-lb-muted">preview</div>
                        <div class="mt-2 overflow-hidden rounded-3xl ring-1 ring-black/10 bg-white">
                            <img
                                src="{{ $previewUrl }}"
                                alt="preview"
                                class="h-72 w-full object-cover"
                                onerror="this.style.display='none'; this.parentElement.insertAdjacentHTML('beforeend', '<div class=&quot;p-6 font-gummy font-bold lowercase text-lb-muted&quot;>couldn\\'t load preview 🥲</div>');"
                            >
                        </div>
                    </div>
                @endif
            </div>

            {{-- Tags CSV --}}
            <div>
                <label class="font-gummy text-sm font-extrabold lowercase text-lb-ink">tags (comma separated)</label>
                <input
                    type="text"
                    name="tags_csv"
                    value="{{ old('tags_csv') }}"
                    class="mt-2 w-full rounded-2xl border border-black/10 bg-white/80 px-4 py-3 shadow-sm
                           focus:outline-none focus:ring-2 focus:ring-lb-pink/40"
                    placeholder="cookies, cupcakes, valentines"
                >
                @error('tags_csv')
                    <p class="mt-2 font-gummy text-sm font-bold lowercase text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Active --}}
            <div class="flex items-center gap-3">
                <input
                    id="is_active"
                    type="checkbox"
                    name="is_active"
                    value="1"
                    class="h-5 w-5 rounded border-black/20 text-lb-pink focus:ring-lb-pink/40"
                    {{ old('is_active', true) ? 'checked' : '' }}
                >
                <label for="is_active" class="font-gummy text-sm font-extrabold lowercase text-lb-ink">
                    active (show on gallery)
                </label>
            </div>

            {{-- Actions --}}
            <div class="mt-2 flex flex-wrap gap-2">
                <button type="submit"
                        class="inline-flex items-center justify-center rounded-full px-6 py-3
                               font-gummy text-sm font-extrabold lowercase
                               bg-gradient-to-r from-lb-yellow to-lb-pink/30
                               shadow-lg border border-black/5 hover:shadow-xl transition">
                    save ♡
                </button>

                <a href="{{ route('admin.gallery.index') }}"
                   class="inline-flex items-center justify-center rounded-full px-6 py-3
                          font-gummy text-sm font-extrabold lowercase
                          border border-black/10 bg-white/70 hover:bg-white shadow-sm transition">
                    cancel
                </a>
            </div>
        </div>
    </form>
</div>
@endsection
