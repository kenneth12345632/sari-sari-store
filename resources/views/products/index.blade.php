@extends('layouts.app')

@section('content')

<div class="flex gap-4 mb-6">

    <!-- Add Product -->
    <div class="w-1/2 bg-white p-5 rounded-xl shadow">
        <h3 class="text-lg font-bold mb-3">Add Product</h3>

        <form action="{{ route('products.store') }}" method="POST">
            @csrf

            <input 
                name="name" 
                placeholder="Product Name" 
                class="w-full p-2 mb-3 border rounded-lg"
                required
            >

            <input 
                name="category" 
                placeholder="Category" 
                class="w-full p-2 mb-3 border rounded-lg"
            >

            <input 
                name="price" 
                type="number" 
                step="0.01" 
                placeholder="Price" 
                class="w-full p-2 mb-3 border rounded-lg"
                required
            >

            <input 
                name="stock" 
                type="number" 
                placeholder="Stock"
                class="w-full p-2 mb-3 border rounded-lg"
                required
            >

            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Add
            </button>
        </form>
    </div>

    <!-- Sell Product -->
    <div class="w-1/2 bg-white p-5 rounded-xl shadow">
        <h3 class="text-lg font-bold mb-3">Sell Product</h3>

        <form action="{{ route('sales.store') }}" method="POST">
            @csrf

            <select 
                name="product_id" 
                class="w-full p-2 mb-3 border rounded-lg"
                required
            >
                <option value="">-- Select Product --</option>
                @foreach($products as $p)
                    <option value="{{ $p->id }}">
                        {{ $p->name }} (Stock: {{ $p->stock }})
                    </option>
                @endforeach
            </select>

            <input 
                name="quantity" 
                type="number" 
                min="1" 
                placeholder="Quantity" 
                class="w-full p-2 mb-3 border rounded-lg"
                required
            >

            <button class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                Sell
            </button>
        </form>
    </div>

</div>

<!-- PRODUCT TABLE -->
<div class="bg-white p-5 rounded-xl shadow">
    <h3 class="text-lg font-bold mb-4">Products List</h3>

    <table class="min-w-full border border-gray-300 rounded-lg overflow-hidden">
        <thead class="bg-gray-100 border-b">
            <tr>
                <th class="px-6 py-3 text-left font-semibold text-gray-700">Name</th>
                <th class="px-6 py-3 text-left font-semibold text-gray-700">Stock</th>
                <th class="px-6 py-3 text-left font-semibold text-gray-700">Price</th>
            </tr>
        </thead>

        <tbody class="bg-white">
            @foreach($products as $p)
            <tr class="border-b hover:bg-gray-50 transition">
                <td class="px-6 py-3">{{ $p->name }}</td>
                <td class="px-6 py-3">{{ $p->stock }}</td>
                <td class="px-6 py-3">₱{{ number_format($p->price, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
