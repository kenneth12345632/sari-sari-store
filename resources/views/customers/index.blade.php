@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6">

    <h1 class="text-2xl font-bold mb-6 text-center">
        Customers
    </h1>

    {{-- ⭐ Add Customer Form --}}
    <div class="bg-white p-4 rounded-lg shadow mb-6">
        <form action="{{ route('customers.store') }}" method="POST"
              class="grid grid-cols-1 md:grid-cols-4 gap-3">
            @csrf

            <input type="text" name="name" placeholder="Name"
                   class="border p-2 rounded" required>

            <input type="text" name="phone" placeholder="Phone"
                   class="border p-2 rounded">

            <input type="text" name="address" placeholder="Address"
                   class="border p-2 rounded">

            <button class="bg-blue-600 hover:bg-blue-700 text-white rounded px-4">
                Add Customer
            </button>
        </form>
    </div>

    {{-- Customers Table --}}
    <div class="overflow-x-auto">
        <table class="w-full border border-gray-300 rounded-lg overflow-hidden">
            <thead>
                <tr class="bg-gray-100 text-center">
                    <th class="p-3">Name</th>
                    <th class="p-3">Phone</th>
                    <th class="p-3">Address</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>

            <tbody class="text-center">
                @foreach ($customers as $customer)
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-3">{{ $customer->name }}</td>
                    <td class="p-3">{{ $customer->phone }}</td>
                    <td class="p-3">{{ $customer->address }}</td>

                    <td class="p-3">
                        <div class="flex justify-center gap-2">
                            {{-- Add Utang --}}
                            <button
                                onclick="openUtangModal('{{ $customer->id }}', '{{ $customer->name }}')"
                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded">
                                Add Utang
                            </button>

                            {{-- Delete --}}
                            <form action="{{ route('customers.destroy', $customer) }}"
                                  method="POST"
                                  onsubmit="return confirm('Delete this customer?')">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- ================= UTANG MODAL ================= --}}
<div id="utangModal"
     class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">

    <div class="bg-white w-full max-w-md p-6 rounded-lg shadow-lg">
        <h3 class="text-lg font-bold mb-4 text-center">
            Add Utang for <span id="utangCustomerName" class="text-blue-600"></span>
        </h3>

        <form method="POST" action="{{ route('utangs.store') }}">
            @csrf
            <input type="hidden" name="customer_id" id="utangCustomerId">

            <label class="block mb-1 font-semibold">Item Name</label>
            <input type="text" name="item_name"
                   class="w-full border p-2 rounded mb-3" required>

            <label class="block mb-1 font-semibold">Amount</label>
            <input type="number" name="amount" step="0.01"
                   class="w-full border p-2 rounded mb-3" required>

            <label class="block mb-1 font-semibold">Due Date</label>
            <input type="date" name="due_date"
                   class="w-full border p-2 rounded mb-4">

            <div class="flex justify-center gap-3">
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded">
                    Save
                </button>
                <button type="button"
                        onclick="closeUtangModal()"
                        class="bg-gray-400 hover:bg-gray-500 text-white px-5 py-2 rounded">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openUtangModal(id, name) {
    document.getElementById('utangCustomerId').value = id;
    document.getElementById('utangCustomerName').innerText = name;
    document.getElementById('utangModal').classList.remove('hidden');
}

function closeUtangModal() {
    document.getElementById('utangModal').classList.add('hidden');
}
</script>
@endsection
