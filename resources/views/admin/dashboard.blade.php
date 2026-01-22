@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-3xl py-12">
    <h1 class="mb-8 text-3xl font-bold text-center text-[#1b1b18]">Admin Dashboard</h1>
    <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
        <a href="{{ route('admin.gallery.index') }}" class="rounded-xl border border-[#FFC447] bg-white p-8 text-center shadow-lg transition hover:scale-105">
            <div class="mb-2 text-2xl">🖼️</div>
            <div class="text-lg font-semibold">Manage Gallery</div>
        </a>
        <a href="{{ route('admin.menu.index') }}" class="rounded-xl border border-[#F46EE5] bg-white p-8 text-center shadow-lg transition hover:scale-105">
            <div class="mb-2 text-2xl">🍰</div>
            <div class="text-lg font-semibold">Manage Menu</div>
        </a>
    </div>
</div>
@endsection
