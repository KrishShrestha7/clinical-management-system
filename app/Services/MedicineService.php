<?php

namespace App\Services;

use App\Models\Medicine;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class MedicineService
{
    /**
     * Get medicines that are available for patient ordering.
     */
    public function getAvailablePaginated(
        int $perPage = 12
    ): LengthAwarePaginator {
        return Medicine::query()
            ->where('is_active', true)
            ->where('stock_quantity', '>', 0)
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Get an available medicine by ID.
     */
    public function getAvailableMedicine(
        Medicine $medicine
    ): ?Medicine {
        if (!$medicine->isAvailable()) {
            return null;
        }

        return $medicine;
    }
}
