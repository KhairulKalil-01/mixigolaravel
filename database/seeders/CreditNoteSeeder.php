<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\CreditNote;
use Illuminate\Support\Carbon;


class CreditNoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = storage_path('app/seeds/credit-notes.csv');
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

            CreditNote::create([
                'credit_note_number' => $data['credit_note_number'] ?? null,
                'invoice_id' => $data['invoice_id'] ?? null,
                'client_id' => $data['client_id'] ?? null,
                'credit_note_date' => isset($data['credit_note_date']) ? Carbon::createFromFormat('d-M-Y', $data['credit_note_date']) : null,
                'credit_amount' => $data['credit_amount'] ?? null,
                'reason_type' => $data['reason_type'] ?? null,
                'remarks' => $data['remarks'] ?? null,
            ]);
        }

        $this->command->info("Credit Notes data seeded successfully.");
    }
}
