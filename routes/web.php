<?php

use Illuminate\Support\Facades\Route;

// Public Pages
Route::view('/', 'welcome')->name('home');
Route::view('/produk', 'pages.products.index')->name('products.index');
Route::get('/produk/{slug}', function ($slug) {
    return view('pages.products.show', ['slug' => $slug]);
})->name('products.show');
Route::view('/umkm', 'pages.umkm.index')->name('umkm.index');
Route::get('/umkm/{slug}', function ($slug) {
    return view('pages.umkm.show', ['slug' => $slug]);
})->name('umkm.show');
Route::view('/artikel', 'pages.articles.index')->name('articles.index');
Route::get('/artikel/{slug}', function ($slug) {
    return view('pages.articles.show', ['slug' => $slug]);
})->name('articles.show');
Route::view('/event', 'pages.events.index')->name('events.index');
Route::get('/event/{slug}', function ($slug) {
    return view('pages.events.show', ['slug' => $slug]);
})->name('events.show');
Route::view('/kontak', 'pages.contact')->name('contact');
Route::view('/tentang', 'pages.about')->name('about');
Route::view('/dukung-kami', 'pages.dukung-kami')->name('dukung-kami');

// Authenticated User
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// UMKM Dashboard Routes
Route::middleware(['auth', 'role:umkm'])->prefix('umkm-dashboard')->name('umkm.')->group(function () {
    Route::view('/', 'umkm.dashboard')->name('dashboard');
    Route::view('/profil', 'umkm.profile')->name('profile');
    Route::view('/produk', 'umkm.products')->name('products');
    Route::view('/statistik', 'umkm.statistics')->name('statistics');
});

// Admin Dashboard Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::view('/', 'admin.dashboard')->name('dashboard');
    Route::view('/umkm', 'admin.umkm')->name('umkm');
    Route::view('/produk', 'admin.products')->name('products');
    Route::view('/artikel', 'admin.articles')->name('articles');
    Route::view('/event', 'admin.events')->name('events');
    Route::view('/pesan', 'admin.messages')->name('messages');
});

require __DIR__.'/auth.php';
