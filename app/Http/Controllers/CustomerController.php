<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return view('customers.index', compact('customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'nullable'
        ]);

Customer::create([
    'name' => $request->name,
    'phone' => $request->phone,
    'address' => $request->address,
]);


        return redirect()->back()->with('success', 'Customer added.');
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'nullable'
        ]);

        $customer->update($request->only('name', 'phone'));

        return redirect()->back()->with('success', 'Customer updated.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->back()->with('success', 'Customer deleted.');
    }
}
