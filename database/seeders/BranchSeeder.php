<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Branch;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branches = [
            [
                'branch_name' => 'Mixigo KV',
                'mobileno' => '0',
                'city' => 'Seri Kembangan',
                'State' => 'Selangor',
                'address' => 'D-2-15, One South Street Mall, Jln OS, Seksyen 6'
            ]
        ];

        foreach ($branches as $branch)
       {
            Branch::firstOrCreate(['branch_name' => $branch['branch_name']], $branch);
       } 
    }
}
