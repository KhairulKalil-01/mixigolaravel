<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Designation;
use Illuminate\Database\Seeder;


class DesignationSeeder extends Seeder
{
    public function run(): void
    {
        $designations = [
            ['designation_name' => 'Super Admin'],
            ['designation_name' => 'Admin'],
            ['designation_name' => 'General Manager'],
            ['designation_name' => 'Branch Manager'],
            ['designation_name' => 'Manager'],
            ['designation_name' => 'Staff'],
        ];

        foreach($designations as $designation){
            Designation::create($designation);
        }
    }
}
