@extends('layouts.app')
@section('title', 'Transaction')
@section('content')

    @if (session('success'))
        <div role="alert" class="alert alert-success mb-4">
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if ($errors->any())
        <div role="alert" class="alert alert-error mb-4">
            <span>{{ $errors->first() }}</span>
        </div>
    @endif

    <div class="flex flex-col items-center">
        <div class="flex gap-4 h-xl">
            <div class="flex flex-col">
                <form action="{{ route('transaction.addItem') }}" method="POST">
                    @csrf
                    <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-xl border p-4 mb-4">
                        <legend class="fieldset-legend text-lg">Choose Customer</legend>
                        <label class="label">
                            Existing Customer
                        </label>
                        <select name="id_customer" class="select w-full" required>
                            <option disabled {{ $selectedCustomerId ? '' : 'selected' }} value="">Pick one</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}"
                                    {{ (int) $selectedCustomerId === $customer->id ? 'selected' : '' }}>
                                    {{ $customer->customer_name }}
                                </option>
                            @endforeach
                        </select>
                        <a href="{{ route('customer.create') }}" class="btn btn-secondary">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                            </svg>

                            Add New Customer
                        </a>
                    </fieldset>
                    <div class="card bg-base-100 w-xl shadow-sm mb-6">
                        <div class="card-body">
                            <div class="flex">
                                <div class="mb-2 w-full">
                                    <label class="label font-medium text-base">
                                        Service
                                    </label><br>
                                    <select name="id_service" id="id_service" class="select w-full" required>
                                        <option disabled selected value="">Pick one</option>
                                        @foreach ($services as $service)
                                            <option value="{{ $service->id }}" data-price="{{ $service->price }}">
                                                {{ $service->service_name }} - {{ number_format($service->price) }} per kg
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <div class="mb-2 w-1/2">
                                    <label class="label font-medium text-base">
                                        Quantity
                                    </label><br>
                                    <label class="input">
                                        <input type="number" step="0.01" min="0.01" name="qty" id="qty"
                                            placeholder="Enter quantity" class="input w-full" required />
                                        <span class="label">kg</span>
                                    </label>
                                </div>
                                <div class="mb-2 w-1/2">
                                    <label class="label font-medium text-base">
                                        Total
                                    </label><br>
                                    <input type="text" id="line_total" placeholder="" class="input w-full" value=""
                                        disabled />
                                </div>
                            </div>
                            <div class="card-actions mt-4">
                                <button type="submit" class="btn btn-secondary">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>
                                    Create Order
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            {{-- only shows once at least one item has been added --}}
            @if (count($cart) > 0)
                <div class="flex my-6">
                    <div class="card bg-base-100 w-96 shadow-sm">
                        <div class="card-body flex flex-col h-64">
                            <h2 class="card-title">Orders</h2>

                            <!-- Content -->
                            <div class="flex-1 justify-between">
                                <div class="overflow-x-auto">
                                    <table class="table">
                                        <!-- head -->
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Service</th>
                                                <th>Qty (kg)</th>
                                                <th>Total</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($cart as $index => $item)
                                                <tr>
                                                    <th>{{ $index + 1 }}</th>
                                                    <td><span class="badge badge-accent">{{ $item['service_name'] }}</span>
                                                    </td>
                                                    <td>{{ $item['qty'] }}</td>
                                                    <td>{{ number_format($item['subtotal']) }}</td>
                                                    <td>
                                                        <form action="{{ route('transaction.removeItem', $index) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn btn-xs btn-soft btn-error">✕</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Bottom -->
                            <div class="flex justify-between border-t border-base-300 pt-3">
                                <span class="text-base font-medium">Total (excluding tax)</span>
                                <span class="text-base font-medium">
                                    {{ number_format(collect($cart)->sum('subtotal')) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <form action="{{ route('transaction.checkout') }}" method="POST" class="w-lg self-center">
            <div class="flex flex-col">
                @csrf
                <div class="flex self-end gap-2 select-none mb-2">
                    <label for="tax">Include Tax</label>
                    <input type="checkbox" checked="" class="checkbox" value="true" id="tax" name="tax" />
                </div>
                <button type="submit" class="btn btn-primary w-full" {{ count($cart) > 0 ? '' : 'disabled' }}>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                    </svg>
                    Checkout
                </button>
            </div>
        </form>
    </div>

    <script>
        // Live preview of the line total before the item is actually added
        const serviceSelect = document.getElementById('id_service');
        const qtyInput = document.getElementById('qty');
        const lineTotal = document.getElementById('line_total');

        function updateLineTotal() {
            const selected = serviceSelect.options[serviceSelect.selectedIndex];
            const price = parseFloat(selected?.dataset?.price ?? 0);
            const qty = parseFloat(qtyInput.value ?? 0);
            lineTotal.value = (!isNaN(price) && !isNaN(qty)) ? (price * qty).toLocaleString() : '';
        }

        serviceSelect.addEventListener('change', updateLineTotal);
        qtyInput.addEventListener('input', updateLineTotal);
    </script>
@endsection
