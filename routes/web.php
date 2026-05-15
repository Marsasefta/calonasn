<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BankSoalController;
use App\Http\Controllers\CreateTryoutController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\DemoController;
use App\Http\Controllers\UjianController;
use App\Http\Controllers\UserTypeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Transaksi dan pembayaran
    Route::get('/checkout', [TransactionController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/process', [TransactionController::class, 'process'])->name('checkout.process');
    Route::get('/payment-pending', [TransactionController::class, 'pending'])->name('payment.pending');
    Route::get('/payment-success', [TransactionController::class, 'success'])->name('payment.success');

    // Riwayat transaksi dan invoice
    Route::get('/riwayat', [TransactionController::class, 'history'])->name('riwayat');
    Route::get('/invoice/{order_id}', [TransactionController::class, 'invoice'])->name('invoice');
    Route::delete('/riwayat/{id}', [TransactionController::class, 'destroy'])->name('riwayat.destroy');

    // Halaman ranking
    Route::get('/ranking', [RankingController::class, 'index'])->name('ranking');

    // Demo tryout
    Route::get('/demo', [DemoController::class, 'index'])->name('demo.index');
    Route::get('/demo/ujian', [DemoController::class, 'start'])->name('demo.ujian');
    Route::post('/demo/selesai', [DemoController::class, 'finish'])->name('demo.selesai');

    // Ujian tryout
    Route::get('/ujian', [UjianController::class, 'mulai'])->name('ujian.mulai');
    Route::post('/ujian/selesai', [UjianController::class, 'selesai'])->name('ujian.selesai');    
    Route::get('/ujian/hasil', [UjianController::class, 'hasil'])->name('ujian.hasil');
    Route::get('/ujian/pembahasan', [UjianController::class, 'pembahasan'])->name('ujian.pembahasan');

    // Sertifikat
    Route::get('/ujian/sertifikat', [UjianController::class, 'sertifikat'])->name('ujian.sertifikat');
    Route::get('/riwayat-sertifikat', [UjianController::class, 'riwayatSertifikat'])->name('sertifikat.riwayat');

    // Admin routes with /admin/ prefix and admin middleware
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/create-bank-soal', [BankSoalController::class, 'createBankSoal'])->name('create-bank-soal');
        Route::get('/create-tryout', [CreateTryoutController::class, 'createTryout'])->name('create-tryout');
         Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::post('/store-bank-soal', [BankSoalController::class, 'storeBankSoal'])->name('store-bank-soal');
        Route::post('/store-tryout', [CreateTryoutController::class, 'storeTryout'])->name('store-tryout');
        Route::get('/user_type', [UserTypeController::class, 'userType'])->name('user_type');
        Route::post('/users/{id}/update-role', [UserTypeController::class, 'updateRole'])->name('users.update-role');
        Route::post('/users/{id}/update-status', [UserTypeController::class, 'updateStatus'])->name('users.update-status');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


});

require __DIR__.'/auth.php';
