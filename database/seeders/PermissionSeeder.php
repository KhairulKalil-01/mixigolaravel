<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class PermissionSeeder extends Seeder
{

    public function run(): void
    {
        // Clear cache first
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [

            // Dashboard and Reports
            ['name' => 'Sales Report', 'slug' => 'sales-report', 'visible_in_menu' => '1', 'module_id' => '1'],
            ['name' => 'Operation Report', 'slug' => 'operation-report', 'visible_in_menu' => '1', 'module_id' => '1'],
            ['name' => 'Caregiver Report', 'slug' => 'caregiver-report', 'visible_in_menu' => '1', 'module_id' => '1'],
            ['name' => 'Client Report', 'slug' => 'client-report', 'visible_in_menu' => '1', 'module_id' => '1'],
            ['name' => 'Salary Report', 'slug' => 'salary-report', 'visible_in_menu' => '1', 'module_id' => '1'],

            // Quotation Entries
            ['name' => 'Quotation Entries', 'slug' => 'quotation-entries.index', 'visible_in_menu' => '1', 'module_id' => '2'],
            ['name' => 'View Quotation Entry', 'slug' => 'quotation-entries.show', 'visible_in_menu' => '0', 'module_id' => '2'],
            ['name' => 'Edit Quotation Entry', 'slug' => 'quotation-entries.edit', 'visible_in_menu' => '0', 'module_id' => '2'],
            ['name' => 'Delete Quotation Entry', 'slug' => 'quotation-entries.destroy', 'visible_in_menu' => '0', 'module_id' => '2'],

            // Wakaf Entries
            ['name' => 'Wakaf Entries', 'slug' => 'wakaf.index', 'visible_in_menu' => '1', 'module_id' => '2'],
            ['name' => 'View Wakaf Entries', 'slug' => 'wakaf.show', 'visible_in_menu' => '0', 'module_id' => '2'],
            ['name' => 'Edit Wakaf Entries', 'slug' => 'wakaf.edit', 'visible_in_menu' => '0', 'module_id' => '2'],
            ['name' => 'Delete Wakaf Entries', 'slug' => 'wakaf.destroy', 'visible_in_menu' => '0', 'module_id' => '2'],

            // Training Entries
            ['name' => 'Training Entries', 'slug' => 'training.index', 'visible_in_menu' => '1', 'module_id' => '2'],
            ['name' => 'View Training Entries', 'slug' => 'training.show', 'visible_in_menu' => '0', 'module_id' => '2'],
            ['name' => 'Edit Training Entries', 'slug' => 'training.edit', 'visible_in_menu' => '0', 'module_id' => '2'],
            ['name' => 'Delete Training Entries', 'slug' => 'training.destroy', 'visible_in_menu' => '0', 'module_id' => '2'],

            // Users
            ['name' => 'Users', 'slug' => 'users.index', 'visible_in_menu' => '1', 'module_id' => '3'],
            ['name' => 'Create User', 'slug' => 'user.create', 'visible_in_menu' => '0', 'module_id' => '3'],
            ['name' => 'View User', 'slug' => 'users.show', 'visible_in_menu' => '0', 'module_id' => '3'],
            ['name' => 'Edit User', 'slug' => 'users.edit', 'visible_in_menu' => '0', 'module_id' => '3'],
            ['name' => 'Delete User', 'slug' => 'users.destroy', 'visible_in_menu' => '0', 'module_id' => '3'],

            // Branches
            ['name' => 'Branches', 'slug' => 'branches.index', 'visible_in_menu' => '1', 'module_id' => '4'],
            ['name' => 'Create Branch', 'slug' => 'branches.create', 'visible_in_menu' => '0', 'module_id' => '4'],
            ['name' => 'View Branch', 'slug' => 'branches.show', 'visible_in_menu' => '0', 'module_id' => '4'],
            ['name' => 'Edit Branch', 'slug' => 'branches.edit', 'visible_in_menu' => '0', 'module_id' => '4'],
            ['name' => 'Delete Branch', 'slug' => 'branches.destroy', 'visible_in_menu' => '0', 'module_id' => '4'],

            // Departments
            ['name' => 'Departments', 'slug' => 'departments.index', 'visible_in_menu' => '1', 'module_id' => '4'],
            ['name' => 'Create Department', 'slug' => 'departments.create', 'visible_in_menu' => '0', 'module_id' => '4'],
            ['name' => 'View Department', 'slug' => 'departments.show', 'visible_in_menu' => '0', 'module_id' => '4'],
            ['name' => 'Edit Department', 'slug' => 'departments.edit', 'visible_in_menu' => '0', 'module_id' => '4'],
            ['name' => 'Delete Department', 'slug' => 'departments.destroy', 'visible_in_menu' => '0', 'module_id' => '4'],

            // Designations
            ['name' => 'Designations', 'slug' => 'designations.index', 'visible_in_menu' => '1', 'module_id' => '4'],
            ['name' => 'Create Designation', 'slug' => 'designations.create', 'visible_in_menu' => '0', 'module_id' => '4'],
            ['name' => 'View Designation', 'slug' => 'designations.show', 'visible_in_menu' => '0', 'module_id' => '4'],
            ['name' => 'Edit Designation', 'slug' => 'designations.edit', 'visible_in_menu' => '0', 'module_id' => '4'],
            ['name' => 'Delete Designation', 'slug' => 'designations.destroy', 'visible_in_menu' => '0', 'module_id' => '4'],

            // Roles
            ['name' => 'Roles', 'slug' => 'roles.index', 'visible_in_menu' => '1', 'module_id' => '4'],
            ['name' => 'Create Role', 'slug' => 'roles.create', 'visible_in_menu' => '0', 'module_id' => '4'],
            ['name' => 'View Role', 'slug' => 'roles.show', 'visible_in_menu' => '0', 'module_id' => '4'],
            ['name' => 'Edit Role', 'slug' => 'roles.edit', 'visible_in_menu' => '0', 'module_id' => '4'],
            ['name' => 'Delete Role', 'slug' => 'roles.destroy', 'visible_in_menu' => '0', 'module_id' => '4'],

            // Permissions
            ['name' => 'Permissions', 'slug' => 'permissions.index', 'visible_in_menu' => '0', 'module_id' => '4'],
            ['name' => 'Create Permission', 'slug' => 'permissions.create', 'visible_in_menu' => '0', 'module_id' => '4'],
            ['name' => 'View Permission', 'slug' => 'permissions.show', 'visible_in_menu' => '0', 'module_id' => '4'],
            ['name' => 'Edit Permission', 'slug' => 'permissions.edit', 'visible_in_menu' => '0', 'module_id' => '4'],
            ['name' => 'Delete Permission', 'slug' => 'permissions.destroy', 'visible_in_menu' => '0', 'module_id' => '4'],

            // Service Pricings
            ['name' => 'Service Pricings', 'slug' => 'service-pricings.index', 'visible_in_menu' => '1', 'module_id' => '4'],
            ['name' => 'Create Service Pricings', 'slug' => 'service-pricings.create', 'visible_in_menu' => '0', 'module_id' => '4'],
            ['name' => 'View Service Pricings', 'slug' => 'service-pricings.show', 'visible_in_menu' => '0', 'module_id' => '4'],
            ['name' => 'Edit Service Pricings', 'slug' => 'service-pricings.edit', 'visible_in_menu' => '0', 'module_id' => '4'],
            ['name' => 'Delete Service Pricings', 'slug' => 'service-pricings.destroy', 'visible_in_menu' => '0', 'module_id' => '4'],

            // Salary Records
            ['name' => 'Salary Records', 'slug' => 'salary-records.index', 'visible_in_menu' => '1', 'module_id' => '5'],
            ['name' => 'Create Salary Record', 'slug' => 'salary-records.create', 'visible_in_menu' => '0', 'module_id' => '5'],
            ['name' => 'View Salary Record', 'slug' => 'salary-records.show', 'visible_in_menu' => '0', 'module_id' => '5'],
            ['name' => 'Edit Salary Record', 'slug' => 'salary-records.edit', 'visible_in_menu' => '0', 'module_id' => '5'],
            ['name' => 'Delete Salary Record', 'slug' => 'salary-records.destroy', 'visible_in_menu' => '0', 'module_id' => '5'],
    
            // Salary Assign - Salary  Structures
            ['name' => 'Salary Structures', 'slug' => 'salary-structures.index', 'visible_in_menu' => '1', 'module_id' => '5'],
            ['name' => 'View Salary Structure', 'slug' => 'salary-structures.show', 'visible_in_menu' => '0', 'module_id' => '5'],
            ['name' => 'Edit Salary Structure', 'slug' => 'salary-structures.edit', 'visible_in_menu' => '0', 'module_id' => '5'],
            ['name' => 'Delete Salary Structure', 'slug' => 'salary-structures.destroy', 'visible_in_menu' => '0', 'module_id' => '5'],

            // Staff Claim
            ['name' => 'Staff Claims', 'slug' => 'staff-claims.index', 'visible_in_menu' => '1', 'module_id' => '5'],
            ['name' => 'Create Staff Claim', 'slug' => 'staff-claims.create', 'visible_in_menu' => '0', 'module_id' => '5'],
            ['name' => 'View Staff Claim', 'slug' => 'staff-claims.show', 'visible_in_menu' => '0', 'module_id' => '5'],
            ['name' => 'Edit Staff Claim', 'slug' => 'staff-claims.edit', 'visible_in_menu' => '0', 'module_id' => '5'],
            ['name' => 'Delete Staff Claim', 'slug' => 'staff-claims.destroy', 'visible_in_menu' => '0', 'module_id' => '5'],

            // Caregiver Payments
            ['name' => 'Caregiver Payments', 'slug' => 'caregiver-payments.index', 'visible_in_menu' => '1', 'module_id' => '5'],
            ['name' => 'Create Caregiver Payment', 'slug' => 'caregiver-payments.create', 'visible_in_menu' => '0', 'module_id' => '5'],
            ['name' => 'View Caregiver Payment', 'slug' => 'caregiver-payments.show', 'visible_in_menu' => '0', 'module_id' => '5'],
            ['name' => 'Edit Caregiver Payment', 'slug' => 'caregiver-payments.edit', 'visible_in_menu' => '0', 'module_id' => '5'],
            ['name' => 'Delete Caregiver Payment', 'slug' => 'caregiver-payments.destroy', 'visible_in_menu' => '0', 'module_id' => '5'],

            // Staff
            ['name' => 'Staff', 'slug' => 'staff.index', 'visible_in_menu' => '1', 'module_id' => '5'],
            ['name' => 'Create Staff', 'slug' => 'staff.create', 'visible_in_menu' => '0', 'module_id' => '5'],
            ['name' => 'View Staff', 'slug' => 'staff.show', 'visible_in_menu' => '0', 'module_id' => '5'],
            ['name' => 'Edit Staff', 'slug' => 'staff.edit', 'visible_in_menu' => '0', 'module_id' => '5'],
            ['name' => 'Delete Staff', 'slug' => 'staff.destroy', 'visible_in_menu' => '0', 'module_id' => '5'],

            // Clients
            ['name' => 'Clients', 'slug' => 'clients.index', 'visible_in_menu' => '1', 'module_id' => '6'],
            ['name' => 'Create Client', 'slug' => 'clients.create', 'visible_in_menu' => '0', 'module_id' => '6'],
            ['name' => 'View Client', 'slug' => 'clients.show', 'visible_in_menu' => '0', 'module_id' => '6'],
            ['name' => 'Edit Client', 'slug' => 'clients.edit', 'visible_in_menu' => '0', 'module_id' => '6'],
            ['name' => 'Delete Client', 'slug' => 'clients.destroy', 'visible_in_menu' => '0', 'module_id' => '6'],

            // Patients
            ['name' => 'Patients', 'slug' => 'patients.index', 'visible_in_menu' => '1', 'module_id' => '6'],
            ['name' => 'Create Patient', 'slug' => 'patients.create', 'visible_in_menu' => '0', 'module_id' => '6'],
            ['name' => 'View Patient', 'slug' => 'patients.show', 'visible_in_menu' => '0', 'module_id' => '6'],
            ['name' => 'Edit Patient', 'slug' => 'patients.edit', 'visible_in_menu' => '0', 'module_id' => '6'],
            ['name' => 'Delete Patient', 'slug' => 'patients.destroy', 'visible_in_menu' => '0', 'module_id' => '6'],

            // Quotations
            ['name' => 'Quotations', 'slug' => 'quotations.index', 'visible_in_menu' => '1', 'module_id' => '8'],
            ['name' => 'Create Quotation', 'slug' => 'quotations.create', 'visible_in_menu' => '0', 'module_id' => '8'],
            ['name' => 'View Quotation', 'slug' => 'quotations.show', 'visible_in_menu' => '0', 'module_id' => '8'],
            ['name' => 'Edit Quotation', 'slug' => 'quotations.edit', 'visible_in_menu' => '0', 'module_id' => '8'],
            ['name' => 'Delete Quotation', 'slug' => 'quotations.destroy', 'visible_in_menu' => '0', 'module_id' => '8'],

            // Invoices
            ['name' => 'Invoices', 'slug' => 'invoices.index', 'visible_in_menu' => '1', 'module_id' => '8'],
            ['name' => 'Create Invoice', 'slug' => 'invoices.create', 'visible_in_menu' => '0', 'module_id' => '8'],
            ['name' => 'View Invoice', 'slug' => 'invoices.show', 'visible_in_menu' => '0', 'module_id' => '8'],
            ['name' => 'Edit Invoice', 'slug' => 'invoices.edit', 'visible_in_menu' => '0', 'module_id' => '8'],
            ['name' => 'Delete Invoice', 'slug' => 'invoices.destroy', 'visible_in_menu' => '0', 'module_id' => '8'],

            // Credit Notes
            ['name' => 'Credit Notes', 'slug' => 'credit-notes.index', 'visible_in_menu' => '1', 'module_id' => '8'],
            ['name' => 'Create Credit Note', 'slug' => 'credit-notes.create', 'visible_in_menu' => '0', 'module_id' => '8'],
            ['name' => 'View Credit Note', 'slug' => 'credit-notes.show', 'visible_in_menu' => '0', 'module_id' => '8'],
            ['name' => 'Edit Credit Note', 'slug' => 'credit-notes.edit', 'visible_in_menu' => '0', 'module_id' => '8'],
            ['name' => 'Delete Credit Note', 'slug' => 'credit-notes.destroy', 'visible_in_menu' => '0', 'module_id' => '8'],

            // Refunds
            ['name' => 'Refunds', 'slug' => 'refunds.index', 'visible_in_menu' => '1', 'module_id' => '8'],
            ['name' => 'Create Refund', 'slug' => 'refunds.create', 'visible_in_menu' => '0', 'module_id' => '8'],
            ['name' => 'View Refund', 'slug' => 'refunds.show', 'visible_in_menu' => '0', 'module_id' => '8'],
            ['name' => 'Edit Refund', 'slug' => 'refunds.edit', 'visible_in_menu' => '0', 'module_id' => '8'],
            ['name' => 'Delete Refund', 'slug' => 'refunds.destroy', 'visible_in_menu' => '0', 'module_id' => '8'],

            // Jobs
            ['name' => 'Jobs', 'slug' => 'jobs.index', 'visible_in_menu' => '1', 'module_id' => '9'],
            ['name' => 'Create Job', 'slug' => 'jobs.create', 'visible_in_menu' => '0', 'module_id' => '9'],
            ['name' => 'View Job', 'slug' => 'jobs.show', 'visible_in_menu' => '0', 'module_id' => '9'],
            ['name' => 'Edit Job', 'slug' => 'jobs.edit', 'visible_in_menu' => '0', 'module_id' => '9'],
            ['name' => 'Delete Job', 'slug' => 'jobs.destroy', 'visible_in_menu' => '0', 'module_id' => '9'],

            // Caregivers
            ['name' => 'Caregivers', 'slug' => 'caregivers.index', 'visible_in_menu' => '1', 'module_id' => '7'],
            ['name' => 'Create Caregiver', 'slug' => 'caregivers.create', 'visible_in_menu' => '0', 'module_id' => '7'],
            ['name' => 'View Caregiver', 'slug' => 'caregivers.show', 'visible_in_menu' => '0', 'module_id' => '7'],
            ['name' => 'Edit Caregiver', 'slug' => 'caregivers.edit', 'visible_in_menu' => '0', 'module_id' => '7'],
            ['name' => 'Delete Caregiver', 'slug' => 'caregivers.destroy', 'visible_in_menu' => '0', 'module_id' => '7'],

            // Client Payments
            ['name' => 'Client Payments', 'slug' => 'client-payments.index', 'visible_in_menu' => '1', 'module_id' => '8'],
            ['name' => 'Create Client Payment', 'slug' => 'client-payments.create', 'visible_in_menu' => '0', 'module_id' => '8'],
            ['name' => 'View Client Payment', 'slug' => 'client-payments.show', 'visible_in_menu' => '0', 'module_id' => '8'],
            ['name' => 'Edit Client Payment', 'slug' => 'client-payments.edit', 'visible_in_menu' => '0', 'module_id' => '8'],
            ['name' => 'Delete Client Payment', 'slug' => 'client-payments.destroy', 'visible_in_menu' => '0', 'module_id' => '8'],

            // Overtimes
            ['name' => 'Overtimes', 'slug' => 'overtimes.index', 'visible_in_menu' => '1', 'module_id' => '5'],
            ['name' => 'Create Overtime', 'slug' => 'overtimes.create', 'visible_in_menu' => '0', 'module_id' => '5'],
            ['name' => 'View Overtime', 'slug' => 'overtimes.show', 'visible_in_menu' => '0', 'module_id' => '5'],
            ['name' => 'Edit Overtime', 'slug' => 'overtimes.edit', 'visible_in_menu' => '0', 'module_id' => '5'],
            ['name' => 'Delete Overtime', 'slug' => 'overtimes.destroy', 'visible_in_menu' => '0', 'module_id' => '5'],

            // Service Receipts
            ['name' => 'Service Receipts', 'slug' => 'service-receipts.index', 'visible_in_menu' => '1', 'module_id' => '8'],
            ['name' => 'Create Service Receipt', 'slug' => 'service-receipts.create', 'visible_in_menu' => '0', 'module_id' => '8'],
            ['name' => 'View Service Receipt', 'slug' => 'service-receipts.show', 'visible_in_menu' => '0', 'module_id' => '8'],
            ['name' => 'Edit Service Receipt', 'slug' => 'service-receipts.edit', 'visible_in_menu' => '0', 'module_id' => '8'],
            ['name' => 'Delete Service Receipt', 'slug' => 'service-receipts.destroy', 'visible_in_menu' => '0', 'module_id' => '8'],

            // Prepaid Tracker
            //['name' => 'Prepaid Tracker', 'slug' => 'prepaid-tracker.index', 'visible_in_menu' => '1', 'module_id' => '9']
        ];

        foreach ($permissions as $perm) {
            Permission::updateOrCreate(
                ['name' => $perm['name']],
                [
                    'slug' => $perm['slug'],
                    'visible_in_menu' => $perm['visible_in_menu'] ?? 0,
                    'module_id' => $perm['module_id']
                ]
            );
        }
    }
}
