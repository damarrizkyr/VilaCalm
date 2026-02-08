<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VilaController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', function () {
    return view('landing');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/home', [VilaController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('vilas', VilaController::class);

    Route::delete('/vila-images/{id}', [VilaController::class, 'destroyImage'])->name('vila-images.destroy');

    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    // 1. Menampilkan Form Booking
    Route::get('/vilas/{vila}/booking', [BookingController::class, 'create'])->name('vilas.booking');

    // 2. Memproses Booking (Simpan ke DB)
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');

    // 3. Menampilkan Halaman Pembayaran (Setelah data disimpan)
    Route::get('/bookings/{booking}/payment', [BookingController::class, 'payment'])->name('bookings.payment');

    Route::post('/bookings/{booking}/pay', [BookingController::class, 'confirmPayment'])->name('bookings.pay');

    Route::get('/bookings/{booking}/receipt', [BookingController::class, 'receipt'])->name('bookings.receipt');

    // Halaman Data Vila (List Vila milik Admin)
    Route::get('/admin/vilas', [VilaController::class, 'adminIndex'])->name('admin.vilas');

    // Halaman Detail Pembooking & Keuangan per Vila
    Route::get('/admin/vilas/{vila}/bookings', [VilaController::class, 'adminShow'])->name('admin.vilas.show');

    Route::get('/riwayat', [BookingController::class, 'history'])->name('bookings.history');

    // Route Update Booking (Admin)
    Route::put('/admin/bookings/{booking}', [BookingController::class, 'adminUpdate'])->name('admin.bookings.update');

    // Route Cancel Booking (Admin)
    Route::patch('/admin/bookings/{booking}/cancel', [BookingController::class, 'adminCancel'])->name('admin.bookings.cancel');

    // Route Delete Booking (Admin)
    Route::delete('/admin/bookings/{booking}', [BookingController::class, 'adminDestroy'])->name('admin.bookings.destroy');
});

require __DIR__ . '/auth.php';
