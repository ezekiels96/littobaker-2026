<?php

use Illuminate\Support\Facades\Route;

// Home Page
Route::get('/', function () {
    return view('pages.home');
})->name('home');

// About Page
Route::get('/about', function () {
    return view('pages.about');
})->name('about');

// Menu Page
Route::get('/menu', function () {
    return view('pages.menu');
})->name('menu');

// Order Form Page
Route::get('/order-form', function () {
    return view('pages.order-form');
})->name('order-form');

// Contact Page
Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

// Admin Login
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
Route::get('/admin', function () {
    return view('admin.login');
})->name('admin.login');

Route::post('/admin', function (Request $request) {
    $credentials = $request->only('email', 'password');
    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->route('admin.dashboard');
    }
    return back()->withErrors([
        'email' => 'Invalid credentials.',
    ])->withInput();
});

// Admin Dashboard (protected)
Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Gallery CRUD routes (stub)
    Route::get('/admin/gallery', function () {
        return 'Gallery CRUD coming soon!';
    })->name('admin.gallery.index');

    // Menu CRUD routes (stub)
    Route::get('/admin/menu', function () {
        return 'Menu CRUD coming soon!';
    })->name('admin.menu.index');
});
