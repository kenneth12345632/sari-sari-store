<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UtangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SuggestionController;

// DASHBOARD
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

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
Route::patch('/utangs/{utang}', [UtangController::class, 'update'])->name('utangs.update');

// Extra UTANG Actions
Route::post('/utangs/{utang}/remind', [UtangController::class, 'sendReminder'])->name('utangs.remind');
Route::post('/utangs/{utang}/paid', [UtangController::class, 'markPaid'])->name('utangs.paid');

// UTANG History
Route::get('/utangs/history/{customer}', [UtangController::class, 'history'])
    ->name('utangs.history');

// SUGGESTIONS
Route::get('/suggestions', [SuggestionController::class, 'index'])
    ->name('suggestions.index');
