@extends('admin.layouts.app')

@section('title', 'add instagram link')

@section('content')
<div class="flex flex-col gap-4">
    <div class="flex items-end justify-between gap-3">
        <div>
            <h1 class="font-gummy text-4xl font-extrabold lowercase text-lb-ink">add instagram link</h1>
            <p class="font-gummy text-sm font-bold text-lb-muted lowercase">add a post for the home preview ♡</p>
        </div>
        <a href="{{ route('admin.instagram-links.index') }}"
           class="rounded-full px-5 py-3 font-gummy text-sm font-extrabold lowercase border border-black/5 bg-white/70 hover:bg-white transition shadow-sm">
            back
        </a>
    </div>

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

    <form method="POST" action="{{ route('admin.instagram-links.store') }}"
          class="rounded-3xl border border-black/5 bg-white/70 p-6 shadow-lg backdrop-blur">
        @csrf

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div class="sm:col-span-2">
                <label class="block font-gummy text-xs font-bold tracking-[0.25em] text-lb-muted uppercase">label</label>
                <input name="label" value="{{ old('label') }}"
                       class="mt-2 w-full rounded-2xl border border-black/10 bg-white/70 px-4 py-3 font-gummy font-bold lowercase shadow-sm outline-none focus:bg-white">
                <p class="mt-2 font-gummy text-xs font-bold text-lb-muted lowercase">example: “pandan cookies 💚”</p>
            </div>

            <div class="sm:col-span-2">
                <label class="block font-gummy text-xs font-bold tracking-[0.25em] text-lb-muted uppercase">instagram post url</label>
                <input name="post_url" value="{{ old('post_url') }}" required
                       class="mt-2 w-full rounded-2xl border border-black/10 bg-white/70 px-4 py-3 font-gummy font-bold shadow-sm outline-none focus:bg-white">
            </div>

            <div class="sm:col-span-2">
                <label class="block font-gummy text-xs font-bold tracking-[0.25em] text-lb-muted uppercase">image url (optional)</label>
                <input name="image_url" value="{{ old('image_url') }}"
                       class="mt-2 w-full rounded-2xl border border-black/10 bg-white/70 px-4 py-3 font-gummy font-bold shadow-sm outline-none focus:bg-white">
                <p class="mt-2 font-gummy text-xs font-bold text-lb-muted lowercase">
                    optional thumbnail preview image (if blank, we’ll show a cute gradient tile)
                </p>
            </div>

            <div class="sm:col-span-2 flex items-center gap-3">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                       class="h-5 w-5 rounded border-black/20">
                <span class="font-gummy text-sm font-extrabold lowercase text-lb-ink">active (show on home)</span>
            </div>
        </div>

        <div class="mt-6 flex gap-2">
            <button type="submit"
                class="rounded-full px-6 py-3 font-gummy text-sm font-extrabold lowercase
                       bg-gradient-to-r from-lb-yellow to-lb-pink/30 shadow-lg border border-black/5 hover:shadow-xl transition">
                save
            </button>

            <a href="{{ route('admin.instagram-links.index') }}"
               class="rounded-full px-6 py-3 font-gummy text-sm font-extrabold lowercase border border-black/5 bg-white/70 hover:bg-white transition shadow-sm">
                cancel
            </a>
        </div>
    </form>
</div>
@endsection
