<?php

namespace App\Http\Controllers;

use App\Models\TransOrder;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Show the order summary + payment button for a specific order
     * that's ready for pickup.
     */
    public function show(TransOrder $order)
    {
        $order->load(['customer', 'orderDetail.service']);

        return view('payment', compact('order'));
    }

    /**
     * Process the cash payment: validate the cash covers the total,
     * store order_pay/order_change, mark the order done, and stamp
     * the pickup date.
     */
    public function process(Request $request, TransOrder $order)
    {
        $validated = $request->validate([
            'cash' => 'required|numeric',
        ], [
            'cash.required' => 'Cash is required.',
            'cash.numeric' => 'Cash must be a number.',
        ]);

        if ($validated['cash'] < $order->total) {
            return redirect()->back()->withInput()->with('error', 'Cash is less than the total.');
        }

        $change = $validated['cash'] - $order->total;

        $order->update([
            'order_pay' => $validated['cash'],
            'order_change' => $change,
            'order_status' => TransOrder::STATUS_PICKED_UP,
        ]);

        if ($order->laundryPickup) {
            $order->laundryPickup->update([
                'pickup_date' => now(),
            ]);
        }

        return redirect()->route('payment.receipt', $order->id);
    }

    /**
     * Show the receipt for a completed payment.
     */
    public function receipt(TransOrder $order)
    {
        $order->load(['customer', 'orderDetail.service']);

        return view('receipt', compact('order'));
    }
}
