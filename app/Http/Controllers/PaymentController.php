<?php

namespace App\Http\Controllers;

use App\Http\Requests\InitiatePaymentRequest;
use App\Models\Order;
use App\Services\PaymentService;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Throwable;

class PaymentController extends Controller
{
    protected PaymentService $paymentService;

    public function __construct(
        PaymentService $paymentService
    ) {
        $this->paymentService = $paymentService;
    }

    /**
     * Display the payment page for an order.
     */
    public function create(Order $order): View
    {
        $this->authorize('pay', $order);

        return view('payments.create', compact('order'));
    }

    /**
     * Start a payment attempt.
     */
    public function store(
        InitiatePaymentRequest $request,
        Order $order
    ): RedirectResponse {
        $this->authorize('pay', $order);

        try {
                $payment = $this->paymentService
                    ->processSimplePayment(
                        $request->user()->patient,
                        $order
                    );

                return redirect()
                    ->route('orders.show', $order)
                    ->with(
                        'success',
                        "Payment {$payment->transaction_reference} completed successfully."
                    );
        } catch (DomainException $exception) {
            return back()
                ->with('error', $exception->getMessage());
        } catch (Throwable $exception) {
            report($exception);

            return back()
                ->with(
                    'error',
                    'Payment could not be initiated. Please try again.'
                );
        }
    }
}
