@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4">

    <h1 class="text-2xl font-bold mb-6 text-center">
        Customer Utang List
    </h1>

    <div class="overflow-x-auto">
        <table class="w-full border border-gray-300 rounded-lg overflow-hidden">
            <thead>
                <tr class="bg-gray-200 text-center">
                    <th class="p-3">Customer</th>
                    <th class="p-3">Total Utang</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>

            <tbody class="text-center">
                @foreach ($customers as $customer)
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-3">{{ $customer->name }}</td>

                    <td class="p-3 font-bold text-red-600">
                        ₱{{ number_format($customer->totalUtang(), 2) }}
                    </td>

                    <td class="p-3">
                        <div class="flex justify-center gap-2">
                            <button
                                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1 rounded"
                                onclick="showHistory('{{ $customer->id }}')">
                                View History
                            </button>

                            <button
                                class="bg-green-500 hover:bg-green-600 text-white px-4 py-1 rounded"
                                onclick="openAddUtang('{{ $customer->id }}')">
                                Add Utang
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- UTANG HISTORY MODAL --}}
<div id="historyModal"
     class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">

    <div class="bg-white w-full max-w-2xl rounded-lg shadow-lg p-6">
        <h2 class="text-xl font-bold mb-4 text-center">Utang History</h2>

        <div class="overflow-x-auto">
            <table class="w-full border">
                <thead>
                    <tr class="bg-gray-200 text-center">
                        <th class="p-2">Item</th>
                        <th class="p-2">Amount</th>
                        <th class="p-2">Due Date</th>
                        <th class="p-2">Status</th>
                    </tr>
                </thead>
                <tbody id="historyTable" class="text-center"></tbody>
            </table>
        </div>

        <div class="text-center mt-5">
            <button onclick="closeHistory()"
                    class="bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded">
                Close
            </button>
        </div>
    </div>
</div>

{{-- ADD UTANG MODAL --}}
<div id="addUtangModal"
     class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">

    <div class="bg-white w-full max-w-md rounded-lg shadow-lg p-6">
        <h2 class="text-xl font-bold mb-4 text-center">Add Utang</h2>

        <form method="POST" action="{{ route('utangs.store') }}">
            @csrf
            <input type="hidden" name="customer_id" id="utang_customer_id">

            <label class="block mb-1 font-semibold">Item Name</label>
            <input type="text" name="item_name"
                   class="w-full border rounded p-2 mb-3" required>

            <label class="block mb-1 font-semibold">Amount</label>
            <input type="number" name="amount" step="0.01"
                   class="w-full border rounded p-2 mb-3" required>

            <label class="block mb-1 font-semibold">Due Date</label>
            <input type="date" name="due_date"
                   class="w-full border rounded p-2 mb-4">

            <div class="flex justify-center gap-3">
                <button class="bg-green-500 hover:bg-green-600 text-white px-5 py-2 rounded">
                    Save
                </button>

                <button type="button"
                        onclick="closeAddUtang()"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
function showHistory(customerId) {
    fetch(`/utangs/history/${customerId}`)
        .then(res => res.json())
        .then(data => {
            const tbody = document.getElementById("historyTable");
            tbody.innerHTML = "";

            data.forEach(utang => {
                tbody.innerHTML += `
                    <tr class="border-t">
                        <td class="p-2">${utang.item_name}</td>
                        <td class="p-2">₱${parseFloat(utang.amount).toFixed(2)}</td>
                        <td class="p-2">${utang.due_date}</td>
                        <td class="p-2 font-semibold ${utang.status === 'unpaid' ? 'text-red-600' : 'text-green-600'}">
                            ${utang.status}
                        </td>
                    </tr>
                `;
            });

            document.getElementById("historyModal").classList.remove("hidden");
        });
}

function closeHistory() {
    document.getElementById("historyModal").classList.add("hidden");
}

function openAddUtang(customerId) {
    document.getElementById("utang_customer_id").value = customerId;
    document.getElementById("addUtangModal").classList.remove("hidden");
}

function closeAddUtang() {
    document.getElementById("addUtangModal").classList.add("hidden");
}
</script>
@endsection
