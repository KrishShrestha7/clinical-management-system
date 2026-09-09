<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PaymentStatus;
use App\Enums\PrescriptionStatus;
use App\Http\Controllers\Controller;
use App\Models\Medicine;
use App\Models\Order;
use App\Models\Patient;
use App\Models\Payment;
use App\Models\Prescription;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalPatients = Patient::count();

        $totalMedicines = Medicine::count();

        $lowStockMedicines = Medicine::query()
            ->where('stock_quantity', '>', 0)
            ->where('stock_quantity', '<=', 10)
            ->count();

        $outOfStockMedicines = Medicine::query()
            ->where('stock_quantity', 0)
            ->count();

        $totalOrders = Order::count();

        $pendingOrders = Order::query()
            ->where('status', 'pending')
            ->count();

        $paidOrders = Order::query()
            ->where('status', 'paid')
            ->count();

        $successfulPayments = Payment::query()
            ->where(
                'status',
                PaymentStatus::SUCCESSFUL->value
            )
            ->count();

        $totalRevenue = Payment::query()
            ->where(
                'status',
                PaymentStatus::SUCCESSFUL->value
            )
            ->sum('amount');

        $pendingPrescriptions = Prescription::query()
            ->where(
                'status',
                PrescriptionStatus::PENDING->value
            )
            ->count();

        return view(
            'admin.dashboard',
            compact(
                'totalPatients',
                'totalMedicines',
                'lowStockMedicines',
                'outOfStockMedicines',
                'totalOrders',
                'pendingOrders',
                'paidOrders',
                'successfulPayments',
                'totalRevenue',
                'pendingPrescriptions'
            )
        );
    }
}
