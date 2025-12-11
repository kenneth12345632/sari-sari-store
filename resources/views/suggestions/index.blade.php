@extends('layouts.app')

@section('title', 'Purchase Suggestions')

@section('content')

<h2 class="text-2xl font-bold mb-4">Purchase Suggestions</h2>

<div class="bg-white p-5 rounded shadow">

    @if($suggestions->isEmpty())
        <p class="text-gray-500">No items need restocking right now.</p>
    @else
        <table class="w-full text-left border">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-3">Product</th>
                    <th class="p-3">Current Stock</th>
                    <th class="p-3">Suggested Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($suggestions as $item)
                    <tr class="border-b">
                        <td class="p-3">{{ $item->name }}</td>
                        <td class="p-3">{{ $item->stock }}</td>
                        <td class="p-3">
                            <span class="text-red-600">Restock Soon</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

</div>

@endsection
