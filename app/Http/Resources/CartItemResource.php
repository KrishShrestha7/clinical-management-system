<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $unitPrice = (float) $this->medicine->price;

        $subtotal = round(
            $unitPrice * $this->quantity,
            2
        );

        return [
            'id' => $this->id,

            'medicine' => new MedicineResource(
                $this->medicine
            ),

            'quantity' => $this->quantity,

            'unit_price' => number_format(
                $unitPrice,
                2,
                '.',
                ''
            ),

            'subtotal' => number_format(
                $subtotal,
                2,
                '.',
                ''
            ),
        ];
    }
}
