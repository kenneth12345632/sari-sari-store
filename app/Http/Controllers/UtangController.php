<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Utang;

class UtangController extends Controller
{
    // Display customer list with utang
    public function index()
    {
        $customers = Customer::with('utangs')->get();
        return view('utang.index', compact('customers'));
    }

    // Return utang history as JSON
    public function history($customerId)
    {
        $utangs = Utang::where('customer_id', $customerId)->get();
        return response()->json($utangs);
    }

    // Store new utang
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'item_name'   => 'required|string',
            'amount'      => 'required|numeric|min:0',
            'due_date'    => 'nullable|date',
        ]);

        Utang::create([
            'customer_id' => $request->customer_id,
            'item_name'   => $request->item_name,
            'amount'      => $request->amount,
            'due_date'    => $request->due_date,
            'status'      => 'unpaid',
        ]);

        return redirect()->route('utangs.index')->with('success', 'Utang added.');
    }

    // Mark utang as fully paid
    public function paid($utangId)
    {
        $utang = Utang::findOrFail($utangId);
        $utang->update(['status' => 'paid']);

        return redirect()->route('utangs.index')->with('success', 'Utang marked as fully paid.');
    }

    // Apply partial payment
    public function partialPayment(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'amount_paid' => 'required|numeric|min:0',
        ]);

        // Find first unpaid utang for customer
        $utang = Utang::where('customer_id', $request->customer_id)
                      ->where('status', 'unpaid')
                      ->first();

        if ($utang) {
            $utang->amount -= $request->amount_paid;

            // If fully paid, mark as paid
            if ($utang->amount <= 0) {
                $utang->status = 'paid';
                $utang->amount = 0;
            }

            $utang->save();
        }

        return redirect()->route('utangs.index')->with('success', 'Partial payment applied.');
    }
}
