<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Staff;
use App\Models\SalaryStructure;
use Spatie\Permission\Models\Role;

class StaffSeeder extends Seeder
{
    public function run(): void
    {
        $staffList = [
            [
                'user' => [
                    'name' => 'Khairul Kalil',
                    'email' => 'test@gmail.com',
                    'password' => bcrypt('11223344'),
                ],
                'staff' => [
                    'full_name' => 'Muhammad Khairul bin Md Kalil',
                    'ic_num' => '980701105531',
                    'branch_id' => 1,
                    'department_id' => 1,
                ],
                'role' => 'superadmin',
                'salary' => [
                    'base_salary' => 2300.00,
                    'work_hour_per_day' => 8,
                    'work_day_per_week' => 5,
                    'epf_employee' => 11.00,
                    'epf_employer' => 13.00,
                    'effective_from' => now(),
                ],
            ],
            [
                'user' => [
                    'name' => 'Taufik Jamain',
                    'email' => 'taufik@test.com',
                    'password' => bcrypt('11223344'),
                ],
                'staff' => [
                    'full_name' => 'Mohd Taufik bin Jamain',
                    'ic_num' => '000000334455',
                    'branch_id' => 1,
                    'department_id' => 2,
                ],
                'role' => 'admin',
                'salary' => [
                    'base_salary' => 4000.00,
                    'work_hour_per_day' => 8,
                    'work_day_per_week' => 5,
                    'epf_employee' => 11.00,
                    'epf_employer' => 13.00,
                    'effective_from' => now(),
                ],
            ],
            [
                'user' => [
                    'name' => 'Fauziah',
                    'email' => 'fauziah@test.com',
                    'password' => bcrypt('11223344'),
                ],
                'staff' => [
                    'full_name' => 'Fauziah binti Abdullah',
                    'ic_num' => '000000112222',
                    'branch_id' => 1,
                    'department_id' => 3,
                ],
                'role' => 'humanresource',
                'salary' => [
                    'base_salary' => 2000.00,
                    'work_hour_per_day' => 8,
                    'work_day_per_week' => 5,
                    'epf_employee' => 11.00,
                    'epf_employer' => 13.00,
                    'effective_from' => now(),
                ],
            ],
            [
                'user' => [
                    'name' => 'Zara',
                    'email' => 'zara@test.com',
                    'password' => bcrypt('11223344'),
                ],
                'staff' => [
                    'full_name' => 'Zara Mixigo',
                    'ic_num' => '000000334455',
                    'branch_id' => 1,
                    'department_id' => 6,
                ],
                'role' => 'admin',
                'salary' => [
                    'base_salary' => 1700.00,
                    'work_hour_per_day' => 8,
                    'work_day_per_week' => 5,
                    'epf_employee' => 11.00,
                    'epf_employer' => 13.00,
                    'effective_from' => now(),
                ],
            ],
        ];

        foreach ($staffList as $item) {
            // Create user
            $user = User::updateOrCreate(
                ['email' => $item['user']['email']],
                $item['user']
            );

            // Assign role
            if (!$user->hasRole($item['role'])) {
                $user->assignRole($item['role']);
            }

            // Create staff record
            $staff = Staff::updateOrCreate(
                ['user_id' => $user->id],
                $item['staff']
            );

            // Create salary structure
            SalaryStructure::updateOrCreate(
                ['staff_id' => $staff->id],
                $item['salary']
            );
        }
    }
}
