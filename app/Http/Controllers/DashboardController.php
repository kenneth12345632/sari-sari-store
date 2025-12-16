<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Total products
        $productCount = Product::count();

        // Low stock
        $lowStock = Product::where('stock', '<=', 5)->count();

        // Sales Today = sum(quantity * price)
        $salesToday = Sale::join('products', 'sales.product_id', '=', 'products.id')
            ->whereDate('sales.created_at', Carbon::today())
            ->selectRaw('SUM(sales.quantity * products.price) as total')
            ->value('total') ?? 0;

        // Recent sales (last 7 days) per product
        $suggestions = Product::withSum([
            'sales as recent_sales' => function($q){
                $q->where('created_at', '>=', now()->subDays(7));
            }
        ], 'quantity')->get();

        // Recommended order = max(0, recent_sales - stock)
        foreach ($suggestions as $p) {
            $p->recommended_order = max(0, ($p->recent_sales ?? 0) - $p->stock);
        }

        return view('dashboard.index', compact(
            'productCount',
            'lowStock',
            'salesToday',
            'suggestions'
        ));
    }
}
