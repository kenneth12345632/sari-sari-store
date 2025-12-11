@extends('layouts.app')

@section('content')
<div class="p-6">

    <h1 class="text-2xl font-bold mb-4">Customers</h1>

    <!-- ⭐ Add Customer Form -->
    <form action="{{ route('customers.store') }}" method="POST" class="flex gap-2 mb-4">
        @csrf

        <input 
            type="text" 
            name="name" 
            placeholder="Name"
            class="border p-2 rounded w-40"
            required
        >

        <input 
            type="text" 
            name="phone" 
            placeholder="Phone"
            class="border p-2 rounded w-40"
        >

        <input 
            type="text" 
            name="address" 
            placeholder="Address"
            class="border p-2 rounded w-64"
        >

        <button 
            type="submit" 
            class="bg-blue-600 text-white px-4 rounded">
            Add
        </button>
    </form>
    <!-- ⭐ End Add Customer Form -->

    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-100">
                <th class="p-2">Name</th>
                <th class="p-2">Phone</th>
                <th class="p-2">Address</th>
                <th class="p-2">Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($customers as $customer)
                <tr class="border-b">
                    <td class="p-2">{{ $customer->name }}</td>
                    <td class="p-2">{{ $customer->phone }}</td>
                    <td class="p-2">{{ $customer->address }}</td>
                    <td class="p-2 flex gap-2">

                        <!-- ⭐ Add Utang Button -->
                        <button 
                            onclick="openUtangModal('{{ $customer->id }}', '{{ $customer->name }}')"
                            class="bg-yellow-500 text-white px-3 py-1 rounded">
                            Add Utang
                        </button>

                        <!-- Delete Button -->
                        <form action="{{ route('customers.destroy', $customer) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-500 text-white px-3 py-1 rounded">
                                Delete
                            </button>
                        </form>

                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>

</div>





{{-- ⭐⭐⭐ UTANG MODAL (add at bottom of page) ⭐⭐⭐ --}}
<div id="utangModal" 
     class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">

    <div class="bg-white p-6 rounded shadow w-80">
        <h3 class="text-lg font-bold mb-3">
            Add Utang for <span id="utangCustomerName"></span>
        </h3>

        <form method="POST" action="{{ route('utangs.store') }}">
            @csrf

            <input type="hidden" name="customer_id" id="utangCustomerId">

            <label class="block mb-1">Amount</label>
            <input type="number" name="amount" class="w-full border p-2 rounded mb-3" required>

            <label class="block mb-1">Due Date</label>
            <input type="date" name="due_date" class="w-full border p-2 rounded mb-3" required>

            <div class="flex gap-2">
                <button class="flex-1 bg-blue-600 text-white p-2 rounded">Save</button>
                <button type="button" onclick="closeUtangModal()" class="flex-1 bg-gray-400 p-2 rounded">Cancel</button>
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
