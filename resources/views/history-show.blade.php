@extends('layouts.app')
@section('title', 'Order Details')
@section('content')
    <div class="mx-6 flex flex-col gap-4">
        <a href="{{ route('history') }}" class="btn btn-secondary btn-sm w-fit">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
            Back to History
        </a>

        <div class="card bg-base-100 shadow-sm">
            <div class="card-body">
                <h2 class="card-title">Order {{ $order->order_code }}</h2>
                <div class="grid grid-cols-2 gap-2 text-sm">
                    <div><span class="font-medium">Customer:</span> {{ $order->customer->customer_name }}</div>
                    <div><span class="font-medium">Phone:</span> {{ $order->customer->phone }}</div>
                    <div><span class="font-medium">Order Date:</span> {{ $order->order_date->format('j F Y') }}</div>
                    <div><span class="font-medium">Completed:</span>
                        {{ $order->order_end_date ? $order->order_end_date->format('j F Y') : '-' }}
                    </div>
                    <div><span class="font-medium">Picked Up:</span>
                        {{ optional($order->laundryPickup)->pickup_date ? $order->laundryPickup->pickup_date->format('j F Y') : '-' }}
                    </div>
                </div>

                <div class="overflow-x-auto mt-4">
                    <table class="table table-zebra">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Service</th>
                                <th>Qty (kg)</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->orderDetail as $index => $detail)
                                <tr>
                                    <th>{{ $index + 1 }}</th>
                                    <td>{{ $detail->service->service_name }}</td>
                                    <td>{{ $detail->qty }}</td>
                                    <td>{{ number_format($detail->subtotal) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="flex justify-between border-t border-base-300 pt-3 mt-2">
                    <span class="text-base font-medium">Total</span>
                    <span class="text-base font-medium">{{ number_format($order->total) }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection