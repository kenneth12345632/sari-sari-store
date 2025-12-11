@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6">

    {{-- Page Title --}}
    <h1 class="text-2xl font-bold mb-6">Dashboard</h1>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="p-6 bg-white shadow rounded">
            <h3 class="text-lg font-semibold">Total Products</h3>
            <p class="text-3xl font-bold mt-2">{{ $totalProducts }}</p>
        </div>

        <div class="p-6 bg-white shadow rounded">
            <h3 class="text-lg font-semibold">Low Stock Items</h3>
            <p class="text-3xl font-bold mt-2 text-red-600">{{ $lowStock }}</p>
        </div>

        <div class="p-6 bg-white shadow rounded">
            <h3 class="text-lg font-semibold">Sales Today</h3>
            <p class="text-3xl font-bold mt-2 text-green-600">₱{{ number_format($salesToday, 2) }}</p>
        </div>
    </div>

    {{-- Purchase Suggestions --}}
    <h2 class="text-xl font-bold mb-4">Purchase Suggestions</h2>

    <div class="overflow-x-auto bg-white shadow rounded">
        <table class="w-full table-auto text-left">
            <thead>
                <tr class="bg-gray-100 border-b">
                    <th class="px-4 py-2">Product</th>
                    <th class="px-4 py-2">Stock</th>
                    <th class="px-4 py-2">Sold (7 Days)</th>
                    <th class="px-4 py-2">Recommended Order</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $p)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $p->name }}</td>
                    <td class="px-4 py-2">{{ $p->stock }}</td>
                    <td class="px-4 py-2">{{ $p->recent_sales ?? 0 }}</td>
                    <td class="px-4 py-2 font-semibold 
                        {{ $p->recommended_order > 0 ? 'text-red-600' : 'text-green-600' }}">
                        {{ $p->recommended_order }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection
