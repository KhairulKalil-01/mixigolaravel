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
        $modules = [
            ['name' => 'Dashboard', 'prefix' => 'dashboard', 'is_system' => true, 'sorted' => 1],
            ['name' => 'Entries', 'prefix' => 'entries', 'is_system' => true, 'sorted' => 2],
            ['name' => 'Users', 'prefix' => 'users', 'is_system' => true, 'sorted' => 3],
            ['name' => 'Operation', 'prefix' => 'operation', 'is_system' => true, 'sorted' => 4],
            ['name' => 'Human Resource', 'prefix' => 'human_resource', 'is_system' => true, 'sorted' => 5],
            ['name' => 'Client and Patient', 'prefix' => 'client_and_patient', 'is_system' => true, 'sorted' => 6],
            ['name' => 'Caregiver', 'prefix' => 'caregiver', 'is_system' => true, 'sorted' => 7],
            ['name' => 'Billing', 'prefix' => 'billing', 'is_system' => true, 'sorted' => 8],
            /* ['name' => 'Jobs & Services', 'prefix' => 'jobs_and_services', 'is_system' => true, 'sorted' => 9], */ //remove (move all under operation)
            ['name' => 'Sales', 'prefix' => 'sales', 'is_system' => true, 'sorted' => 9], // commission, external agents, (leads?)
            ['name' => 'Services & Products', 'prefix' => 'services_and_products', 'is_system' => true, 'sorted' => 10],
            ['name' => 'Master', 'prefix' => 'master', 'is_system' => true, 'sorted' => 99],
        ];

        foreach ($modules as $data) {
            Module::updateOrCreate(
                ['prefix' => $data['prefix']], // Unique identifier
                [
                    'name' => $data['name'],
                    'is_system' => $data['is_system'],
                    'sorted' => $data['sorted'],
                ]
            );
        }
    }
}
