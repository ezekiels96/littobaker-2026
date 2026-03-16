@extends('admin.layouts.app')

@section('title', 'about page')

@section('content')
<div class="flex flex-col gap-6">

    {{-- Header --}}
    <div class="rounded-3xl border border-black/5 bg-white/70 p-6 shadow-lg backdrop-blur">
        <h1 class="font-gummy text-4xl font-extrabold lowercase text-lb-ink">about page editor</h1>
        <p class="mt-1 font-gummy text-sm font-bold lowercase text-lb-muted">edit your about page content and photo ♡</p>
    </div>

    @if(session('success'))
        <div class="rounded-2xl border border-emerald-100 bg-emerald-50 px-5 py-3 font-gummy text-sm font-bold lowercase text-emerald-700">
            ✓ {{ session('success') }}
        </div>
    @endif

    <form id="aboutForm" method="POST" action="{{ route('admin.about.update') }}" class="flex flex-col gap-6">
        @csrf

        {{-- Hero Text --}}
        <div class="rounded-3xl border border-black/5 bg-white/70 p-6 shadow-lg backdrop-blur space-y-4">
            <div class="flex items-center gap-3 pb-2 border-b border-black/5">
                <div class="grid h-9 w-9 place-items-center rounded-xl bg-gradient-to-br from-lb-yellow/60 to-lb-pink/30 text-lg shadow-sm">✨</div>
                <h2 class="font-gummy text-xl font-extrabold lowercase text-lb-ink">hero section text</h2>
            </div>

            <div>
                <label class="mb-1.5 block font-gummy text-sm font-bold lowercase text-lb-muted">page heading</label>
                <input type="text" name="hero_heading"
                       value="{{ old('hero_heading', $about->hero_heading) }}"
                       placeholder="about littobaker"
                       class="w-full rounded-2xl border @error('hero_heading') border-rose-300 bg-rose-50 @else border-black/10 bg-white @enderror px-4 py-3 text-sm text-lb-ink placeholder:text-lb-muted/50 focus:outline-none focus:ring-2 focus:ring-lb-pink/40 shadow-sm">
                @error('hero_heading') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                <p class="mt-1 font-gummy text-xs font-bold lowercase text-lb-muted/70">the big title displayed at the top of the about page</p>
            </div>

            <div>
                <label class="mb-1.5 block font-gummy text-sm font-bold lowercase text-lb-muted">tagline</label>
                <input type="text" name="hero_tagline"
                       value="{{ old('hero_tagline', $about->hero_tagline) }}"
                       placeholder="asian-inspired sweet treats made with love ♡"
                       class="w-full rounded-2xl border @error('hero_tagline') border-rose-300 bg-rose-50 @else border-black/10 bg-white @enderror px-4 py-3 text-sm text-lb-ink placeholder:text-lb-muted/50 focus:outline-none focus:ring-2 focus:ring-lb-pink/40 shadow-sm">
                @error('hero_tagline') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                <p class="mt-1 font-gummy text-xs font-bold lowercase text-lb-muted/70">the subtitle line shown below the heading</p>
            </div>
        </div>

        {{-- Photo Section --}}
        <div class="rounded-3xl border border-black/5 bg-white/70 p-6 shadow-lg backdrop-blur">
            <h2 class="font-gummy text-xl font-extrabold lowercase text-lb-ink mb-4">profile photo</h2>

            <div class="flex flex-col gap-4 md:flex-row md:items-start md:gap-6">
                {{-- Preview --}}
                <div class="h-40 w-40 shrink-0 overflow-hidden rounded-3xl border border-black/10 bg-gradient-to-br from-lb-yellow/30 to-lb-pink/20 shadow-md flex items-center justify-center">
                    @if($about->image_url)
                        <img id="imgPreview" src="{{ $about->image_url }}" alt="About photo" class="h-full w-full object-cover">
                    @else
                        <div id="imgPlaceholder" class="text-5xl">🍪</div>
                        <img id="imgPreview" src="" alt="" class="hidden h-full w-full object-cover">
                    @endif
                </div>

                <div class="flex-1 space-y-3">
                    <div>
                        <label class="mb-1.5 block font-gummy text-sm font-bold lowercase text-lb-muted">image url (cloudinary or any image link)</label>
                        <input type="url" name="image_url" id="imageUrlInput"
                               value="{{ old('image_url', $about->image_url) }}"
                               placeholder="https://res.cloudinary.com/..."
                               class="w-full rounded-2xl border border-black/10 bg-white px-4 py-3 text-sm text-lb-ink placeholder:text-lb-muted/50 focus:outline-none focus:ring-2 focus:ring-lb-pink/40 shadow-sm"
                               oninput="previewImg(this.value)">
                        @error('image_url')
                            <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <p class="font-gummy text-xs font-bold lowercase text-lb-muted">
                        tip: upload to cloudinary and paste the url here ♡
                    </p>
                </div>
            </div>
        </div>

        {{-- Content Editor --}}
        <div class="rounded-3xl border border-black/5 bg-white/70 p-6 shadow-lg backdrop-blur">
            <h2 class="font-gummy text-xl font-extrabold lowercase text-lb-ink mb-2">page content</h2>
            <p class="font-gummy text-xs font-bold lowercase text-lb-muted mb-4">
                use the editor below — format text, add headings, lists, links, and more ♡
            </p>

            {{-- Quill Editor --}}
            <div id="quillEditor" style="min-height: 320px; font-size: 15px; font-family: 'Instrument Sans', sans-serif;"
                 class="rounded-2xl overflow-hidden border border-black/10 bg-white shadow-sm">
            </div>

            {{-- Hidden textarea that Quill writes to --}}
            <input type="hidden" name="content" id="contentInput" value="{{ old('content', $about->content) }}">

            @error('content')
                <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Save Button --}}
        <div class="flex items-center gap-4">
            <button type="submit"
                    class="rounded-full bg-gradient-to-r from-lb-yellow to-lb-pink/60 px-8 py-3 font-gummy text-base font-extrabold lowercase text-lb-ink shadow-lg transition hover:scale-[1.02] hover:shadow-xl">
                save changes ♡
            </button>
            <a href="{{ route('about') }}" target="_blank"
               class="rounded-full border border-black/10 bg-white/70 px-6 py-3 font-gummy text-sm font-extrabold lowercase text-lb-ink shadow-sm transition hover:bg-white">
                preview about page →
            </a>
        </div>
    </form>
