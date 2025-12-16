@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6">

    <h1 class="text-2xl font-bold text-center mb-6">
        Products & Sales
    </h1>

    {{-- FORMS SECTION --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

        {{-- Add Product --}}
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="text-lg font-bold mb-4 text-center">Add Product</h3>

            <form action="{{ route('products.store') }}" method="POST">
                @csrf

                <input name="name" placeholder="Product Name"
                       class="w-full p-2 mb-3 border rounded-lg" required>

                <input name="category" placeholder="Category"
                       class="w-full p-2 mb-3 border rounded-lg">

                <input name="price" type="number" step="0.01"
                       placeholder="Price"
                       class="w-full p-2 mb-3 border rounded-lg" required>

                <input name="stock" type="number"
                       placeholder="Stock"
                       class="w-full p-2 mb-4 border rounded-lg" required>

                <button
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg">
                    Add Product
                </button>
            </form>
        </div>

        {{-- Sell Product --}}
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="text-lg font-bold mb-4 text-center">Sell Product</h3>

            <form action="{{ route('sales.store') }}" method="POST">
                @csrf

                <select name="product_id"
                        class="w-full p-2 mb-3 border rounded-lg" required>
                    <option value="">-- Select Product --</option>
                    @foreach($products as $p)
                        <option value="{{ $p->id }}">
                            {{ $p->name }} (Stock: {{ $p->stock }})
                        </option>
                    @endforeach
                </select>

                <input name="quantity" type="number" min="1"
                       placeholder="Quantity"
                       class="w-full p-2 mb-4 border rounded-lg" required>

                <button
                    class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg">
                    Sell Product
                </button>
            </form>
        </div>

    </div>

    {{-- PRODUCTS TABLE --}}
    <div class="bg-white p-6 rounded-xl shadow">
        <h3 class="text-lg font-bold mb-4 text-center">Products List</h3>

        <div class="overflow-x-auto">
            <table class="w-full border border-gray-300 rounded-lg overflow-hidden">
                <thead class="bg-gray-100 text-center">
                    <tr>
                        <th class="p-3">Name</th>
                        <th class="p-3">Stock</th>
                        <th class="p-3">Price</th>
                    </tr>
                </thead>

                <tbody class="text-center">
                    @foreach($products as $p)
                    <tr class="border-t hover:bg-gray-50 transition">
                        <td class="p-3">{{ $p->name }}</td>
                        <td class="p-3">{{ $p->stock }}</td>
                        <td class="p-3 font-semibold">
                            ₱{{ number_format($p->price, 2) }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
