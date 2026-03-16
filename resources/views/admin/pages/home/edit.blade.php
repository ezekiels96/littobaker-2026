@extends('admin.layouts.app')

@section('title', 'home page')

@section('content')
<div class="flex flex-col gap-6">

    {{-- Header --}}
    <div class="rounded-3xl border border-black/5 bg-white/70 p-6 shadow-lg backdrop-blur">
        <h1 class="font-gummy text-4xl font-extrabold lowercase text-lb-ink">home page editor</h1>
        <p class="mt-1 font-gummy text-sm font-bold lowercase text-lb-muted">edit your home page hero and feature section ♡</p>
    </div>

    @if(session('success'))
        <div class="rounded-2xl border border-emerald-100 bg-emerald-50 px-5 py-3 font-gummy text-sm font-bold lowercase text-emerald-700">
            ✓ {{ session('success') }}
        </div>
    @endif

    <form id="homeForm" method="POST" action="{{ route('admin.home.update') }}" class="flex flex-col gap-6">
        @csrf

        {{-- ── Hero Section ── --}}
        <div class="rounded-3xl border border-black/5 bg-white/70 p-6 shadow-lg backdrop-blur space-y-5">
            <div class="flex items-center gap-3 pb-2 border-b border-black/5">
                <div class="grid h-9 w-9 place-items-center rounded-xl bg-gradient-to-br from-lb-yellow/60 to-lb-pink/30 text-lg shadow-sm">🌟</div>
                <h2 class="font-gummy text-xl font-extrabold lowercase text-lb-ink">hero section</h2>
            </div>

            {{-- Hero Heading --}}
            <div>
                <label class="mb-1.5 block font-gummy text-sm font-bold lowercase text-lb-muted">hero heading</label>
                <input type="text" name="hero_heading"
                       value="{{ old('hero_heading', $home->hero_heading) }}"
                       placeholder="delicious asian inspired sweet treats"
                       class="w-full rounded-2xl border @error('hero_heading') border-rose-300 bg-rose-50 @else border-black/10 bg-white @enderror px-4 py-3 text-sm text-lb-ink placeholder:text-lb-muted/50 focus:outline-none focus:ring-2 focus:ring-lb-pink/40 shadow-sm">
                @error('hero_heading') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                <p class="mt-1 font-gummy text-xs font-bold lowercase text-lb-muted/70">the large text displayed over the hero photo</p>
            </div>

            {{-- Hero Image --}}
            <div class="flex flex-col gap-4 md:flex-row md:items-start md:gap-6">
                <div class="h-36 w-64 shrink-0 overflow-hidden rounded-2xl border border-black/10 bg-gradient-to-br from-lb-yellow/20 to-lb-pink/10 shadow-md">
                    <img id="heroImgPreview"
                         src="{{ $home->hero_image }}"
                         alt="Hero preview"
                         class="{{ $home->hero_image ? '' : 'hidden' }} h-full w-full object-cover">
                    <div id="heroImgPlaceholder" class="{{ $home->hero_image ? 'hidden' : '' }} flex h-full w-full items-center justify-center text-4xl">🌅</div>
                </div>
                <div class="flex-1 space-y-2">
                    <label class="block font-gummy text-sm font-bold lowercase text-lb-muted">hero background image url</label>
                    <input type="url" name="hero_image" id="heroImageInput"
                           value="{{ old('hero_image', $home->hero_image) }}"
                           placeholder="https://res.cloudinary.com/..."
                           oninput="previewImg('heroImgPreview','heroImgPlaceholder',this.value)"
                           class="w-full rounded-2xl border border-black/10 bg-white px-4 py-3 text-sm text-lb-ink placeholder:text-lb-muted/50 focus:outline-none focus:ring-2 focus:ring-lb-pink/40 shadow-sm">
                    @error('hero_image') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                    <p class="font-gummy text-xs font-bold lowercase text-lb-muted/70">shown as the full-width background of the top banner</p>
                </div>
            </div>
        </div>

        {{-- ── Feature Section ── --}}
        <div class="rounded-3xl border border-black/5 bg-white/70 p-6 shadow-lg backdrop-blur space-y-5">
            <div class="flex items-center gap-3 pb-2 border-b border-black/5">
                <div class="grid h-9 w-9 place-items-center rounded-xl bg-gradient-to-br from-lb-lilac/40 to-lb-pink/30 text-lg shadow-sm">💝</div>
                <h2 class="font-gummy text-xl font-extrabold lowercase text-lb-ink">feature section</h2>
            </div>

            {{-- Feature Heading --}}
            <div>
                <label class="mb-1.5 block font-gummy text-sm font-bold lowercase text-lb-muted">section heading</label>
                <input type="text" name="feature_heading"
                       value="{{ old('feature_heading', $home->feature_heading) }}"
                       placeholder="specially made with love with every order"
                       class="w-full rounded-2xl border @error('feature_heading') border-rose-300 bg-rose-50 @else border-black/10 bg-white @enderror px-4 py-3 text-sm text-lb-ink placeholder:text-lb-muted/50 focus:outline-none focus:ring-2 focus:ring-lb-pink/40 shadow-sm">
                @error('feature_heading') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
            </div>

            {{-- Feature Text --}}
            <div>
                <label class="mb-1.5 block font-gummy text-sm font-bold lowercase text-lb-muted">paragraph text</label>
                <textarea name="feature_text" rows="3"
                          placeholder="littobaker is a woman owned home based bakery…"
                          class="w-full rounded-2xl border @error('feature_text') border-rose-300 bg-rose-50 @else border-black/10 bg-white @enderror px-4 py-3 text-sm text-lb-ink placeholder:text-lb-muted/50 focus:outline-none focus:ring-2 focus:ring-lb-pink/40 shadow-sm resize-none">{{ old('feature_text', $home->feature_text) }}</textarea>
                @error('feature_text') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
            </div>

            {{-- Feature Image --}}
            <div class="flex flex-col gap-4 md:flex-row md:items-start md:gap-6">
                <div class="h-36 w-36 shrink-0 overflow-hidden rounded-2xl border border-black/10 bg-gradient-to-br from-lb-yellow/20 to-lb-pink/10 shadow-md">
                    <img id="featureImgPreview"
                         src="{{ $home->feature_image }}"
                         alt="Feature preview"
                         class="{{ $home->feature_image ? '' : 'hidden' }} h-full w-full object-cover">
                    <div id="featureImgPlaceholder" class="{{ $home->feature_image ? 'hidden' : '' }} flex h-full w-full items-center justify-center text-4xl">🖼️</div>
                </div>
                <div class="flex-1 space-y-2">
                    <label class="block font-gummy text-sm font-bold lowercase text-lb-muted">feature image url</label>
                    <input type="url" name="feature_image" id="featureImageInput"
                           value="{{ old('feature_image', $home->feature_image) }}"
                           placeholder="https://res.cloudinary.com/..."
                           oninput="previewImg('featureImgPreview','featureImgPlaceholder',this.value)"
                           class="w-full rounded-2xl border border-black/10 bg-white px-4 py-3 text-sm text-lb-ink placeholder:text-lb-muted/50 focus:outline-none focus:ring-2 focus:ring-lb-pink/40 shadow-sm">
                    @error('feature_image') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                    <p class="font-gummy text-xs font-bold lowercase text-lb-muted/70">the square photo shown beside the text</p>
                </div>
            </div>
        </div>

        {{-- Save --}}
        <div class="flex items-center gap-4">
            <button type="submit"
                    class="rounded-full bg-gradient-to-r from-lb-yellow to-lb-pink/60 px-8 py-3 font-gummy text-base font-extrabold lowercase text-lb-ink shadow-lg transition hover:scale-[1.02] hover:shadow-xl">
                save changes ♡
            </button>
            <a href="{{ route('home') }}" target="_blank"
               class="rounded-full border border-black/10 bg-white/70 px-6 py-3 font-gummy text-sm font-extrabold lowercase text-lb-ink shadow-sm transition hover:bg-white">
                preview home page →
            </a>
        </div>
    </form>
</div>

<script>
function previewImg(imgId, placeholderId, url) {
    const img = document.getElementById(imgId);
    const ph  = document.getElementById(placeholderId);
    if (url) {
        img.src = url;
        img.classList.remove('hidden');
        ph.classList.add('hidden');
    } else {
        img.src = '';
        img.classList.add('hidden');
        ph.classList.remove('hidden');
    }
}
</script>
@endsection
