<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\QuotationItem;
use Illuminate\Support\Carbon;

class QuotationItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = storage_path('app/seeds/quotation-items.csv');
        if (!File::exists($file)) {
            $this->command->error("CSV file not found at $file");
            return;
        }

        $csv = array_map('str_getcsv', file($file));
        $header = array_map('trim', array_shift($csv)); // First row is header


        foreach ($csv as $index => $row) {

            // Skip empty rows
            if (empty(array_filter($row))) {
                continue;
            }

            if (count($row) !== count($header)) {
                $this->command->warn("⚠️ Skipped row $index: Column mismatch. Header has " . count($header) . ", row has " . count($row));
                continue;
            }

            $data = array_combine($header, $row);

            QuotationItem::create([
                'quotation_id' => $data['quotation_id'] ?? null,
                'service_pricing_id' => $data['service_pricing_id'] ?? null,
                'service_name' => $data['service_name'] ?? null,
                'unit_price' => $data['unit_price'] ?? null,
                'quantity' => $data['quantity'] ?? null,
                'subtotal' => $data['subtotal'] ?? null,

            ]);
        }

        $this->command->info("Quotation items data seeded successfully.");
    }
}
