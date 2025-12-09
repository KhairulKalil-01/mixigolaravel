<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Quotation;
use Illuminate\Support\Carbon;

class QuotationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = storage_path('app/seeds/quotations.csv');
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

            Quotation::create([
                'quotation_number' => $data['quotation_number'] ?? null,
                'client_id' => $data['client_id'] ?? null,
                'mileage' => $data['mileage'] ?? null,
                'discount' => $data['discount'] ?? null,
                'final_price' => $data['final_price'] ?? null,
                'status' => $data['status'] ?? null,
                'valid_until' => isset($data['valid_until']) ? Carbon::createFromFormat('d-M-Y', $data['valid_until']) : null,

            ]);
        }

        $this->command->info("Quotation data seeded successfully.");
    }
}
