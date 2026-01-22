@extends('layouts.app')

@section('content')
@php
    $heroImage = 'https://res.cloudinary.com/dtbjsvd1l/image/upload/v1769070837/IMG_4829_bltwzk.jpg?auto=format&fit=crop&w=1800&q=80';
@endphp

<section class="relative isolate left-1/2 w-screen -translate-x-1/2 overflow-hidden rounded-none bg-gradient-to-r from-rose-100 via-pink-50 to-amber-50 px-6 py-24 text-center shadow-2xl md:px-12">
    <img src="{{ $heroImage }}" alt="Cupcakes on pink stands" class="absolute inset-0 -z-20 h-full w-full object-cover">
    <div class="relative mx-auto max-w-2xl space-y-6">
        <h2 class="font-['Sour_Gummy'] text-5xl font-extrabold text-white drop-shadow-lg md:text-6xl lowercase">
            delicious asian inspired sweet treats
        </h2>
        <div class="flex flex-col items-center gap-3 sm:flex-row sm:justify-center">
            <a href="{{ route('menu') }}" class="inline-flex items-center justify-center rounded-full bg-gradient-to-r from-[#FFC447] to-[#F46EE5] px-10 py-3 text-lg font-bold tracking-wide text-[#1b1b18] shadow-xl transition hover:scale-105">
                View Menu
            </a>
        </div>
    </div>
</section>

<section class="relative left-1/2 w-screen -translate-x-1/2 bg-[#FFE5F0] px-6 py-16 md:px-12">
    <div class="mx-auto grid max-w-4xl grid-cols-1 gap-8 md:grid-cols-[0.7fr_0.7fr] md:items-center">
        <div class="aspect-square overflow-hidden rounded-3xl shadow-lg">
            <img src="https://res.cloudinary.com/dtbjsvd1l/image/upload/v1769070835/IMG_0600_jpg_pcbyz2.jpg?auto=format&fit=crop&w=1400&q=80" alt="Custom cakes displayed on pastel stands" class="h-full w-full object-cover">
        </div>
        <div class="space-y-6 text-left">
            <h3 class="font-['Sour_Gummy'] text-3xl font-extrabold text-[#1b1b18] drop-shadow-lg md:text-4xl lowercase">specially made with love with every order</h3>
            <p class="font-['Sour_Gummy'] text-base leading-relaxed text-[#5a5246] lowercase">
                littobaker is a woman owned home based bakery that specializes in incorporating asian-inspired flavors into typical sweet treats.
            </p>
            <a href="{{ route('order-form') }}" class="inline-flex items-center justify-center rounded-full bg-gradient-to-r from-[#8f7cfa] to-[#f46ee5] px-10 py-3 text-lg font-bold tracking-wide text-white shadow-xl transition hover:scale-105">
                Order Now
            </a>
        </div>
    </div>
</section>
@endsection
