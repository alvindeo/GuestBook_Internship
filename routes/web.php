<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PengunjungController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('guestbook');
});

Route::get('/guestbook', [PengunjungController::class, 'index'])->name('guestbook');
Route::post('/guestbook', [PengunjungController::class, 'store'])->name('guestbook.store');
Route::post('/guestbook/check-phone', [PengunjungController::class, 'checkPhone'])->name('guestbook.checkPhone');
Route::post('/guestbook/checkout', [PengunjungController::class, 'checkout'])->name('guestbook.checkout');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/reports', [DashboardController::class, 'report'])->name('reports');
    Route::patch('/reports/{id}/status', [DashboardController::class, 'updateStatus'])->name('reports.updateStatus');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
