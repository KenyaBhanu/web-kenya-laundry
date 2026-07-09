@extends('layouts.app')
@section('title', 'Receipt')
@section('content')
    <div class="flex w-full items-center justify-center">
        <div class="flex flex-col my-6 w-lg gap-4">
            <div class="card card-border bg-base-200 w-full mb-4">
                <div class="card-body flex flex-col">
                    <h2 class="card-title text-2xl">Receipt</h2>
                    <p class="text-sm text-base-content/70">{{ $order->order_code }} — {{ $order->customer->customer_name }}</p>

                    <!-- Content -->
                    <div class="flex-1 flex flex-col justify-between">
                        <div class="overflow-x-auto">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Service</th>
                                        <th>Qty (kg)</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->orderDetail as $index => $detail)
                                        <tr>
                                            <th>{{ $index + 1 }}</th>
                                            <td><span class="text-base">{{ $detail->service->service_name }}</span>
                                            </td>
                                            <td>{{ $detail->qty }}</td>
                                            <td class="font-medium">{{ number_format($detail->subtotal) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="flex justify-between mt-4">
                            <div>
                                <p class="text-base">Order date</p>
                                <p class="text-base">Pick up date</p>
                            </div>
                            <div class="text-right">
                                <p class="text-base">{{ $order->order_date->format('j F Y') }}</p>
                                <p class="text-base">
                                    {{ optional($order->laundryPickup)->pickup_date ? $order->laundryPickup->pickup_date->format('j F Y') : now()->format('j F Y') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom -->
                    <div class="border-t border-base-300 pt-3 mt-3 flex flex-col gap-1">
                        <div class="flex justify-between">
                            <span class="text-base font-medium">Total</span>
                            <span class="text-base font-medium">{{ number_format($order->total) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-base">Cash</span>
                            <span class="text-base">{{ number_format($order->order_pay) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-base">Change</span>
                            <span class="text-base">{{ number_format($order->order_change) }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <a href="{{ route('dashboard') }}" class="btn btn-primary self-end">Back to Dashboard</a>
        </div>
    </div>
@endsection