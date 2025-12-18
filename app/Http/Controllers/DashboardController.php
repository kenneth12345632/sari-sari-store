<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // -------------------------------
        // BASIC DASHBOARD STATS
        // -------------------------------
        $productCount = Product::count();

        $lowStock = Product::where('stock', '<=', 5)->count();

        $salesToday = Sale::join('products', 'sales.product_id', '=', 'products.id')
            ->whereDate('sales.created_at', Carbon::today())
            ->selectRaw('SUM(sales.quantity * products.price) as total')
            ->value('total') ?? 0;

        // -------------------------------
        // WEEKLY SALES (AUTO YEAR UPDATE)
        // -------------------------------
        // Uses current date automatically (year updates on Jan 1)
        $startOfWeek = Carbon::now()->startOfWeek(Carbon::MONDAY);
        $endOfWeek   = Carbon::now()->endOfWeek(Carbon::SUNDAY);

        $weeklySales = Sale::join('products', 'sales.product_id', '=', 'products.id')
            ->whereBetween('sales.created_at', [$startOfWeek, $endOfWeek])
            ->selectRaw('DATE(sales.created_at) as date,
                         SUM(sales.quantity * products.price) as total')
            ->groupBy('date')
            ->get()
            ->keyBy('date');

        $labels = [];
        $data   = [];

        for ($date = $startOfWeek->copy(); $date <= $endOfWeek; $date->addDay()) {

            // Example output: Thu, Dec 18, 2025
            // Auto-updates when the year changes
            $labels[] = $date->format('D, M d, Y');

            $dateKey = $date->toDateString();

            // Zero-fill days with no sales
            $data[] = $weeklySales[$dateKey]->total ?? 0;
        }

        // -------------------------------
        // PURCHASE SUGGESTIONS
        // -------------------------------
        $suggestions = Product::withSum([
            'sales as recent_sales' => function ($q) {
                $q->where('created_at', '>=', now()->subDays(7));
            }
        ], 'quantity')->get();

        foreach ($suggestions as $p) {
            $p->recommended_order = max(0, ($p->recent_sales ?? 0) - $p->stock);
        }

        return view('dashboard.index', compact(
            'productCount',
            'lowStock',
            'salesToday',
            'suggestions',
            'labels',
            'data'
        ));
    }
}
