<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Module;

class ModulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Module::insert([
            [
                'name' => 'Dashboard',
                'prefix' => 'dashboard',
                'is_system' => true,
                'sorted' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Entries',
                'prefix' => 'entries',
                'is_system' => true,
                'sorted' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Users',
                'prefix' => 'users',
                'is_system' => true,
                'sorted' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Operation',
                'prefix' => 'operation',
                'is_system' => true,
                'sorted' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Human Resource',
                'prefix' => 'human_resource',
                'is_system' => true,
                'sorted' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Client and Patient',
                'prefix' => 'client_and_patient',
                'is_system' => true,
                'sorted' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Caregiver',
                'prefix' => 'caregiver',
                'is_system' => true,
                'sorted' => 7,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Billing',
                'prefix' => 'billing',
                'is_system' => true,
                'sorted' => 8,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Jobs & Services',
                'prefix' => 'jobs_and_services',
                'is_system' => true,
                'sorted' => 9,
                'created_at' => now(),
                'updated_at' => now()
            ]
            
            
        ]);
    }
}
