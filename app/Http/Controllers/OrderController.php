<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\OrderService;
use Illuminate\View\View;

class OrderController extends Controller
{
    protected OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Display the authenticated patient's orders.
     */
    public function index(): View
    {
        $this->authorize('viewAny', Order::class);

        $patient = auth()->user()->patient;

        $orders = $this->orderService->getPatientOrders(
            $patient
        );

        return view('orders.index', compact('orders'));
    }

    /**
     * Display a specific patient order.
     */
    public function show(Order $order): View
    {
        $this->authorize('view', $order);

        $order = $this->orderService->getOrderDetails(
            $order
        );

        return view('orders.show', compact('order'));
    }
}
