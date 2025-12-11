<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UtangController;
use App\Http\Controllers\DashboardController;

Route::get('/', [DashboardController::class,'index'])->name('dashboard');

// PRODUCTS
Route::resource('products', ProductController::class)->except(['show','create','edit']);

// SALES
Route::post('sales', [SaleController::class,'store'])->name('sales.store');

// CUSTOMERS
Route::resource('customers', CustomerController::class)
    ->only(['index','store','update','destroy']);

// UTANGS (Plural — STANDARD)
Route::get('/utangs', [UtangController::class, 'index'])->name('utangs.index');
Route::post('/utangs', [UtangController::class, 'store'])->name('utangs.store');
Route::patch('/utangs/{utang}', [UtangController::class, 'update'])->name('utangs.update');

// Additional UTANG Actions
Route::post('/utangs/{utang}/remind', [UtangController::class, 'sendReminder'])->name('utangs.remind');
Route::post('/utangs/{utang}/paid', [UtangController::class, 'markPaid'])->name('utangs.paid');

// UTANG History for Modal
Route::get('/utangs/history/{customer}', [UtangController::class, 'history'])
    ->name('utangs.history');

// Suggestions
Route::get('/suggestions', [App\Http\Controllers\SuggestionController::class, 'index'])
    ->name('suggestions.index');
