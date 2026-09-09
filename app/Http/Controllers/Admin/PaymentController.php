<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\View\View;

class PaymentController extends Controller
{
    /**
     * Display all payment records.
     */
    public function index(): View
    {
        $payments = Payment::query()
            ->with([
                'order.patient',
            ])
            ->latest()
            ->paginate(10);

        return view(
            'admin.payments.index',
            compact('payments')
        );
    }
}
