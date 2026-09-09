<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Display all patient orders.
     */
    public function index(): View
    {
        $orders = Order::query()
            ->with([
                'patient',
                'payments',
            ])
            ->withCount('items')
            ->latest()
            ->paginate(10);

        return view(
            'admin.orders.index',
            compact('orders')
        );
    }

    /**
     * Display one order with full details.
     */
    public function show(Order $order): View
    {
        $order->load([
            'patient',
            'items.medicine',
            'payments',
        ]);

        return view(
            'admin.orders.show',
            compact('order')
        );
    }
}
