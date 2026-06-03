<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\MekanikController;
use App\Http\Controllers\QueueController; 
use App\Http\Controllers\InvoicePdfController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

    // 1. Halaman awal langsung ke Login
    Route::get('/', function () {
        return view('auth.login');
    });

    // 2. Grup Rute Terproteksi (Hanya bisa diakses setelah Login)
    Route::middleware(['auth', 'verified'])->group(function () {
    
    // DASHBOARD
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // MASTER DATA (Services & Mechanics)
    Route::resource('services', ServiceController::class);
    Route::resource('mechanics', MekanikController::class);

    // OPERASIONAL ANTREAN (Queue Management)
    Route::get('/queues', [QueueController::class, 'index'])->name('queues.index');
    Route::get('/queues/create', [QueueController::class, 'create'])->name('queues.create');
    Route::post('/queues', [QueueController::class, 'store'])->name('queues.store');
    Route::get('/queues/{id}/edit', [QueueController::class, 'edit'])->name('queues.edit');
    Route::put('/queues/{id}', [QueueController::class, 'update'])->name('queues.update');
    Route::delete('/queues/{id}', [QueueController::class, 'destroy'])->name('queues.destroy');

    // API UNTUK ROUND ROBIN (Penting untuk JavaScript di Blade)
    Route::get('/api/get-next-mechanic/{serviceId}', [QueueController::class, 'getNextMechanic']);
    Route::get('/api/preview-mechanic-code/{specialization}', [MekanikController::class, 'previewCode']);
    

    // PROSES PEKERJAAN (Workshop Workflow)
    Route::get('/pengerjaan', [QueueController::class, 'pengerjaan'])->name('queues.pengerjaan');
    Route::patch('/queues/{id}/start', [QueueController::class, 'startWork'])->name('queues.start');
    Route::patch('/queues/{id}/finish', [QueueController::class, 'finishWork'])->name('queues.finish');
    
    // ADMINISTRASI & HISTORY (Bisa tetap di BengkelController jika QueueController belum handle)
    // Jika lu pindahin ke QueueController, ganti BengkelController di bawah ini:
    Route::get('/invoices', [QueueController::class, 'indexInvoice'])->name('invoices.index');
    Route::get('/invoices/{id}/print', [QueueController::class, 'printInvoice'])->name('invoices.print');
    Route::get('/history', [QueueController::class, 'indexHistory'])->name('history.index');

    });

    // 3. Rute Profile (Bawaan Laravel Breeze)
    Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    // 3. Rute print pdf export invoice
    Route::get('/invoices', [QueueController::class, 'indexInvoice'])->name('invoices.index');
    Route::get('/invoices/{id}/print', [InvoicePdfController::class, 'print'])->name('invoices.print');
    Route::get('/invoices/export', [QueueController::class, 'exportExcel'])->name('invoices.export');

require __DIR__.'/auth.php';