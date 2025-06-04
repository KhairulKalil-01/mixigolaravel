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
        /* $user = User::create([
            'name' => 'Fauziah',
            'email' => 'fauziah@test.com',
            'password' => bcrypt('11223344'),
        ]);

        // Assign role
        $user->assignRole('humanresource');

        // Create staff record linked to the user
        Staff::create([
            'user_id' => $user->id,
            'branch_id' =>  '1',
            'department_id' => '3',
            'full_name' => 'Fauziah binti Abdullah',
            'ic_num' => '000000112222',
        ]); */

        $userId = 3;
        $user = User::find($userId);

        if ($user) {
            // Insert into staffs only if no existing record
            Staff::firstOrCreate(
                ['user_id' => $userId],
                [
                    'branch_id' =>  '1',
                    'department_id' => '3',
                    'full_name' => 'Fauziah binti Abdullah',
                    'ic_num' => '000000112222',
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ]
            );
        }
    }
}
