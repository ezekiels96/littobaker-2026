<?php

use Illuminate\Support\Facades\Route;
use App\Models\InstagramLink;
use App\Models\GalleryItem;
use App\Models\Tag;
// Home Page
Route::get('/', function () {
    $igPosts = InstagramLink::where('is_active', true)
        ->orderBy('sort_order')
        ->limit(6)
        ->get();

    return view('pages.home', compact('igPosts'));
})->name('home');
// About Page
Route::get('/about', function () {
    return view('pages.about');
})->name('about');

// Menu Page
Route::get('/menu', [\App\Http\Controllers\MenuPageController::class, 'index'])->name('menu.index');


// Order Form Page
Route::get('/order-form', function () {
    return view('pages.order-form');
})->name('order-form');

// Contact Page
Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

Route::get('/gallery', function () {
    $tagSlug = request('tag');

    $tags = Tag::orderBy('name')->get();

    $items = GalleryItem::query()
        ->where('is_active', true)
        ->with('tags')
        ->when($tagSlug, function ($q) use ($tagSlug) {
            $q->whereHas('tags', fn($t) => $t->where('slug', $tagSlug));
        })
        ->orderBy('sort_order')
        ->get();

    return view('pages.gallery', compact('items', 'tags', 'tagSlug'));
})->name('gallery');

// Admin Login & Logout
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

Route::post('/admin/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('admin.login');
})->name('logout');

// Admin Dashboard (protected)
Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Gallery CRUD routes (stub)
    Route::get('/admin/gallery', function () {
        return 'Gallery CRUD coming soon!';
    })->name('admin.gallery.index');

    // Menu CRUD routes
    Route::resource('admin/menu', App\Http\Controllers\Admin\MenuController::class)->names('admin.menu');
    Route::post('admin/menu/reorder', [App\Http\Controllers\Admin\MenuController::class, 'reorder'])
    ->name('admin.menu.reorder');
    Route::resource('admin/instagram-links', App\Http\Controllers\Admin\InstagramLinkController::class)
    ->names('admin.instagram-links');
    Route::resource('admin/gallery', App\Http\Controllers\Admin\GalleryController::class)
    ->names('admin.gallery');
        Route::resource('admin/tags', App\Http\Controllers\Admin\TagController::class)
            ->names('admin.tags');


});
