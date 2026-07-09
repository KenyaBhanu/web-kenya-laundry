<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\TransOrder;
use App\Models\TransOrderDetail;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $pendingOrders = TransOrder::with('customer')
            ->where('order_status', TransOrder::STATUS_PENDING)
            ->whereNull('order_end_date')
            ->orderBy('order_date')
            ->get();

        $readyOrders = TransOrder::with('customer')
            ->where('order_status', TransOrder::STATUS_PENDING)
            ->whereNotNull('order_end_date')
            ->orderBy('order_date')
            ->get();

        $dailyOrders = TransOrder::whereDate('order_date', '=', now())->count();
        $dailyCustomers = Customer::whereDate('created_at', '=', now())->count();
        $laundries = TransOrder::with('orderDetail')->where('order_status', TransOrder::STATUS_PICKED_UP)->get();
        $dailyLaundry = 0;
        $dailyRevenue = 0;
        foreach ($laundries as $laundry) {
            $dailyLaundry += $laundry->orderDetail->sum('qty');
            $dailyRevenue += $laundry->total;
        }

        return view('dashboard', compact('pendingOrders', 'readyOrders', 'dailyOrders', 'dailyCustomers', 'dailyLaundry', 'dailyRevenue'));
    }

    public function markDone(TransOrder $order)
    {
        $order->update([
            'order_end_date' => now(),
        ]);

        return redirect()->route('dashboard')->with('success', "Order {$order->order_code} marked as ready for pickup.");
    }
}
