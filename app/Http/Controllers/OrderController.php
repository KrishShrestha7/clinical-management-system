<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\OrderService;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

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

    /**
     * Display the billing receipt for a paid order.
     */
    public function receipt(
        Order $order
    ): View|RedirectResponse {
        $this->authorize('view', $order);

        $order = $this->orderService
            ->getOrderDetails($order);

        $successfulPayment = $order->payments
            ->firstWhere(
                'status',
                \App\Enums\PaymentStatus::SUCCESSFUL
            );

        if (
            $order->status !== 'paid'
            || !$successfulPayment
        ) {
            return redirect()
                ->route('orders.show', $order)
                ->with(
                    'error',
                    'A receipt is available only after successful payment.'
                );
        }

        return view(
            'orders.receipt',
            compact('order', 'successfulPayment')
        );
    }
}
