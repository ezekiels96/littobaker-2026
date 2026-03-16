<?php

use Illuminate\Support\Facades\Route;
use App\Models\InstagramLink;
use App\Http\Controllers\GalleryPageController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ContactController;

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
    $about = \App\Models\AboutSetting::getInstance();
    return view('pages.about', compact('about'));
})->name('about');

// Menu Page
Route::get('/menu', [\App\Http\Controllers\MenuPageController::class, 'index'])->name('menu.index');

// Order Form Page
Route::get('/order-form', function () {
    $menus = \App\Models\Menu::with('images')->orderBy('sort_order')->get();
    return view('pages.order-form', compact('menus'));
})->name('order-form');

// Contact Page
Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

// Gallery Page
Route::get('/gallery', [GalleryPageController::class, 'index'])->name('gallery');

// Cart Routes
Route::post('/cart/add',      [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove',   [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/update',   [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/clear',    [CartController::class, 'clear'])->name('cart.clear');
Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::get('/cart',           [CartController::class, 'get'])->name('cart.get');


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

    // About Admin
    Route::get('/admin/about',  [\App\Http\Controllers\Admin\AboutController::class, 'edit'])->name('admin.about.edit');
    Route::post('/admin/about', [\App\Http\Controllers\Admin\AboutController::class, 'update'])->name('admin.about.update');

    // Home Admin
    Route::get('/admin/home',  [\App\Http\Controllers\Admin\HomeController::class, 'edit'])->name('admin.home.edit');
    Route::post('/admin/home', [\App\Http\Controllers\Admin\HomeController::class, 'update'])->name('admin.home.update');
});
