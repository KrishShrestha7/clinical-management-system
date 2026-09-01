<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MedicineResource;
use App\Models\Medicine;
use App\Services\MedicineService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MedicineController extends Controller
{
    protected MedicineService $medicineService;

    public function __construct(
        MedicineService $medicineService
    ) {
        $this->medicineService = $medicineService;
    }

    /**
     * Display available medicines.
     */
    public function index(): AnonymousResourceCollection
    {
        $medicines = $this->medicineService
            ->getAvailablePaginated();

        return MedicineResource::collection($medicines);
    }

    /**
     * Display a specific available medicine.
     */
    public function show(
        Medicine $medicine
    ): MedicineResource|JsonResponse {
        $medicine = $this->medicineService
            ->getAvailableMedicine($medicine);

        if (!$medicine) {
            return response()->json([
                'message' => 'Medicine is not available.',
            ], 404);
        }

        return new MedicineResource($medicine);
    }
}
