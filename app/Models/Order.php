<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'order_number',
        'status',
        'subtotal_amount',
        'vat_rate',
        'vat_amount',
        'total_amount',
    ];

    protected $casts = [
        'subtotal_amount' => 'decimal:2',
        'vat_rate' => 'decimal:2',
        'vat_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    /**
     * Get the patient who owns the order.
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Get the items that belong to the order.
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
