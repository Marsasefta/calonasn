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
use App\Http\Controllers\BlogController;
use App\Http\Controllers\PromoCodeController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\MateriController;

use App\Models\Post;
use App\Models\LearningCategory;

use App\Http\Controllers\UserTypeController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    // 1. Ambil artikel (untuk blog)
    $latestPosts = Post::with('category')
                        ->where('status', 'published')
                        ->latest()
                        ->take(3)
                        ->get();

    // 2. Ambil kategori untuk etalase pembelajaran
    $categories = LearningCategory::withCount('materials')->get();

    // 3. Kirim keduanya ke welcome.blade.php
    return view('welcome', compact('latestPosts', 'categories'));
});

// Di area publik (luar middleware admin)
Route::get('/blog', [App\Http\Controllers\BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [App\Http\Controllers\BlogController::class, 'show'])->name('blog.show');

Route::view('/demo-cat', 'demo')->name('demo.cat');

// --- TAMBAHAN ROUTE GOOGLE AUTHENTICATION ---
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');    

    // Transaksi dan pembayaran
    Route::get('/checkout', [TransactionController::class, 'checkout'])->name('checkout');
    Route::post('/transaction/check-promo', [App\Http\Controllers\TransactionController::class, 'checkPromo'])->name('transaction.checkPromo');
    Route::post('/checkout/process', [TransactionController::class, 'process'])->name('checkout.process');
    // --- TAMBAHKAN DUA BARIS BARU INI ---
    Route::get('/payment/qris/{invoice_number}', [TransactionController::class, 'qris'])->name('payment.qris');
    Route::post('/payment/upload/{invoice_number}', [TransactionController::class, 'uploadProof'])->name('payment.upload');
    // -------------------------------------
    Route::get('/payment-pending', [TransactionController::class, 'pending'])->name('payment.pending');
    Route::get('/payment/check-status', [TransactionController::class, 'checkStatus'])->name('payment.check.status');
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

   
    // ==========================================
    // ROUTE MATERI BELAJAR
    // ==========================================

    // Halaman Lobby Kategori
    Route::get('/materi-belajar', [MateriController::class, 'index'])->name('materi.index');
    Route::get('/materi-belajar/{categorySlug}/{materialSlug?}', [MateriController::class, 'show'])
        ->name('materi.show'); // Ini untuk akses awal (Lobby)

    Route::get('/materi-belajar/{categorySlug}/{materialSlug}', [MateriController::class, 'show'])
        ->name('materi.detail'); // Ini alias tambahan supaya error-nya hilang


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
        Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');

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


        Route::get('/blog-categories', [App\Http\Controllers\BlogCategoryController::class, 'index'])->name('blog-categories.index');
        Route::post('/blog-categories', [App\Http\Controllers\BlogCategoryController::class, 'store'])->name('blog-categories.store');
        Route::put('/blog-categories/{id}', [App\Http\Controllers\BlogCategoryController::class, 'update'])->name('blog-categories.update');
        Route::delete('/blog-categories/{id}', [App\Http\Controllers\BlogCategoryController::class, 'destroy'])->name('blog-categories.destroy');

        
        // 1. Tampilan utama: Daftar semua artikel blog
        Route::get('/blog', [App\Http\Controllers\BlogController::class, 'adminIndex'])->name('blog.index');

        // 2. Create: Tampilan form menulis artikel baru
        Route::get('/blog/create', [App\Http\Controllers\BlogController::class, 'create'])->name('blog.create');

        // 3. Store: Proses menyimpan artikel baru ke database
        Route::post('/blog', [App\Http\Controllers\BlogController::class, 'store'])->name('blog.store');

        // 4. Edit: Tampilan form untuk mengubah isi artikel yang sudah ada
        Route::get('/blog/{id}/edit', [App\Http\Controllers\BlogController::class, 'edit'])->name('blog.edit');

        // 5. Update: Proses menyimpan perubahan artikel ke database
        Route::put('/blog/{id}', [App\Http\Controllers\BlogController::class, 'update'])->name('blog.update');

        // 6. Destroy: Proses menghapus artikel (akan masuk Trash karena pakai SoftDeletes)
        Route::delete('/blog/{id}', [App\Http\Controllers\BlogController::class, 'destroy'])->name('blog.destroy');   

        // Tambahkan ini di dalam grup Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () { ... })

        Route::get('/blog/{id}', [App\Http\Controllers\BlogController::class, 'showAdmin'])->name('blog.show');
        
        // Admin: Learning / Materi Pembelajaran (Lobby, bab, materi)
        Route::get('/learning', [App\Http\Controllers\Admin\LearningController::class, 'index'])->name('learning.index');
        Route::get('/learning/create', [App\Http\Controllers\Admin\LearningController::class, 'createCategory'])->name('learning.create');
        Route::post('/learning/store', [App\Http\Controllers\Admin\LearningController::class, 'storeCategory'])->name('learning.store');
        Route::get('/learning/{slug}', [App\Http\Controllers\Admin\LearningController::class, 'showCategory'])->name('learning.category.show');
        Route::get('/learning/{slug}/edit', [App\Http\Controllers\Admin\LearningController::class, 'editCategory'])->name('learning.category.edit');
        Route::put('/learning/{slug}/update', [App\Http\Controllers\Admin\LearningController::class, 'updateCategory'])->name('learning.category.update');
        Route::delete('/learning/{slug}/delete', [App\Http\Controllers\Admin\LearningController::class, 'destroyCategory'])->name('learning.category.destroy');
        Route::get('/learning/{slug}/create-chapter', [App\Http\Controllers\Admin\LearningController::class, 'createChapter'])->name('learning.chapter.create');
        Route::post('/learning/{slug}/store-chapter', [App\Http\Controllers\Admin\LearningController::class, 'storeChapter'])->name('learning.chapter.store');
        Route::get('/learning/{slug}/chapters/{chapter}/edit', [App\Http\Controllers\Admin\LearningController::class, 'editChapter'])->name('learning.chapter.edit');
        Route::put('/learning/{slug}/chapters/{chapter}/update', [App\Http\Controllers\Admin\LearningController::class, 'updateChapter'])->name('learning.chapter.update');
        Route::delete('/learning/{slug}/chapters/{chapter}/delete', [App\Http\Controllers\Admin\LearningController::class, 'destroyChapter'])->name('learning.chapter.destroy');
        Route::get('/learning/{slug}/chapters/{chapter}/create-material', [App\Http\Controllers\Admin\LearningController::class, 'createMaterial'])->name('learning.material.create');
        Route::post('/learning/{slug}/chapters/{chapter}/store-material', [App\Http\Controllers\Admin\LearningController::class, 'storeMaterial'])->name('learning.material.store');
        Route::get('/learning/{slug}/chapters/{chapter}/materials/{material}/edit', [App\Http\Controllers\Admin\LearningController::class, 'editMaterial'])->name('learning.material.edit');
        Route::put('/learning/{slug}/chapters/{chapter}/materials/{material}/update', [App\Http\Controllers\Admin\LearningController::class, 'updateMaterial'])->name('learning.material.update');
        Route::delete('/learning/{slug}/chapters/{chapter}/materials/{material}/delete', [App\Http\Controllers\Admin\LearningController::class, 'destroyMaterial'])->name('learning.material.destroy');
    

        Route::get('promo-codes', [PromoCodeController::class, 'index'])->name('promo.index');
        Route::post('promo-codes', [PromoCodeController::class, 'store'])->name('promo.store');
        Route::put('promo-codes/{id}', [PromoCodeController::class, 'update'])->name('promo.update');
        Route::delete('promo-codes/{id}', [PromoCodeController::class, 'destroy'])->name('promo.destroy');   
       
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


});

require __DIR__.'/auth.php';
