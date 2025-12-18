@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="max-w-6xl mx-auto px-4 py-6">

    <!-- STATS CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

        <!-- Total Products -->
        <div class="bg-white p-6 shadow rounded-lg text-center">
            <p class="text-gray-500 text-sm">Total Products</p>
            <h3 class="text-3xl font-bold">{{ $productCount }}</h3>
        </div>

        <!-- Low Stock Items -->
        <div class="bg-white p-6 shadow rounded-lg text-center">
            <p class="text-gray-500 text-sm">Low Stock Items</p>
            <h3 class="text-3xl font-bold text-red-600">{{ $lowStock }}</h3>
        </div>

        <!-- Sales Today -->
        <div class="bg-white p-6 shadow rounded-lg text-center">
            <p class="text-gray-500 text-sm">Sales Today</p>
            <h3 class="text-3xl font-bold text-green-600">
                ₱{{ number_format($salesToday ?? 0, 2) }}
            </h3>
        </div>

    </div>

    <!-- WEEKLY SALES CHART -->
    <div class="bg-white p-6 mt-8 shadow rounded-lg">
        <h2 class="text-lg font-semibold mb-4">Weekly Sales Performance</h2>
        <canvas id="salesChart" height="80"></canvas>
    </div>

    <!-- PURCHASE SUGGESTIONS -->
    <div class="bg-white p-6 mt-8 shadow rounded-lg">
        <h2 class="text-lg font-semibold mb-4">Purchase Suggestions</h2>

        <div class="overflow-x-auto">
            <table class="w-full text-center text-sm border border-gray-200 rounded-lg overflow-hidden">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3">Product</th>
                        <th class="p-3">Sold (7 days)</th>
                        <th class="p-3">Recommendation</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($suggestions as $s)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="p-3">{{ $s->name }}</td>
                            <td class="p-3">{{ $s->recent_sales ?? 0 }}</td>
                            <td class="p-3 font-semibold
                                {{ $s->recommended_order > 0 ? 'text-red-600' : 'text-green-600' }}">
                                {{ $s->recommended_order > 0
                                    ? "Order {$s->recommended_order} pcs"
                                    : "No need" }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="p-4 text-gray-500">
                                No purchase suggestions available
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- CHART.JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const labels = JSON.parse('{!! json_encode($labels ?? []) !!}');
    const data = JSON.parse('{!! json_encode($data ?? []) !!}');

    const ctx = document.getElementById('salesChart');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Weekly Sales (₱)',
                data: data,
                borderWidth: 2,
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

</script>

@endsection
