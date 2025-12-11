@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<!-- STATS CARDS -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <div class="bg-white p-6 shadow rounded-lg">
        <p class="text-gray-500 text-sm">Total Products</p>
        <h3 class="text-3xl font-bold">{{ $productCount }}</h3>
    </div>

    <div class="bg-white p-6 shadow rounded-lg">
        <p class="text-gray-500 text-sm">Low Stock Items</p>
        <h3 class="text-3xl font-bold">{{ $lowStock }}</h3>
    </div>

    <div class="bg-white p-6 shadow rounded-lg">
        <p class="text-gray-500 text-sm">Sales Today</p>
        <h3 class="text-3xl font-bold">₱{{ number_format($salesToday, 2) }}</h3>
    </div>

</div>

<!-- CHART -->
<div class="bg-white p-6 mt-8 shadow rounded-lg">
    <h2 class="text-lg font-semibold mb-4">Weekly Sales Performance</h2>
    <canvas id="salesChart" height="80"></canvas>
</div>

<!-- PURCHASE SUGGESTIONS -->
<div class="bg-white p-6 mt-8 shadow rounded-lg">
    <h2 class="text-lg font-semibold mb-4">Purchase Suggestions</h2>

    <table class="w-full text-left text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2">Product</th>
                <th class="p-2">Sold (7 days)</th>
                <th class="p-2">Recommendation</th>
            </tr>
        </thead>
        <tbody>
            @foreach($suggestions as $s)
            <tr class="border-b">
                <td class="p-2">{{ $s->name }}</td>
                <td class="p-2">{{ $s->recent_sales }}</td>
                <td class="p-2 font-semibold text-blue-600">
                    {{ $s->recommended_order > 0 ? "Order $s->recommended_order pcs" : "No need" }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
