<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Utang;

class UtangController extends Controller
{
    public function index()
    {
        $customers = Customer::with('utangs')->get();
        return view('utang.index', compact('customers'));
    }

    public function history($customerId)
    {
        return response()->json(
            Utang::where('customer_id', $customerId)->get()
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'item_name'   => 'required|string',
            'amount'      => 'required|numeric|min:0',
            'due_date'    => 'nullable|date'
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
}
