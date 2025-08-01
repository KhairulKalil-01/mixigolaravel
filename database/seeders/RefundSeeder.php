<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Refund;
use Illuminate\Support\Carbon;


class RefundSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = storage_path('app/seeds/refunds.csv');
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

            Refund::create([
                'refund_number' => $data['refund_number'] ?? null,
                'credit_note_id' => $data['credit_note_id'] ?? null,
                'invoice_id' => $data['invoice_id'] ?? null,
                'status' => $data['status'] ?? null,
                'amount' => $data['amount'] ?? null,
                'refund_date' => isset($data['refund_date']) ? Carbon::createFromFormat('d-M-Y', $data['refund_date']) : null,
                'reason_type' => $data['reason_type'] ?? null,
                'bank_id' => $data['bank_id'] ?? null,
                'remarks' => $data['remarks'] ?? null,

            ]);
        }

        $this->command->info("Credit Notes data seeded successfully.");
    }
}
