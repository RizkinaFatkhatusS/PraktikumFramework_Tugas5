<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'RoleCheck:admin'])->name('dashboard');

// Grup Route untuk Profile (Sudah Bagus)
Route::middleware(['auth', 'verified', 'RoleCheck:admin'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth', 'verified', 'RoleCheck:admin'])->group(function () {
    Route::get('/product', [ProductController::class, 'index'])->name('product-index'); 
    Route::get('/product/create', [ProductController::class, 'create'])->name("product-create");
    Route::post('/product', [ProductController::class, 'store'])->name("product-store");
    Route::get('/product/{id}', [ProductController::class, 'show'])->name('product-show');
    Route::get('/product/{id}/edit', [ProductController::class, 'edit'])->name('product-edit');
    Route::put('/product/{id}', [ProductController::class, 'update'])->name('product-update');
    Route::delete('/product/{id}', [ProductController::class, 'destroy'])->name('product-delete'); 
});


require __DIR__.'/auth.php';