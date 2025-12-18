<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UtangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SuggestionController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. REDIRECT /dashboard TO /
// This permanently fixes the 404 error you see in image_cc14f8.png
Route::redirect('/dashboard', '/');

// 2. THE MAIN INVENTORY DASHBOARD
// This ensures image_cc05f1.png is what you see after logging in.
Route::get('/', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

// 3. AUTHENTICATED ROUTES GROUP
// Wrapping these in a group makes the code cleaner and safer.
Route::middleware('auth')->group(function () {
    
    // PRODUCTS
    Route::resource('products', ProductController::class)
        ->except(['show', 'create', 'edit']);

    // SALES
    Route::post('/sales', [SaleController::class, 'store'])->name('sales.store');

    // CUSTOMERS
    Route::resource('customers', CustomerController::class)
        ->only(['index', 'store', 'update', 'destroy']);

    // UTANGS (DEBTS)
    Route::get('/utangs', [UtangController::class, 'index'])->name('utangs.index');
    Route::post('/utangs', [UtangController::class, 'store'])->name('utangs.store');
    Route::post('/utangs/{id}/paid', [UtangController::class, 'paid'])->name('utangs.paid');
    Route::post('/utangs/partial-payment', [UtangController::class, 'partialPayment'])->name('utangs.partialPayment');
    Route::get('/utangs/history/{customerId}', [UtangController::class, 'history'])->name('utangs.history');

    // SUGGESTIONS
    Route::get('/suggestions', [SuggestionController::class, 'index'])->name('suggestions.index');

    // PROFILE
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Add the default Auth routes (Login, Register, Logout)
require __DIR__.'/auth.php';