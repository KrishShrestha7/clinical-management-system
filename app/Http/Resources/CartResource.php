<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $total = $this->items->sum(function ($item) {
            return (float) $item->medicine->price
                * $item->quantity;
        });

        return [
            'id' => $this->id,

            'items' => CartItemResource::collection(
                $this->items
            ),

            'total' => number_format(
                $total,
                2,
                '.',
                ''
            ),
        ];
    }
}
