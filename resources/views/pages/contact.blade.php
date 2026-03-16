@extends('layouts.app')

@section('content')

{{-- ─── Hero ──────────────────────────────────────────────────────────────── --}}
<section class="relative left-1/2 w-screen -translate-x-1/2 overflow-hidden bg-gradient-to-b from-rose-50 via-pink-50 to-amber-50 px-6 py-20 md:px-12">

    <div class="pointer-events-none absolute -top-24 -left-20 h-80 w-80 rounded-full bg-[#b9a7ff]/20 blur-3xl"></div>
    <div class="pointer-events-none absolute top-0 right-0 h-72 w-72 rounded-full bg-[#F46EE5]/15 blur-3xl"></div>

    <div class="relative mx-auto max-w-2xl text-center">
        <p class="mb-4 inline-flex items-center gap-2 rounded-full border border-black/5 bg-white/70 px-4 py-1.5 font-['Sour_Gummy'] text-xs font-bold lowercase tracking-widest text-[#706f6c] shadow-sm backdrop-blur">
            <span>✉️</span> get in touch
        </p>
        <h1 class="font-['Sour_Gummy'] text-5xl font-extrabold lowercase leading-tight text-[#1b1b18] drop-shadow-sm md:text-6xl">
            say hello ♡
        </h1>
        <p class="mt-4 font-['Sour_Gummy'] text-lg font-bold lowercase text-[#5a5246]">
            questions, custom orders, or just wanna chat — we'd love to hear from you!
        </p>
    </div>
</section>