</div>

{{-- Quill.js --}}
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.7/quill.js"></script>

<style>
    .ql-toolbar.ql-snow { border: none; border-bottom: 1px solid rgba(0,0,0,0.06); padding: 10px 14px; background: #fbf6ef; border-radius: 16px 16px 0 0; }
    .ql-container.ql-snow { border: none; }
    .ql-editor { min-height: 280px; padding: 16px 20px; line-height: 1.75; }
    .ql-editor p { margin-bottom: 0.75em; }
</style>

<script>
    const quill = new Quill('#quillEditor', {
        theme: 'snow',
        placeholder: 'tell your story here ♡',
        modules: {
            toolbar: [
                [{ header: [1, 2, 3, false] }],
                ['bold', 'italic', 'underline'],
                [{ list: 'ordered' }, { list: 'bullet' }],
                ['link', 'blockquote'],
                ['clean'],
            ],
        },
    });

    // Load existing content
    const existing = document.getElementById('contentInput').value;
    if (existing) {
        quill.root.innerHTML = existing;
    }

    // On form submit, sync Quill HTML → hidden input
    document.getElementById('aboutForm').addEventListener('submit', () => {
        document.getElementById('contentInput').value = quill.root.innerHTML;
    });

    // Image URL preview
    function previewImg(url) {
        const preview = document.getElementById('imgPreview');
        const placeholder = document.getElementById('imgPlaceholder');
        if (url) {
            preview.src = url;
            preview.classList.remove('hidden');
            if (placeholder) placeholder.classList.add('hidden');
        } else {
            preview.src = '';
            preview.classList.add('hidden');
            if (placeholder) placeholder.classList.remove('hidden');
        }
    }
</script>
@endsection
