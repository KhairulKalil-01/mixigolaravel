<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ServicePricing;

class ServicePricingSeeder extends Seeder
{
    public function run(): void
    {

        $servicePricing = [
            ['service_name' => '50-Hour Private Caregiver', 'service_type' => 'Caregiver', 'number_of_days' => null, 'number_of_hours' => '50', 'number_of_sessions' => null, 'price' => 1500, 'remarks' => null],
            ['service_name' => '100-Hour Private Caregiver', 'service_type' => 'Caregiver', 'number_of_days' => null, 'number_of_hours' => '100', 'number_of_sessions' => null, 'price' => 2800, 'remarks' => null],
            ['service_name' => '200-Hour Private Caregiver', 'service_type' => 'Caregiver', 'number_of_days' => null, 'number_of_hours' => '200', 'number_of_sessions' => null, 'price' => 4800, 'remarks' => null],
            ['service_name' => '4-Hour Private Caregiver', 'service_type' => 'Caregiver', 'number_of_days' => null, 'number_of_hours' => '4', 'number_of_sessions' => '1', 'price' => 150, 'remarks' => null],
            ['service_name' => '4-Hour Private Caregiver (Weekend/PH)', 'service_type' => 'Caregiver', 'number_of_days' => null, 'number_of_hours' => '4', 'number_of_sessions' => '1', 'price' => 300, 'remarks' => null],
            ['service_name' => 'Fresh and Clean', 'service_type' => 'Caregiver', 'number_of_days' => null, 'number_of_hours' => '2', 'number_of_sessions' => '1', 'price' => 110, 'remarks' => 'For one session'],
            ['service_name' => 'Fresh and Clean (Weekend/PH)', 'service_type' => 'Caregiver', 'number_of_days' => null, 'number_of_hours' => '2', 'number_of_sessions' => '10', 'price' => 220, 'remarks' => 'For one session on weekend/public holiday'],
            ['service_name' => 'Add-On: Simple Wound Dressing', 'service_type' => 'Nursing', 'number_of_days' => null, 'number_of_hours' => null, 'number_of_sessions' => '1', 'price' => 30, 'remarks' => '1 Dressing Procedure. Normal Saline. Must have active caregiver service'],
            ['service_name' => 'Dressing: Bedsore Care', 'service_type' => 'Nursing', 'number_of_days' => null, 'number_of_hours' => null, 'number_of_sessions' => '1', 'price' => 120, 'remarks' => '1 Session'],
            ['service_name' => 'Dressing: Tracheostomy Care', 'service_type' => 'Nursing', 'number_of_days' => null, 'number_of_hours' => null, 'number_of_sessions' => '1', 'price' => 100, 'remarks' => '1 Session'],
            ['service_name' => 'Dressing: Wound Care', 'service_type' => 'Nursing', 'number_of_days' => null, 'number_of_hours' => null, 'number_of_sessions' => '1', 'price' => 120, 'remarks' => '1 Session'],
            ['service_name' => 'Dressing: Stoma Care', 'service_type' => 'Nursing', 'number_of_days' => null, 'number_of_hours' => null, 'number_of_sessions' => '1', 'price' => 100, 'remarks' => '1 Session'],
            ['service_name' => 'Dressing: Peg Tube Care', 'service_type' => 'Nursing', 'number_of_days' => null, 'number_of_hours' => null, 'number_of_sessions' => '1', 'price' => 80, 'remarks' => '1 Session'],
            ['service_name' => 'Tubing: Food Tube Insertion', 'service_type' => 'Nursing', 'number_of_days' => null, 'number_of_hours' => null, 'number_of_sessions' => '1', 'price' => 110, 'remarks' => '1 Session'],
            ['service_name' => 'Tubing: Urine Catheter', 'service_type' => 'Nursing', 'number_of_days' => null, 'number_of_hours' => null, 'number_of_sessions' => '1', 'price' => 100, 'remarks' => '1 Session'],
            ['service_name' => 'Suction', 'service_type' => 'Nursing', 'number_of_days' => null, 'number_of_hours' => null, 'number_of_sessions' => '1', 'price' => 50, 'remarks' => '1 Session'],
            ['service_name' => 'IV Drip Infusion', 'service_type' => 'Nursing', 'number_of_days' => null, 'number_of_hours' => null, 'number_of_sessions' => '1', 'price' => 70, 'remarks' => '1 Session'],
            ['service_name' => 'Physiotherapy', 'service_type' => 'Physiotherapy', 'number_of_days' => null, 'number_of_hours' => null, 'number_of_sessions' => '1', 'price' => 180, 'remarks' => '1 Session'],
            ['service_name' => 'Ambulan Service (Klang Valley)', 'service_type' => 'Transportation', 'number_of_days' => null, 'number_of_hours' => null, 'number_of_sessions' => '1', 'price' => 350, 'remarks' => 'For Klang Valley Only'],
        ];


        foreach ($servicePricing as $pricing) {
            ServicePricing::updateOrCreate(
                ['service_name' => $pricing['service_name']],
                [
                    'service_type' => $pricing['service_type'],
                    'number_of_days' => $pricing['number_of_days'],
                    'number_of_hours' => $pricing['number_of_hours'],
                    'number_of_sessions' => $pricing['number_of_sessions'],
                    'price' => $pricing['price'],
                    'remarks' => $pricing['remarks']
                ]
            );
        }
    }
}
