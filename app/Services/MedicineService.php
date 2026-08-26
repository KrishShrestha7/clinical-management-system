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
}
