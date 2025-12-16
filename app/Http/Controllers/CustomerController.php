<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // SHOW ALL CUSTOMERS
    public function index()
    {
        // Better: order latest customers first
        $customers = Customer::orderBy('created_at', 'desc')->get();

        return view('customers.index', compact('customers'));
    }

    // STORE NEW CUSTOMER
    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255', // FIXED: add validation
        ]);

        Customer::create([
            'name'    => $request->name,
            'phone'   => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()->back()->with('success', 'Customer added.');
    }

    // UPDATE CUSTOMER
    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255', // FIXED: include address
        ]);

        $customer->update([
            'name'    => $request->name,
            'phone'   => $request->phone,
            'address' => $request->address, // FIXED — now updates properly
        ]);

        return redirect()->back()->with('success', 'Customer updated.');
    }

    // DELETE CUSTOMER
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->back()->with('success', 'Customer deleted.');
    }
}
