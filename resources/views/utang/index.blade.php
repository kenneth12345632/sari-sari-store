@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Customer Utang List</h1>

<table class="table-auto w-full border">
    <thead>
        <tr class="bg-gray-200">
            <th class="p-2">Customer</th>
            <th class="p-2">Total Utang</th>
            <th class="p-2">Actions</th>
        </tr>
    </thead>
    <tbody>

        @foreach ($customers as $customer)
        <tr class="border">
            <td class="p-2">{{ $customer->name }}</td>

            <td class="p-2 font-bold">
                ₱{{ number_format($customer->totalUtang(), 2) }}
            </td>

            <td class="p-2 flex gap-2">

                <button
                    class="bg-blue-500 text-white px-3 py-1 rounded"
                    onclick="showHistory('{{ $customer->id }}')"
                >
                    View History
                </button>

                <button
                    class="bg-green-500 text-white px-3 py-1 rounded"
                    onclick="openAddUtang('{{ $customer->id }}')"
                >
                    Add Utang
                </button>

            </td>
        </tr>
        @endforeach

    </tbody>
</table>

{{-- ========================================================= --}}
{{-- UTANG HISTORY MODAL --}}
{{-- ========================================================= --}}
<div id="historyModal"
     class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">

    <div class="bg-white p-5 w-1/3 rounded shadow-lg">
        <h2 class="text-xl font-bold mb-3">Utang History</h2>

        <table class="w-full border" id="historyTable">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-2">Item</th>
                    <th class="p-2">Amount</th>
                    <th class="p-2">Due Date</th>
                    <th class="p-2">Status</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>

        <button onclick="closeHistory()" 
                class="mt-4 bg-red-500 text-white px-3 py-1 rounded">
            Close
        </button>
    </div>
</div>

{{-- ========================================================= --}}
{{-- ADD UTANG MODAL --}}
{{-- ========================================================= --}}
<div id="addUtangModal"
     class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">

    <div class="bg-white p-5 w-1/3 rounded shadow-lg">

        <h2 class="text-xl font-bold mb-3">Add Utang</h2>

        {{-- ✅ FIXED ROUTE NAME HERE --}}
        <form id="utangForm" method="POST" action="{{ route('utangs.store') }}">
            @csrf
            <input type="hidden" name="customer_id" id="utang_customer_id">

            <label class="block mb-2">Item Name</label>
            <input type="text" name="item_name" class="w-full border p-2 mb-3" required>

            <label class="block mb-2">Amount</label>
            <input type="number" name="amount" step="0.01" class="w-full border p-2 mb-3" required>

            <label class="block mb-2">Due Date</label>
            <input type="date" name="due_date" class="w-full border p-2 mb-3">

            <button class="bg-green-500 text-white px-3 py-1 rounded">Save</button>

            <button type="button" onclick="closeAddUtang()"
                class="bg-red-500 text-white px-3 py-1 rounded ml-2">
                Cancel
            </button>
        </form>

    </div>
</div>

@endsection

@section('scripts')
<script>
function showHistory(customerId) {
    // ✅ Ensure route matches GET /utangs/history/{customer}
    fetch(`/utangs/history/${customerId}`)
        .then(response => response.json())
        .then(data => {
            const tbody = document.querySelector("#historyTable tbody");
            tbody.innerHTML = "";

            data.forEach(utang => {
                tbody.innerHTML += `
                    <tr class="border">
                        <td class="p-2">${utang.item_name}</td>
                        <td class="p-2">₱${parseFloat(utang.amount).toFixed(2)}</td>
                        <td class="p-2">${utang.due_date}</td>
                        <td class="p-2 ${utang.status === 'unpaid' ? 'text-red-600 font-bold' : 'text-green-600'}">
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
