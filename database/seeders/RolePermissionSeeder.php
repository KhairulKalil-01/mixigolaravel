<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{

    public function run(): void
    {
        // Clear cache first
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [

            //dashboard and reports
            'Sales Report',
            'Operation Report',
            'Caregiver Report',
            'Client Report',
            'Salary reports',

            //entries
            'All Quotation Entries',
            'View Quotation Entry',
            'Edit Quotation Entry',
            'Delete Quotation Entry',

            'All Wakaf Entries',
            'View Wakaf Entries',
            'Edit Wakaf Entries',
            'Delete Wakaf Entries',

            'All Training Entries',
            'View Training Entries',
            'Edit Training Entries',
            'Delete Training Entries',

            //users
            'All Users',
            'Create Users',
            'View User',
            'Edit User',
            'Delete User',

            //branches
            'All Branches',
            'View Branch',
            'Edit Branch',
            'Delete Branch',
            'Create Branch',

            //departments
            'All Departments',
            'Create Department',
            'View Department',
            'Edit Department',
            'Delete Department',

            //designations
            'All Designations',
            'Create Designation',
            'View Designation',
            'Edit Designation',
            'Delete Designation',

            //roles
            'All Roles',
            'Create Role',
            'View Role',
            'Edit Role',
            'Delete Role',

            //permissions
            'All Permissions',
            'Create Permission',
            'View Permission',
            'Edit Permission',
            'Delete Permission',

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

            //clients
            'All Clients',
            'Create Client',
            'View Client',
            'Edit Client',
            'Delete Client',
            
            //patients
            'All Patients',
            'Create Patient',
            'View Patient',
            'Edit Patient',
            'Delete Patient',

            //quotations
            'All Quotations',
            'Create Quotation',
            'View Quotation',
            'Edit Quotation',
            'Delete Quotation',

            //invoices
            'All Invoices',
            'Create Invoice',
            'View Invoice',
            'Edit Invoice',
            'Delete Invoice',

            //job forms
            'All Jobs',
            'Create Job',
            'View Job',
            'Edit Job',
            'Delete Job',

            //caregivers
            'All Caregivers',
            'Create Caregiver',
            'View Caregiver',
            'Edit Caregiver',
            'Delete Caregiver',

            //payment forms from clients
            'All Client Payments',
            'Create Client Payment',
            'View Client Payment',
            'Edit Client Payment',
            'Delete Client Payment',

            //overtimes
            'All Overtimes',
            'Create Overtime',
            'View Overtime',
            'Edit Overtime',
            'Delete Overtime',

            //service receipts
            'All Service Receipts',
            'Create Service Receipt',
            'View Service Receipt',
            'Edit Service Receipt',
            'Delete Service Receipt'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

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
        $superAdminRole->syncPermissions($permissions);

        $adminRole->syncPermissions([
            'Sales Report',
            'Operation Report',
            'Caregiver Report',
            'Client Report',
            'Salary reports',
            //users
            'All Users',
            'Create Users',
            'View User',
            'Edit User',
            'Delete User',
        ]);

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
