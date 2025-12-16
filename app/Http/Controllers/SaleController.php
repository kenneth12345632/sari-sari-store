<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function store(Request $request)
    {
        // Validate input
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        // Wrap everything in a DB transaction (IMPORTANT)
        DB::beginTransaction();

        try {
            // Fetch the product
            $product = Product::lockForUpdate()->findOrFail($data['product_id']);

            // Check stock level
            if ($product->stock < $data['quantity']) {
                return back()->withErrors(['Not enough stock available.']);
            }

            // Validate price (extra safety)
            if ($product->price === null || $product->price < 0) {
                return back()->withErrors(['Invalid product price.']);
            }

            // Deduct stock
            $product->stock -= $data['quantity'];
            $product->save();

            // Record the sale
            Sale::create([
                'product_id' => $product->id,
                'quantity'   => $data['quantity'],
                'total'      => $product->price * $data['quantity'],
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Sale recorded successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            // For debugging (disable in production)
            return back()->withErrors(['Error recording sale: ' . $e->getMessage()]);
        }
    }
}
