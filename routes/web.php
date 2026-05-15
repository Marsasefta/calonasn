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





// Route Persiapan (Tidak pakai middleware karena ini pintu masuknya)
Route::get('/ujian/persiapan/{id}', [UjianController::class, 'persiapan'])->name('ujian.persiapan');

// Kelompokkan Route yang diproteksi Middleware Lock & Unlock
Route::middleware(['auth', 'CheckUjianAccess'])->group(function () {
    Route::get('/ujian/mulai/{id}', [UjianController::class, 'mulai'])->name('ujian.mulai');
    Route::post('/ujian/selesai/{id}', [UjianController::class, 'selesai'])->name('ujian.selesai');
});

// Route Hasil & Pembahasan (Pakai ID agar tahu TO mana yang dilihat)
Route::get('/ujian/hasil/{id}', [UjianController::class, 'hasil'])->name('ujian.hasil');
Route::get('/ujian/pembahasan/{id}', [UjianController::class, 'pembahasan'])->name('ujian.pembahasan');

Route::post('/ujian/simpan-jawaban-temp', [UjianController::class, 'simpanJawabanTemp'])->name('ujian.simpan_temp');
Route::post('/ujian/update-timer', [UjianController::class, 'updateTimer'])->name('ujian.update_timer');
Route::post('/ujian/simpan-ragu-temp', [UjianController::class, 'simpanRaguTemp'])->name('ujian.simpan_ragu');

// Sertifikat & Riwayat
Route::get('/ujian/sertifikat/{id}', [UjianController::class, 'sertifikat'])->name('ujian.sertifikat');
Route::get('/riwayat-sertifikat', [UjianController::class, 'riwayatSertifikat'])->name('sertifikat.riwayat');





    // Admin routes with /admin/ prefix and admin middleware
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/create-bank-soal', [BankSoalController::class, 'createBankSoal'])->name('create-bank-soal');
        Route::get('/list-bank-soal', [BankSoalController::class, 'listBankSoal'])->name('list-bank-soal');
        Route::get('/edit-bank-soal/{id}', [BankSoalController::class, 'editBankSoal'])->name('edit-bank-soal');
        Route::put('/update-bank-soal/{id}', [BankSoalController::class, 'updateBankSoal'])->name('update-bank-soal');
        Route::delete('/delete-bank-soal/{id}', [BankSoalController::class, 'destroyBankSoal'])->name('delete-bank-soal');
        Route::get('/import-bank-soal', [BankSoalController::class, 'importForm'])->name('import-bank-soal');
        Route::post('/import-bank-soal-process', [BankSoalController::class, 'importBankSoal'])->name('import-bank-soal-process');
        Route::get('/create-tryout', [CreateTryoutController::class, 'createTryout'])->name('create-tryout');
        Route::post('/store-bank-soal', [BankSoalController::class, 'storeBankSoal'])->name('store-bank-soal');
        Route::post('/store-tryout', [CreateTryoutController::class, 'storeTryout'])->name('store-tryout');
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');

        Route::get('/users', [UserTypeController::class, 'userType'])->name('users.index');
        Route::post('/users', [UserTypeController::class, 'store'])->name('users.store');
        Route::get('/users/{id}', [UserTypeController::class, 'show'])->name('users.show');
        Route::put('/users/{id}', [UserTypeController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [UserTypeController::class, 'destroy'])->name('users.destroy');
        Route::post('/users/{id}/toggle-premium', [UserTypeController::class, 'togglePremium'])->name('users.toggle-premium');
        Route::post('/users/{id}/reset-password', [UserTypeController::class, 'resetPassword'])->name('users.reset-password');

        Route::get('/transactions', [App\Http\Controllers\AdminTransactionController::class, 'index'])->name('transactions.index');
        Route::post('/transactions/{id}/status', [App\Http\Controllers\AdminTransactionController::class, 'updateStatus'])->name('transactions.update-status');

        Route::get('/reports', [App\Http\Controllers\AdminReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/export', [App\Http\Controllers\AdminReportController::class, 'export'])->name('reports.export');

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
