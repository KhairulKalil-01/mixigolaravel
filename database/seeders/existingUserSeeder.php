<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Staff;
use App\Models\SalaryStructure;

class existingUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'test@gmail.com')->first();

        if($user && !Staff::where('user_id', $user->id)->exists()){
            Staff::create([
                'user_id' => $user->id,
                'branch_id' => '1',
                'department_id' => '1',
                'full_name' => 'Muhammad Khairul bin Md Kalil',
                'ic_num' => '980701105531',
                'passport' => 'L1234',
            ]);
        }

    }
}
