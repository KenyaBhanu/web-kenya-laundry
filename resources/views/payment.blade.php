@extends('layouts.app')
@section('title', 'Payment')
@section('content')

    @if ($errors->any())
        <div role="alert" class="alert alert-error mb-4">
            <span>{{ $errors->first() }}</span>
        </div>
    @endif

    <div class="flex w-full items-center justify-center">
        <div class="flex flex-col my-6 w-lg gap-4">
            <div class="card card-border bg-base-200 w-full mb-4">
                <div class="card-body flex flex-col">
                    <h2 class="card-title text-2xl">Order Summary</h2>
                    <p class="text-sm text-base-content/70">{{ $order->order_code }} — {{ $order->customer->customer_name }}
                    </p>

                    <!-- Content -->
                    <div class="flex-1 flex flex-col justify-between">
                        <div class="overflow-x-auto">
                            <table class="table">
                                <!-- head -->
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
                                <p class="text-base">{{ $order->order_end_date->format('j F Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom -->
                    <div class="flex justify-between border-t border-base-300 pt-3 mt-3">
                        <span class="text-base font-medium">Total</span>
                        <span class="text-base font-medium">
                            {{ number_format($order->total) }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="text-2xl font-semibold self-end">
                <button class="btn btn-primary" onclick="payment_modal.showModal()">
                    Process payment
                </button>
            </div>

            <dialog id="payment_modal" class="modal">
                <div class="modal-box">
                    <h3 class="text-lg font-bold">Payment</h3>
                    <form action="{{ route('payment.process', $order->id) }}" method="POST">
                        @csrf
                        <div class="flex justify-between items-center mt-4">
                            <label for="total_display">Total</label>
                            <input type="text" id="total_display" value="{{ number_format($order->total) }}"
                                class="input w-7/8" disabled />
                        </div>
                        <div class="flex flex-col gap-2 mt-4">
                            <div class="flex justify-between items-center">
                                <label for="cash">Cash</label>
                                <input type="number" step="1" name="cash"
                                    id="cash" value="{{ old('cash') }}" placeholder="Enter the amount of cash"
                                    class="input w-7/8" required />
                            </div>
                            @error('cash')
                                <p class="text-sm text-error">{{ $message }}</p>
                            @enderror
                            @if (session('error'))
                                <p class="text-sm text-error">{{ session('error') }}</p>
                            @endif
                        </div>
                        <div class="modal-action">
                            <button type="button" class="btn" onclick="payment_modal.close()">Cancel</button>
                            <button type="submit" class="btn btn-primary">Pay</button>
                        </div>
                    </form>
                </div>
            </dialog>

            @if ($errors->has('cash') || session('error'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const paymentModal = document.getElementById('payment_modal');
                        if (paymentModal && typeof paymentModal.showModal === 'function') {
                            paymentModal.showModal();
                        }
                    });
                </script>
            @endif
        </div>
    </div>
@endsection
