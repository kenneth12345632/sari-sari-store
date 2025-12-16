<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class SuggestionController extends Controller
{
    public function index()
    {
        // Suggestions = TOP SELLING PRODUCTS (last 7 days)
        $suggestions = Sale::with('product')
            ->select('product_id')
            ->selectRaw('SUM(quantity) as sold')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('product_id')
            ->orderByDesc('sold')
            ->take(10)
            ->get();

        return view('suggestions.index', compact('suggestions'));
    }
}
