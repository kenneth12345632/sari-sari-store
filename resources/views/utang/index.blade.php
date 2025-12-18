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
                        {{-- DROPDOWN ACTION MENU --}}
                        <div class="relative inline-block text-left">
                            <button
                                onclick="toggleMenu({{ $customer->id }})"
                                class="bg-gray-700 hover:bg-gray-800 text-white px-4 py-1 rounded flex items-center gap-1 mx-auto">
                                Actions
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <div id="menu-{{ $customer->id }}"
                                 class="hidden absolute right-0 mt-2 w-48 bg-white border rounded-lg shadow-lg z-50">

                                <button
                                    onclick="openPartialPayment('{{ $customer->id }}')"
                                    class="w-full text-left px-4 py-2 hover:bg-gray-100 text-sm">
                                    💸 Partial Payment
                                </button>

                                <form method="POST"
                                      action="{{ route('utangs.paid', $customer->utangs->first()?->id) }}">
                                    @csrf
                                    <button
                                        type="submit"
                                        class="w-full text-left px-4 py-2 hover:bg-gray-100 text-sm text-green-600">
                                        ✅ Mark as Fully Paid
                                    </button>
                                </form>

                                <button
                                    onclick="showHistory('{{ $customer->id }}')"
                                    class="w-full text-left px-4 py-2 hover:bg-gray-100 text-sm">
                                    📄 View History
                                </button>

                                <button
                                    onclick="openAddUtang('{{ $customer->id }}')"
                                    class="w-full text-left px-4 py-2 hover:bg-gray-100 text-sm">
                                    ➕ Add Utang
                                </button>
                            </div>
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

{{-- PARTIAL PAYMENT MODAL --}}
<div id="partialPaymentModal"
     class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">

    <div class="bg-white w-full max-w-md rounded-lg shadow-lg p-6">
        <h2 class="text-xl font-bold mb-4 text-center">Partial Payment</h2>

        <form method="POST" action="{{ route('utangs.partialPayment') }}">
            @csrf
            <input type="hidden" name="customer_id" id="payment_customer_id">

            <label class="block mb-1 font-semibold">Payment Amount</label>
            <input type="number" name="amount_paid" step="0.01"
                   class="w-full border rounded p-2 mb-4" required>

            <div class="flex justify-center gap-3">
                <button class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2 rounded">
                    Save Payment
                </button>

                <button type="button"
                        onclick="closePartialPayment()"
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
function toggleMenu(customerId) {
    const menu = document.getElementById(`menu-${customerId}`);
    document.querySelectorAll('[id^="menu-"]').forEach(m => {
        if (m !== menu) m.classList.add('hidden');
    });
    menu.classList.toggle('hidden');
}

document.addEventListener('click', function (e) {
    if (!e.target.closest('.relative')) {
        document.querySelectorAll('[id^="menu-"]').forEach(m => {
            m.classList.add('hidden');
        });
    }
});

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
                        <td class="p-2">${utang.due_date ?? ''}</td>
                        <td class="p-2 font-semibold">${utang.status}</td>
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

function openPartialPayment(customerId) {
    document.getElementById("payment_customer_id").value = customerId;
    document.getElementById("partialPaymentModal").classList.remove("hidden");
}

function closePartialPayment() {
    document.getElementById("partialPaymentModal").classList.add("hidden");
}
</script>
@endsection
