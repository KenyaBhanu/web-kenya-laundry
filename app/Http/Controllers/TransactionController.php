<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\TransLaundryPickup;
use App\Models\TransOrder;
use App\Models\TransOrderDetail;
use App\Models\TypeOfService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function create()
    {
        $customers = Customer::orderBy('customer_name')->get();
        $services = TypeOfService::orderBy('service_name')->get();
        $cart = session('order_cart', []);
        $selectedCustomerId = session('order_customer_id');

        return view('transaction', compact('customers', 'services', 'cart', 'selectedCustomerId'));
    }

    public function addItem(Request $request)
    {
        $request->validate([
            'id_customer' => 'required|exists:customers,id',
            'id_service' => 'required|exists:type_of_services,id',
            'qty' => 'required|numeric|min:0.01',
        ]);

        $service = TypeOfService::findOrFail($request->id_service);
        $subtotal = $service->price * $request->qty;

        $cart = session('order_cart', []);
        $cart[] = [
            'id_service' => $service->id,
            'service_name' => $service->service_name,
            'qty' => $request->qty,
            'price' => $service->price,
            'subtotal' => $subtotal,
        ];

        session([
            'order_cart' => $cart,
            'order_customer_id' => $request->id_customer,
        ]);

        return redirect()->route('transaction.create');
    }

    public function removeItem($index)
    {
        $cart = session('order_cart', []);

        if (isset($cart[$index])) {
            unset($cart[$index]);
            $cart = array_values($cart);
        }

        session(['order_cart' => $cart]);

        return redirect()->route('transaction.create');
    }

    public function checkout(Request $request)
    {
        $tax = 0.1;
        $cart = session('order_cart', []);
        $customerId = session('order_customer_id');
        $useTax = $request->boolean('tax');

        if (empty($cart) || !$customerId) {
            return back()->withErrors([
                'checkout' => 'Please select a customer and add at least one item before checking out.',
            ]);
        }

        $total = collect($cart)->sum('subtotal');

        DB::beginTransaction();

        try {
            if ($useTax == true) {
                $total += $total * $tax;
            }
            $order = TransOrder::create([
                'id_customer' => $customerId,
                'order_code' => 'ORD-' . now()->format('YmdHis') . '-' . rand(100, 999),
                'order_date' => now(),
                'order_end_date' => null,
                'order_status' => 0,
                'order_pay' => 0,
                'order_change' => 0,
                'total' => $total,
            ]);

            foreach ($cart as $item) {
                TransOrderDetail::create([
                    'id_order' => $order->id,
                    'id_service' => $item['id_service'],
                    'qty' => $item['qty'],
                    'subtotal' => $item['subtotal'],
                    'notes' => null,
                ]);
            }

            TransLaundryPickup::create([
                'id_order' => $order->id,
                'id_customer' => $customerId,
                'pickup_date' => null,
                'notes' => null,
            ]);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->withErrors(['checkout' => 'Something went wrong while creating the order: ' . $th->getMessage()]);
        }

        session()->forget(['order_cart', 'order_customer_id']);

        return redirect()->route('transaction.create')
            ->with('success', 'Order created successfully. Order code: ' . $order->order_code);
    }
}
