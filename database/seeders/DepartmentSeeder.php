<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{

    public function run(): void
    {
        $departments = [
            ['department_name' => 'IT'],
            ['department_name' => 'Operation'],
            ['department_name' => 'Human Resources'],
            ['department_name' => 'Finance'],
            ['department_name' => 'Sales'],
            ['department_name' => 'Marketing'],
            ['department_name' => 'Logistics'],
        ];

        foreach($departments as $department){
            Department::create($department);
        }
    }
}
