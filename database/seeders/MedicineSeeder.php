<?php

namespace Database\Seeders;

use App\Models\Medicine;
use Illuminate\Database\Seeder;

class MedicineSeeder extends Seeder
{
    /**
     * Seed the medicines table.
     */
    public function run(): void
    {
        Medicine::create([
            'name' => 'Paracetamol 500mg',
            'generic_name' => 'Paracetamol',
            'description' => 'Used for temporary relief of mild pain and fever.',
            'price' => 20.00,
            'stock_quantity' => 100,
            'requires_prescription' => false,
            'is_active' => true,
        ]);

        Medicine::create([
            'name' => 'Cetirizine 10mg',
            'generic_name' => 'Cetirizine',
            'description' => 'Used for relief of common allergy symptoms.',
            'price' => 35.00,
            'stock_quantity' => 75,
            'requires_prescription' => false,
            'is_active' => true,
        ]);

        Medicine::create([
            'name' => 'Amoxicillin 500mg',
            'generic_name' => 'Amoxicillin',
            'description' => 'Prescription antibiotic medicine.',
            'price' => 120.00,
            'stock_quantity' => 50,
            'requires_prescription' => true,
            'is_active' => true,
        ]);

        Medicine::create([
            'name' => 'Omeprazole 20mg',
            'generic_name' => 'Omeprazole',
            'description' => 'Used for conditions related to excess stomach acid.',
            'price' => 80.00,
            'stock_quantity' => 60,
            'requires_prescription' => false,
            'is_active' => true,
        ]);

        Medicine::create([
            'name' => 'Out of Stock Test Medicine',
            'generic_name' => 'Test Medicine',
            'description' => 'Used to test medicine availability.',
            'price' => 50.00,
            'stock_quantity' => 0,
            'requires_prescription' => false,
            'is_active' => true,
        ]);
    }
}
