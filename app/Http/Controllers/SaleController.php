<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Product;

class SaleController extends Controller
{
    public function store(Request $request)
    {
        // Validate input
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        // Fetch product
        $product = Product::findOrFail($data['product_id']);

        // Check stock
        if ($product->stock < $data['quantity']) {
            return back()->withErrors(['Not enough stock available.']);
        }

        // Deduct stock
        $product->stock -= $data['quantity'];
        $product->save();

        // Record the sale
        Sale::create([
            'product_id' => $product->id,
            'quantity'   => $data['quantity'],
            'total'      => $product->price * $data['quantity']
        ]);

        return redirect()->back()->with('success', 'Sale recorded successfully!');
    }
}
