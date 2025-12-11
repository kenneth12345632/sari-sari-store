<?php

namespace App\Http\Controllers;

use App\Models\Product;

class SuggestionController extends Controller
{
    public function index()
    {
        // Example logic: Suggest items with low stock
        $suggestions = Product::where('stock', '<=', 5)->get();

        return view('suggestions.index', compact('suggestions'));
    }
}
