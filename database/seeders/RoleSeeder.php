<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        

        // Create roles
        $superAdminRole = Role::firstOrCreate(['name' => 'superadmin']);
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $humanresourceRole = Role::firstOrCreate(['name' => 'humanresource']);
        $financeRole = Role::firstOrCreate(['name' => 'finance']);
        $marketingRole = Role::firstOrCreate(['name' => 'marketing']);
        $operationRole = Role::firstOrCreate(['name' => 'operation']);
        $caregiverRole = Role::firstOrCreate(['name' => 'caregiver']);
        $clientRole = Role::firstOrCreate(['name' => 'client']);
        $patientRole = Role::firstOrCreate(['name' => 'patient']);




        // Assign all permissions to admin
        $permissions = Permission::all();
        $superAdminRole->syncPermissions($permissions);

        $humanresourceRole->syncPermissions([
            //salary records
            'Salary Records',
            'Create Salary Record',
            'View Salary Record',
            'Edit Salary Record',
            'Delete Salary Record',

            //salary assign
            'Salary Assign',
            'View Salary Assign',
            'Edit Salary Assign',
            'Delete Salary Assign',

            //Caregiver payments
            'Caregiver Payments',
            'Create Caregiver Payment',
            'View Caregiver Payment',
            'Edit Caregiver Payment',
            'Delete Caregiver Payment',
        ]);


        // Assign 'admin' role to first user
        $user = User::find(1);
        if ($user) {
            $user->assignRole($superAdminRole);
        }
    }
}
