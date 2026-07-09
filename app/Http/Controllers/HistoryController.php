<?php

namespace App\Http\Controllers;

use App\Models\TransOrder;
use App\Models\Customer;

class HistoryController extends Controller
{
    public function index()
    {
        $orders = TransOrder::with('customer')
            ->where('order_status', TransOrder::STATUS_PICKED_UP)
            ->orderByDesc('order_date')
            ->get();

        $totalOrders = TransOrder::count();
        $totalCustomers = Customer::count();
        $laundries = TransOrder::with('orderDetail')->where('order_status', TransOrder::STATUS_PICKED_UP    )->get();
        $totalLaundry = 0;
        $totalRevenue = 0;
        foreach ($laundries as $laundry) {
            $totalLaundry += $laundry->orderDetail->sum('qty');
            $totalRevenue += $laundry->total;
        }

        return view('history', compact('orders', 'totalOrders', 'totalCustomers', 'totalLaundry', 'totalRevenue'));
    }

    public function show(TransOrder $order)
    {
        $order->load(['customer', 'orderDetail.service', 'laundryPickup']);

        return view('history-show', compact('order'));
    }
}
