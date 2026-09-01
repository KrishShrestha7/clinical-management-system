<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddToCartRequest;
use App\Http\Requests\PatientCartRequest;
use App\Http\Resources\CartResource;
use App\Models\Medicine;
use App\Services\ApiCartService;
use DomainException;
use Illuminate\Http\JsonResponse;
use Throwable;

class CartController extends Controller
{
    protected ApiCartService $cartService;

    public function __construct(
        ApiCartService $cartService
    ) {
        $this->cartService = $cartService;
    }

    /**
     * Display the authenticated patient's cart.
     */
    public function index(
        PatientCartRequest $request
    ): JsonResponse {
        $cart = $this->cartService->getCart(
            $request->user()->patient
        );

        if (!$cart) {
            return response()->json([
                'message' => 'Cart retrieved successfully.',
                'data' => [
                    'items' => [],
                    'total' => '0.00',
                ],
            ]);
        }

        return response()->json([
            'message' => 'Cart retrieved successfully.',
            'data' => new CartResource($cart),
        ]);
    }

    /**
     * Add a medicine to the cart.
     */
    public function store(
        AddToCartRequest $request,
        Medicine $medicine
    ): JsonResponse {
        try {
            $cart = $this->cartService->add(
                $request->user()->patient,
                $medicine,
                (int) $request->validated('quantity')
            );

            return response()->json([
                'message' => 'Medicine added to cart successfully.',
                'data' => new CartResource($cart),
            ]);
        } catch (DomainException $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], 422);
        } catch (Throwable $exception) {
            report($exception);

            return response()->json([
                'message' => 'Medicine could not be added to the cart.',
            ], 500);
        }
    }

    /**
     * Remove a medicine from the cart.
     */
    public function destroy(
        PatientCartRequest $request,
        Medicine $medicine
    ): JsonResponse {
        try {
            $removed = $this->cartService->remove(
                $request->user()->patient,
                $medicine
            );

            if (!$removed) {
                return response()->json([
                    'message' => 'Medicine was not found in the cart.',
                ], 404);
            }

            $cart = $this->cartService->getCart(
                $request->user()->patient
            );

            return response()->json([
                'message' => 'Medicine removed from cart successfully.',
                'data' => new CartResource($cart),
            ]);
        } catch (Throwable $exception) {
            report($exception);

            return response()->json([
                'message' => 'Medicine could not be removed from the cart.',
            ], 500);
        }
    }
}
