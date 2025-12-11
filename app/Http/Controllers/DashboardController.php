<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;

class DashboardController extends Controller
{
public function index()
{
    $productCount = Product::count();
    $salesToday = Sale::whereDate('created_at', today())->count();
    $lowStock = Product::where('stock', '<=', 5)->count();

    // 🔥 Add this: suggestions based on last 7 days sales
    $suggestions = Sale::select('product_id')
        ->selectRaw('COUNT(*) as sold')
        ->where('created_at', '>=', now()->subDays(7))
        ->groupBy('product_id')
        ->orderByDesc('sold')
        ->take(5)
        ->get();

    return view('dashboard.index', compact(
        'productCount',
        'salesToday',
        'lowStock',
        'suggestions'   // <- VERY IMPORTANT
    ));
}

}
