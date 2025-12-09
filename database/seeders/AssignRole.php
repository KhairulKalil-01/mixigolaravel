<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AssignRole extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the user (you can also use create() here if needed)
        $user = User::where('email', 'fauziah@test.com')->first();

        if ($user) {
            // Assign role by name
            $user->assignRole('humanresource'); // or any role name that exists
        }
    }
}
