<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Caregiver;
use Illuminate\Support\Carbon;

class CaregiverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //To seed caregivers

        $genderMap = [
            'male' => 1,
            'female' => 2,
        ];

        $employmentTypeMap = [
            'full time' => 1,
            'part time' => 2,
            'contract' => 3,
        ];

        $branchMap = [
            'Klang Valley' => 1,
        ];

        $is_activeMap = [
            'inactive' => 0,
            'active' => 1,
            'standby' => 2,
            'on leave' => 3,
            'resigned' => 4,
            'terminated' => 5
        ];

        $nationalityMap = [
            'Malaysia' => 1,
            'Indonesia' => 2,
            'Philippines' => 3,
            'Bangladesh' => 4,
            'India' => 5,
            'Pakistan' => 6,
            'Sri Lanka' => 7,
            'Nepal' => 8,
            'Vietnam' => 9,
            'Thailand' => 10,
        ];

        $file = storage_path('app/seeds/caregivers.csv');
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

            Caregiver::create([
                'name' => $data['name'] ?? null,
                'sex' => $genderMap[strtolower($data['gender'] ?? '')] ?? null,
                'employment_type' => $employmentTypeMap[strtolower(trim($data['employment'] ?? ''))] ?? null,
                'branch_id' => $branchMap[$data['branch'] ?? ''] ?? null,
                'is_active' => $is_activeMap[strtolower($data['is_active'] ?? '')] ?? null,
                'nationality' => $nationalityMap[$data['nationality'] ?? ''] ?? null,
                'mobileno' => $data['phone'] ?? null,
                'email' => $data['email'] ?? null,
                'ic_num' => $data['ic_number'] ?? null,
                'passport' => $data['passport'] ?? null,
                'current_address' => $data['current_address'] ?? null,
                'permanent_address' => $data['permanent_address'] ?? null,
                /* 'coordinate' => $data['Coordinate'] ?? null, */
                /* 'area' => $data['Area'] ?? null, */
                'employment_date' => isset($data['employment_date']) && $data['employment_date']
                    ? Carbon::createFromFormat('d/m/Y', $data['employment_date'])->format('Y-m-d')
                    : null,
                /* 'bank_name' => $data['bank_name'] ?? null, */
                'bank_num' => $data['bank_account'] ?? null,
                'emergency_no' => $data['emergency_contact'] ?? null,
                'remarks' => $data['remarks'] ?? null,
            ]);
        }

        $this->command->info("Caregiver data seeded successfully.");
    }
}
