<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddToCartRequest;
use App\Models\Medicine;
use App\Services\CartService;
use App\Http\Requests\CheckoutRequest;
use App\Services\OrderService;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Throwable;

class CartController extends Controller
{
    protected CartService $cartService;

    protected OrderService $orderService;

    public function __construct(
        CartService $cartService,
        OrderService $orderService
    ) {
        $this->cartService = $cartService;
        $this->orderService = $orderService;
    }

    /**
     * Display the patient's medicine cart.
     */
    public function index(): View
    {
        $items = $this->cartService->getItems();
        $total = $this->cartService->getTotal();

        return view('cart.index', compact('items', 'total'));
    }

    /**
     * Add a medicine to the cart.
     */
    public function store(
        AddToCartRequest $request,
        Medicine $medicine
    ): RedirectResponse {
        try {
            $this->cartService->add(
                $medicine,
                $request->validated('quantity')
            );

            return redirect()
                ->route('cart.index')
                ->with('success', 'Medicine added to cart successfully.');
        } catch (DomainException $exception) {
            return back()
                ->with('error', $exception->getMessage());
        } catch (Throwable $exception) {
            report($exception);

            return back()
                ->with(
                    'error',
                    'Medicine could not be added to the cart. Please try again.'
                );
        }
    }

    /**
     * Remove a medicine from the cart.
     */
    public function remove(Medicine $medicine): RedirectResponse
    {
        try {
            $this->cartService->remove($medicine->id);

            return redirect()
                ->route('cart.index')
                ->with('success', 'Medicine removed from cart.');
        } catch (Throwable $exception) {
            report($exception);

            return back()
                ->with(
                    'error',
                    'Medicine could not be removed from the cart.'
                );
        }
    }

    /**
     * Convert the patient's cart into a pending order.
     */
    public function checkout(
        CheckoutRequest $request
    ): RedirectResponse {
        try {
            $cartItems = $this->cartService->getItems();

            $order = $this->orderService->checkout(
                $request->user()->patient,
                $cartItems
            );

            $this->cartService->clear();

            return redirect()
                ->route('cart.index')
                ->with(
                    'success',
                    "Order {$order->order_number} was placed successfully."
                );
        } catch (DomainException $exception) {
            return back()
                ->with('error', $exception->getMessage());
        } catch (Throwable $exception) {
            report($exception);

            return back()
                ->with(
                    'error',
                    'Your order could not be placed. Please try again.'
                );
        }
    }
}
