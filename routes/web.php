<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\OwnerDashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', function () {
    $featuredProperties = \App\Models\Property::orderBy('stars', 'desc')->take(3)->get();
    $cheapProperties = \App\Models\Property::where('type', 'rumah')->orderBy('price', 'asc')->take(8)->get();
    $bestViewVillas = \App\Models\Property::where('type', 'villa')->orderBy('stars', 'desc')->take(8)->get();
    return view('welcome', compact('featuredProperties', 'cheapProperties', 'bestViewVillas'));
});

Route::get('/properti', [PropertyController::class, 'index'])->name('properties.index');
Route::get('/properti/{property}', [PropertyController::class, 'showPublic'])->name('properties.show_public');
Route::get('/properti/{property}/checkout', [PropertyController::class, 'checkoutPublic'])
    ->name('properties.checkout_public')
    ->middleware('auth');
Route::get('/promo', function() { return view('promo'); })->name('promo.public');
Route::get('/blog', [PropertyController::class, 'blogIndexPublic'])->name('blog.public');
Route::get('/blog/saya', [PropertyController::class, 'blogMyPostsPublic'])->name('blog.my_posts_public')->middleware('auth');
Route::get('/blog/tulis', [PropertyController::class, 'blogCreatePublic'])->name('blog.create_public')->middleware('auth');
Route::post('/blog/simpan', [PropertyController::class, 'blogStorePublic'])->name('blog.store_public')->middleware('auth');
Route::get('/blog/{slug}/edit', [PropertyController::class, 'blogEditPublic'])->name('blog.edit_public')->middleware('auth');
Route::put('/blog/{slug}/update', [PropertyController::class, 'blogUpdatePublic'])->name('blog.update_public')->middleware('auth');
Route::delete('/blog/{slug}/hapus', [PropertyController::class, 'blogDestroyPublic'])->name('blog.destroy_public')->middleware('auth');
Route::get('/tentang-kami', function() {
    $galleryProperties = \App\Models\Property::take(6)->get();
    return view('about', compact('galleryProperties'));
})->name('about');

// Owner Dashboard routes group
Route::prefix('owner')->name('owner.')->middleware(['auth', 'owner'])->group(function () {
    Route::get('/dashboard', [OwnerDashboardController::class, 'index'])->name('dashboard');
    
    // Properti CRUD
    Route::get('/properti', [OwnerDashboardController::class, 'propertyIndex'])->name('properties.index');
    Route::get('/properti/tambah', [OwnerDashboardController::class, 'propertyCreate'])->name('properties.create');
    Route::post('/properti/simpan', [OwnerDashboardController::class, 'propertyStore'])->name('properties.store');
    Route::get('/properti/{property}', [OwnerDashboardController::class, 'propertyShow'])->name('properties.show');
    Route::get('/properti/{property}/edit', [OwnerDashboardController::class, 'propertyEdit'])->name('properties.edit');
    Route::put('/properti/{property}/update', [OwnerDashboardController::class, 'propertyUpdate'])->name('properties.update');
    Route::delete('/properti/{property}/hapus', [OwnerDashboardController::class, 'propertyDestroy'])->name('properties.destroy');

    // Blog CRUD
    Route::get('/blog', [OwnerDashboardController::class, 'blogIndex'])->name('blog.index');
    Route::get('/blog/buat', [OwnerDashboardController::class, 'blogCreate'])->name('blog.create');
    Route::post('/blog/simpan', [OwnerDashboardController::class, 'blogStore'])->name('blog.store');
    Route::get('/blog/{slug}', [OwnerDashboardController::class, 'blogShow'])->name('blog.show');
    Route::get('/blog/{slug}/edit', [OwnerDashboardController::class, 'blogEdit'])->name('blog.edit');
    Route::put('/blog/{slug}/update', [OwnerDashboardController::class, 'blogUpdate'])->name('blog.update');
    Route::delete('/blog/{slug}/hapus', [OwnerDashboardController::class, 'blogDestroy'])->name('blog.destroy');

    // Kelola Pemesanan
    Route::get('/pemesanan', [OwnerDashboardController::class, 'bookingIndex'])->name('bookings.index');

    // Keuangan / Pendapatan & Ekspor Laporan
    Route::get('/keuangan', [OwnerDashboardController::class, 'keuanganIndex'])->name('keuangan.index');
    Route::get('/keuangan/ekspor', [OwnerDashboardController::class, 'laporanExport'])->name('keuangan.export');

    // Manajemen Promo
    Route::get('/promo', [OwnerDashboardController::class, 'promoIndex'])->name('promo.index');

    // Profil Pemilik
    Route::get('/profil', [OwnerDashboardController::class, 'profilIndex'])->name('profil.index');

    // Ulasan & Rating Penyewa
    Route::get('/ulasan', [OwnerDashboardController::class, 'ulasanIndex'])->name('ulasan.index');

    // Pusat Bantuan & FAQ
    Route::get('/bantuan', [OwnerDashboardController::class, 'bantuanIndex'])->name('bantuan.index');
});

// Tenant User & Booking Routes
Route::middleware('auth')->group(function () {
    Route::post('/properti/{id}/checkout', [BookingController::class, 'store'])->name('user.bookings.store');
    Route::get('/pesanan', [BookingController::class, 'index'])->name('user.bookings.index');
    Route::get('/profil', [BookingController::class, 'showProfile'])->name('user.profile.show');
    Route::post('/profil', [BookingController::class, 'updateProfile'])->name('user.profile.update');
    Route::get('/bantuan', [BookingController::class, 'showHelp'])->name('user.help');
    Route::post('/pesanan/{booking}/ulasan', [BookingController::class, 'storeReview'])->name('user.bookings.review');
    Route::put('/ulasan/{review}', [BookingController::class, 'updateReview'])->name('user.reviews.update');
    Route::delete('/ulasan/{review}', [BookingController::class, 'destroyReview'])->name('user.reviews.destroy');
    
    // Owner approval actions (accessible to owner via POST)
    Route::post('/owner/pemesanan/{booking}/terima', [BookingController::class, 'approve'])->name('owner.bookings.approve');
    Route::post('/owner/pemesanan/{booking}/tolak', [BookingController::class, 'reject'])->name('owner.bookings.reject');
});
