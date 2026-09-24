<?php

namespace App\Http\Controllers\Receptionist;

use App\Http\Controllers\Controller;
use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OrderController extends Controller
{
    protected OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Display all patient orders.
     */
    public function index(): View
    {
        $this->authorize('viewAny', Order::class);

        $orders = Order::query()
            ->with([
                'patient',
                'payments',
            ])
            ->withCount('items')
            ->latest()
            ->paginate(15);

        return view(
            'receptionist.orders.index',
            compact('orders')
        );
    }

    /**
     * Display one order.
     */
    public function show(Order $order): View
    {
        $this->authorize('view', $order);

        $order = $this->orderService->getOrderDetails(
            $order
        );

        return view(
            'receptionist.orders.show',
            compact('order')
        );
    }

    /**
     * Display the receipt for a successfully paid order.
     */
    public function receipt(
        Order $order
    ): View|RedirectResponse {
        $this->authorize('view', $order);

        $order = $this->orderService->getOrderDetails(
            $order
        );

        $successfulPayment = $order->payments
            ->firstWhere(
                'status',
                PaymentStatus::SUCCESSFUL
            );

        if (
            $order->status !== 'paid'
            || !$successfulPayment
        ) {
            return redirect()
                ->route(
                    'receptionist.orders.show',
                    $order
                )
                ->with(
                    'error',
                    'A receipt is available only after successful payment.'
                );
        }

        return view(
            'orders.receipt',
            compact(
                'order',
                'successfulPayment'
            )
        );
    }
}
