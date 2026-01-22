@extends('layouts.app')

@section('content')
<div class="flex min-h-[60vh] items-center justify-center">
    <form method="POST" action="{{ route('admin.login') }}" class="w-full max-w-sm rounded-2xl bg-white p-8 shadow-xl">
        @csrf
        <h2 class="mb-6 text-center text-2xl font-bold text-[#1b1b18]">Admin Login</h2>
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-[#5a5246] mb-2">Email</label>
            <input type="email" name="email" id="email" required class="w-full rounded-lg border border-[#e3e3e0] px-4 py-2 focus:border-[#FFC447] focus:outline-none">
        </div>
        <div class="mb-6">
            <label for="password" class="block text-sm font-medium text-[#5a5246] mb-2">Password</label>
            <input type="password" name="password" id="password" required class="w-full rounded-lg border border-[#e3e3e0] px-4 py-2 focus:border-[#FFC447] focus:outline-none">
        </div>
        <button type="submit" class="w-full rounded-full bg-gradient-to-r from-[#FFC447] to-[#F46EE5] px-6 py-3 text-lg font-bold text-[#1b1b18] shadow-md transition hover:scale-105">Login</button>
    </form>
</div>
@endsection
