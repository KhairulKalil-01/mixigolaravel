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

            // Dashboard and Reports
            ['name' => 'Sales Report', 'slug' => 'sales-report'],
            ['name' => 'Operation Report', 'slug' => 'operation-report'],
            ['name' => 'Caregiver Report', 'slug' => 'caregiver-report'],
            ['name' => 'Client Report', 'slug' => 'client-report'],
            ['name' => 'Salary Report', 'slug' => 'salary-report'],

            // Quotation Entries
            ['name' => 'Quotation Entries', 'slug' => 'quotation-entries.index'],
            ['name' => 'View Quotation Entry', 'slug' => 'quotation-entries.show'],
            ['name' => 'Edit Quotation Entry', 'slug' => 'quotation-entries.edit'],
            ['name' => 'Delete Quotation Entry', 'slug' => 'quotation-entries.destroy'],

            // Wakaf Entries
            ['name' => 'Wakaf Entries', 'slug' => 'wakaf.index'],
            ['name' => 'View Wakaf Entries', 'slug' => 'wakaf.show'],
            ['name' => 'Edit Wakaf Entries', 'slug' => 'wakaf.edit'],
            ['name' => 'Delete Wakaf Entries', 'slug' => 'wakaf.destroy'],

            // Training Entries
            ['name' => 'Training Entries', 'slug' => 'training.index'],
            ['name' => 'View Training Entries', 'slug' => 'training.show'],
            ['name' => 'Edit Training Entries', 'slug' => 'training.edit'],
            ['name' => 'Delete Training Entries', 'slug' => 'training.destroy'],

            // Users
            ['name' => 'Users', 'slug' => 'users.index'],
            ['name' => 'Create Users', 'slug' => 'users.create'],
            ['name' => 'View User', 'slug' => 'users.show'],
            ['name' => 'Edit User', 'slug' => 'users.edit'],
            ['name' => 'Delete User', 'slug' => 'users.destroy'],

            // Branches
            ['name' => 'Branches', 'slug' => 'branches.index'],
            ['name' => 'Create Branch', 'slug' => 'branches.create'],
            ['name' => 'View Branch', 'slug' => 'branches.show'],
            ['name' => 'Edit Branch', 'slug' => 'branches.edit'],
            ['name' => 'Delete Branch', 'slug' => 'branches.destroy'],

            // Departments
            ['name' => 'Departments', 'slug' => 'departments.index'],
            ['name' => 'Create Department', 'slug' => 'departments.create'],
            ['name' => 'View Department', 'slug' => 'departments.show'],
            ['name' => 'Edit Department', 'slug' => 'departments.edit'],
            ['name' => 'Delete Department', 'slug' => 'departments.destroy'],

            // Designations
            ['name' => 'Designations', 'slug' => 'designations.index'],
            ['name' => 'Create Designation', 'slug' => 'designations.create'],
            ['name' => 'View Designation', 'slug' => 'designations.show'],
            ['name' => 'Edit Designation', 'slug' => 'designations.edit'],
            ['name' => 'Delete Designation', 'slug' => 'designations.destroy'],

            // Roles
            ['name' => 'Roles', 'slug' => 'roles.index'],
            ['name' => 'Create Role', 'slug' => 'roles.create'],
            ['name' => 'View Role', 'slug' => 'roles.show'],
            ['name' => 'Edit Role', 'slug' => 'roles.edit'],
            ['name' => 'Delete Role', 'slug' => 'roles.destroy'],

            // Permissions
            ['name' => 'Permissions', 'slug' => 'permissions.index'],
            ['name' => 'Create Permission', 'slug' => 'permissions.create'],
            ['name' => 'View Permission', 'slug' => 'permissions.show'],
            ['name' => 'Edit Permission', 'slug' => 'permissions.edit'],
            ['name' => 'Delete Permission', 'slug' => 'permissions.destroy'],

            // Salary Records
            ['name' => 'Salary Records', 'slug' => 'salary-records.index'],
            ['name' => 'Create Salary Record', 'slug' => 'salary-records.create'],
            ['name' => 'View Salary Record', 'slug' => 'salary-records.show'],
            ['name' => 'Edit Salary Record', 'slug' => 'salary-records.edit'],
            ['name' => 'Delete Salary Record', 'slug' => 'salary-records.destroy'],

            // Salary Assign
            ['name' => 'Salary Assign', 'slug' => 'salary-assign.index'],
            ['name' => 'View Salary Assign', 'slug' => 'salary-assign.show'],
            ['name' => 'Edit Salary Assign', 'slug' => 'salary-assign.edit'],
            ['name' => 'Delete Salary Assign', 'slug' => 'salary-assign.destroy'],

            // Caregiver Payments
            ['name' => 'Caregiver Payments', 'slug' => 'caregiver-payments.index'],
            ['name' => 'Create Caregiver Payment', 'slug' => 'caregiver-payments.create'],
            ['name' => 'View Caregiver Payment', 'slug' => 'caregiver-payments.show'],
            ['name' => 'Edit Caregiver Payment', 'slug' => 'caregiver-payments.edit'],
            ['name' => 'Delete Caregiver Payment', 'slug' => 'caregiver-payments.destroy'],

            // Clients
            ['name' => 'Clients', 'slug' => 'clients.index'],
            ['name' => 'Create Client', 'slug' => 'clients.create'],
            ['name' => 'View Client', 'slug' => 'clients.show'],
            ['name' => 'Edit Client', 'slug' => 'clients.edit'],
            ['name' => 'Delete Client', 'slug' => 'clients.destroy'],

            // Patients
            ['name' => 'Patients', 'slug' => 'patients.index'],
            ['name' => 'Create Patient', 'slug' => 'patients.create'],
            ['name' => 'View Patient', 'slug' => 'patients.show'],
            ['name' => 'Edit Patient', 'slug' => 'patients.edit'],
            ['name' => 'Delete Patient', 'slug' => 'patients.destroy'],

            // Quotations
            ['name' => 'Quotations', 'slug' => 'quotations.index'],
            ['name' => 'Create Quotation', 'slug' => 'quotations.create'],
            ['name' => 'View Quotation', 'slug' => 'quotations.show'],
            ['name' => 'Edit Quotation', 'slug' => 'quotations.edit'],
            ['name' => 'Delete Quotation', 'slug' => 'quotations.destroy'],

            // Invoices
            ['name' => 'Invoices', 'slug' => 'invoices.index'],
            ['name' => 'Create Invoice', 'slug' => 'invoices.create'],
            ['name' => 'View Invoice', 'slug' => 'invoices.show'],
            ['name' => 'Edit Invoice', 'slug' => 'invoices.edit'],
            ['name' => 'Delete Invoice', 'slug' => 'invoices.destroy'],

            // Jobs
            ['name' => 'Jobs', 'slug' => 'jobs.index'],
            ['name' => 'Create Job', 'slug' => 'jobs.create'],
            ['name' => 'View Job', 'slug' => 'jobs.show'],
            ['name' => 'Edit Job', 'slug' => 'jobs.edit'],
            ['name' => 'Delete Job', 'slug' => 'jobs.destroy'],

            // Caregivers
            ['name' => 'Caregivers', 'slug' => 'caregivers.index'],
            ['name' => 'Create Caregiver', 'slug' => 'caregivers.create'],
            ['name' => 'View Caregiver', 'slug' => 'caregivers.show'],
            ['name' => 'Edit Caregiver', 'slug' => 'caregivers.edit'],
            ['name' => 'Delete Caregiver', 'slug' => 'caregivers.destroy'],

            // Client Payments
            ['name' => 'Client Payments', 'slug' => 'client-payments.index'],
            ['name' => 'Create Client Payment', 'slug' => 'client-payments.create'],
            ['name' => 'View Client Payment', 'slug' => 'client-payments.show'],
            ['name' => 'Edit Client Payment', 'slug' => 'client-payments.edit'],
            ['name' => 'Delete Client Payment', 'slug' => 'client-payments.destroy'],

            // Overtimes
            ['name' => 'Overtimes', 'slug' => 'overtimes.index'],
            ['name' => 'Create Overtime', 'slug' => 'overtimes.create'],
            ['name' => 'View Overtime', 'slug' => 'overtimes.show'],
            ['name' => 'Edit Overtime', 'slug' => 'overtimes.edit'],
            ['name' => 'Delete Overtime', 'slug' => 'overtimes.destroy'],

            // Service Receipts
            ['name' => 'Service Receipts', 'slug' => 'service-receipts.index'],
            ['name' => 'Create Service Receipt', 'slug' => 'service-receipts.create'],
            ['name' => 'View Service Receipt', 'slug' => 'service-receipts.show'],
            ['name' => 'Edit Service Receipt', 'slug' => 'service-receipts.edit'],
            ['name' => 'Delete Service Receipt', 'slug' => 'service-receipts.destroy'],
        ];

        foreach ($permissions as $perm) {
            Permission::updateOrCreate(
                ['name' => $perm['name']],
                ['slug' => $perm['slug']]
            );
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
            'Salary Reports',
            //users
            'Users',
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