{{-- ─── Form + Info ─────────────────────────────────────────────────────────── --}}
<section class="relative left-1/2 w-screen -translate-x-1/2 bg-white px-6 py-16 md:px-12">
    <div class="mx-auto max-w-5xl">
        <div class="grid grid-cols-1 gap-10 md:grid-cols-5">

            {{-- Info sidebar --}}
            <div class="md:col-span-2 space-y-6">
                <div class="rounded-3xl border border-black/5 bg-gradient-to-b from-[#fff7fb] to-[#fbf6ef] p-6 shadow-lg">
                    <h2 class="font-['Sour_Gummy'] text-2xl font-extrabold lowercase text-[#1b1b18] mb-5">reach us ♡</h2>

                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <div class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-[#FFC447]/60 to-[#F46EE5]/30 shadow-sm text-lg">📍</div>
                            <div>
                                <p class="font-['Sour_Gummy'] text-sm font-extrabold lowercase text-[#1b1b18]">location</p>
                                <p class="font-['Sour_Gummy'] text-sm font-bold lowercase text-[#706f6c]">sunnyvale, california</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-[#FFC447]/60 to-[#F46EE5]/30 shadow-sm text-lg">✉️</div>
                            <div>
                                <p class="font-['Sour_Gummy'] text-sm font-extrabold lowercase text-[#1b1b18]">email</p>
                                <a href="mailto:nguyenjoanne98@gmail.com" class="font-['Sour_Gummy'] text-sm font-bold lowercase text-[#8f7cfa] hover:underline">nguyenjoanne98@gmail.com</a>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-[#FFC447]/60 to-[#F46EE5]/30 shadow-sm text-lg">🕐</div>
                            <div>
                                <p class="font-['Sour_Gummy'] text-sm font-extrabold lowercase text-[#1b1b18]">response time</p>
                                <p class="font-['Sour_Gummy'] text-sm font-bold lowercase text-[#706f6c]">usually within 24–48 hours ♡</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rounded-3xl border border-black/5 bg-gradient-to-br from-[#1b1b18] to-[#2d2a24] p-6 shadow-lg text-center">
                    <p class="font-['Sour_Gummy'] text-lg font-extrabold lowercase text-white">ready to order?</p>
                    <p class="mt-1 font-['Sour_Gummy'] text-sm font-bold lowercase text-white/60">check out the order form for our full menu ♡</p>
                    <a href="{{ route('order-form') }}"
                       class="mt-4 inline-flex items-center rounded-full bg-gradient-to-r from-[#FFC447] to-[#F46EE5] px-6 py-2.5 font-['Sour_Gummy'] text-sm font-extrabold lowercase text-[#1b1b18] shadow-lg transition hover:scale-105">
                        order form →
                    </a>
                </div>
            </div>

            {{-- Contact Form --}}
            <div class="md:col-span-3">

                @if(session('success'))
                    {{-- Success state --}}
                    <div class="flex flex-col items-center justify-center rounded-3xl border border-emerald-100 bg-gradient-to-b from-emerald-50 to-white p-12 shadow-lg text-center">
                        <div class="text-6xl mb-5">🎉</div>
                        <h2 class="font-['Sour_Gummy'] text-3xl font-extrabold lowercase text-[#1b1b18]">message sent!</h2>
                        <p class="mt-3 font-['Sour_Gummy'] text-base font-bold lowercase text-[#706f6c]">
                            thanks for reaching out ♡ we'll get back to you soon!
                        </p>
                        <a href="{{ route('contact') }}"
                           class="mt-8 inline-flex rounded-full border border-black/10 bg-white px-6 py-2.5 font-['Sour_Gummy'] text-sm font-extrabold lowercase text-[#1b1b18] shadow transition hover:bg-rose-50">
                            send another message
                        </a>
                    </div>
                @else
                    <form method="POST" action="{{ route('contact.send') }}"
                          class="rounded-3xl border border-black/5 bg-white p-7 shadow-xl">
                        @csrf

                        <h2 class="font-['Sour_Gummy'] text-2xl font-extrabold lowercase text-[#1b1b18] mb-6">send a message</h2>

                        {{-- Errors --}}
                        @if($errors->any())
                            <div class="mb-5 rounded-2xl bg-rose-50 px-5 py-3 text-sm text-rose-600 font-semibold space-y-1">
                                @foreach($errors->all() as $err)
                                    <p>• {{ $err }}</p>
                                @endforeach
                            </div>
                        @endif

                        <div class="space-y-4">
                            {{-- Name + Email --}}
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <label class="mb-1.5 block font-['Sour_Gummy'] text-xs font-bold lowercase text-[#706f6c]">
                                        your name <span class="text-[#F46EE5]">*</span>
                                    </label>
                                    <input type="text" name="name" value="{{ old('name') }}"
                                           placeholder="e.g. Jane Doe"
                                           class="w-full rounded-2xl border @error('name') border-rose-300 bg-rose-50 @else border-black/10 bg-[#fafaf9] @enderror px-4 py-3 text-sm text-[#1b1b18] placeholder:text-[#a09880] focus:outline-none focus:ring-2 focus:ring-[#F46EE5]/40 transition">
                                </div>
                                <div>
                                    <label class="mb-1.5 block font-['Sour_Gummy'] text-xs font-bold lowercase text-[#706f6c]">
                                        email <span class="text-[#F46EE5]">*</span>
                                    </label>
                                    <input type="email" name="email" value="{{ old('email') }}"
                                           placeholder="you@example.com"
                                           class="w-full rounded-2xl border @error('email') border-rose-300 bg-rose-50 @else border-black/10 bg-[#fafaf9] @enderror px-4 py-3 text-sm text-[#1b1b18] placeholder:text-[#a09880] focus:outline-none focus:ring-2 focus:ring-[#F46EE5]/40 transition">
                                </div>
                            </div>

                            {{-- Phone + Subject --}}
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <label class="mb-1.5 block font-['Sour_Gummy'] text-xs font-bold lowercase text-[#706f6c]">phone (optional)</label>
                                    <input type="tel" name="phone" value="{{ old('phone') }}"
                                           placeholder="(555) 000-0000"
                                           class="w-full rounded-2xl border border-black/10 bg-[#fafaf9] px-4 py-3 text-sm text-[#1b1b18] placeholder:text-[#a09880] focus:outline-none focus:ring-2 focus:ring-[#F46EE5]/40 transition">
                                </div>
                                <div>
                                    <label class="mb-1.5 block font-['Sour_Gummy'] text-xs font-bold lowercase text-[#706f6c]">subject</label>
                                    <input type="text" name="subject" value="{{ old('subject') }}"
                                           placeholder="custom order, question…"
                                           class="w-full rounded-2xl border border-black/10 bg-[#fafaf9] px-4 py-3 text-sm text-[#1b1b18] placeholder:text-[#a09880] focus:outline-none focus:ring-2 focus:ring-[#F46EE5]/40 transition">
                                </div>
                            </div>

                            {{-- Message --}}
                            <div>
                                <label class="mb-1.5 block font-['Sour_Gummy'] text-xs font-bold lowercase text-[#706f6c]">
                                    message <span class="text-[#F46EE5]">*</span>
                                </label>
                                <textarea name="message" rows="5"
                                          placeholder="tell us about your order, event, or just say hi ♡"
                                          class="w-full rounded-2xl border @error('message') border-rose-300 bg-rose-50 @else border-black/10 bg-[#fafaf9] @enderror px-4 py-3 text-sm text-[#1b1b18] placeholder:text-[#a09880] focus:outline-none focus:ring-2 focus:ring-[#F46EE5]/40 transition resize-none">{{ old('message') }}</textarea>
                            </div>

                            {{-- Submit --}}
                            <button type="submit"
                                    class="w-full rounded-full bg-gradient-to-r from-[#8f7cfa] to-[#f46ee5] px-6 py-3.5 font-['Sour_Gummy'] text-base font-extrabold lowercase text-white shadow-xl transition hover:scale-[1.01] hover:shadow-2xl active:scale-95">
                                send message ✉️
                            </button>

                            <p class="text-center font-['Sour_Gummy'] text-xs font-bold lowercase text-[#a09880]">
                                we'll reply within 24–48 hours ♡
                            </p>
                        </div>
                    </form>
                @endif
            </div>

        </div>
    </div>
</section>

@endsection
