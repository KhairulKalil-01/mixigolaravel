<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Invoice;
use Illuminate\Support\Carbon;


class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = storage_path('app/seeds/invoices.csv');
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

            Invoice::create([
                'invoice_number' => $data['invoice_number'] ?? null,
                'quotation_id' => $data['quotation_id'] ?? null,
                'client_id' => $data['client_id'] ?? null,
                'paid_amount' => $data['paid_amount'] ?? null,
                'total_amount' => $data['total_amount'] ?? null,
                'payment_status' => $data['payment_status'] ?? null,
                'invoice_date' => isset($data['invoice_date']) ? Carbon::createFromFormat('d-M-Y', $data['invoice_date']) : null,
                'due_date' => isset($data['due_date']) ? Carbon::createFromFormat('d-M-Y', $data['due_date']) : null,
            ]);
        }

        $this->command->info("Inovice data seeded successfully.");
    }
}
