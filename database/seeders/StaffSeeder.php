<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Staff;
use Spatie\Permission\Models\Role;

class StaffSeeder extends Seeder
{
    public function run(): void
    {
        $staffList = [
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
            ],
        ];

        foreach ($staffList as $item) {
            // Create user
            $user = User::firstOrCreate(
                ['email' => $item['user']['name']],
                $item['user']
            );

            // Assign role
            if (!$user->hasRole($item['role'])) {
                $user->assignRole($item['role']);
            }

            // Create staff record
            Staff::firstOrCreate(
                ['user_id' => $user->id],
                $item['staff']
            );
        }
    }
}
