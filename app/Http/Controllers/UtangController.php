<?php

namespace App\Http\Controllers;

use App\Models\Utang;
use App\Models\Customer;
use Illuminate\Http\Request;

class UtangController extends Controller
{
    // LIST ALL CUSTOMERS WITH UTANG SUMMARY
    public function index()
    {
        $customers = Customer::with('utangs')->get();
        return view('utang.index', compact('customers'));
    }

    // STORE NEW UTANG
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'item_name' => 'required',
            'amount' => 'required|numeric',
            'due_date' => 'required|date'
        ]);

        Utang::create([
            'customer_id' => $request->customer_id,
            'item_name' => $request->item_name,
            'amount' => $request->amount,
            'due_date' => $request->due_date,
            'status' => 'unpaid',
        ]);

        return back()->with('success', 'Utang recorded successfully.');
    }

    // UPDATE STATUS (PAID / UNPAID)
    public function update(Request $request, Utang $utang)
    {
        $request->validate([
            'status' => 'required|in:unpaid,paid',
        ]);

        $utang->update(['status' => $request->status]);

        return back()->with('success', 'Utang updated successfully!');
    }

    // FETCH UTANG HISTORY FOR CUSTOMER
    public function history(Customer $customer)
    {
        $utangs = $customer->utangs()
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($utangs);
    }
}
