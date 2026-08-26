<?php

namespace App\Http\Controllers;

use App\Services\MedicineService;
use Illuminate\View\View;

class MedicineCatalogController extends Controller
{
    protected MedicineService $medicineService;

    public function __construct(MedicineService $medicineService)
    {
        $this->medicineService = $medicineService;
    }

    /**
     * Display medicines available for patient ordering.
     */
    public function index(): View
    {
        $medicines = $this->medicineService->getAvailablePaginated();

        return view('medicines.catalog', compact('medicines'));
    }
}
