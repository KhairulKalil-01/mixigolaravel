<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\BranchController;
use App\Http\Controllers\CaregiverController;
use App\Http\Controllers\CaregiverPaymentController;
use App\Http\Controllers\CaregiverReportController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ClientPaymentController;
use App\Http\Controllers\ClientReportController;
use App\Http\Controllers\DepartmentController; 
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\EntryQuotationController;
use App\Http\Controllers\EntryWakafController;
use App\Http\Controllers\EntryTrainingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\OperationReportController;
use App\Http\Controllers\OvertimeController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SalaryAssignController;
use App\Http\Controllers\SalaryRecordController;
use App\Http\Controllers\SalaryReportController;
use App\Http\Controllers\SalesReportController;
use App\Http\Controllers\ServicePricingController;
use App\Http\Controllers\ServiceReceiptController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/home-old', [HomeController::class, 'oldindex'])->name('home-old');


Route::get('/home', [HomeController::class, 'index'])->name('home');

// Reports
Route::get('/sales-report', [SalesReportController::class, 'index'])->name('sales-report');
Route::get('/operation-report', [OperationReportController::class, 'index'])->name('operation-report');
Route::get('/caregiver-report', [CaregiverReportController::class, 'index'])->name('caregiver-report');
Route::get('/client-report', [ClientReportController::class, 'index'])->name('client-report');
Route::get('/salary-report', [SalaryReportController::class, 'index'])->name('salary-report');

// Entries
Route::resource('quotation-entries', EntryQuotationController::class)->only(['index', 'show', 'edit', 'destroy']);
Route::resource('wakaf', EntryWakafController::class);
Route::resource('training', EntryTrainingController::class);

// User
Route::resource('users', UserController::class);

// Branches
Route::resource('branches', BranchController::class);
Route::post('/fetch-branches', [BranchController::class, 'fetchBranches'])->name('branches.fetch');

// Departments
Route::resource('departments', DepartmentController::class);
Route::post('/fetch-departments', [DepartmentController::class, 'fetchDepartments'])->name('departments.fetch');

// Designations
Route::resource('designations', DesignationController::class);
Route::post('fetch-designations', [DesignationController::class, 'fetchDesignations'])->name('designations.fetch');

// Roles
Route::resource('roles', RoleController::class);
Route::post('fetch-roles', [RoleController::class, 'fetchRoles'])->name('roles.fetch');

// Route::resource('permissions', PermissionController::class); 

// Service pricings
Route::resource('service-pricings', ServicePricingController::class);
Route::post('fetch-service-pricings', [ServicePricingController::class, 'fetchServicePricings'])->name('service-pricings.fetch');

Route::resource('salary-records', SalaryRecordController::class); 
Route::resource('salary-assign', SalaryAssignController::class);
Route::resource('caregiver-payments',CaregiverPaymentController::class);
Route::resource('overtimes', OvertimeController::class);
Route::resource('invoices', InvoiceController::class);
Route::resource('jobs', JobController::class);
Route::resource('client-payments', ClientPaymentController::class);
Route::resource('service-receipts', ServiceReceiptController::class);

// Client
Route::resource('clients', ClientController::class);
Route::post('fetch-clients', [ClientController::class, 'fetchClient'])->name('clients.fetch');

// Patient
Route::resource('patients', PatientController::class);
Route::post('fetch-patients', [PatientController::class, 'fetchPatient'])->name('patients.fetch');

Route::resource('quotations', QuotationController::class);

// Caregivers
Route::resource('caregivers', CaregiverController::class);
Route::post('fetch-caregivers', [CaregiverController::class, 'fetchCaregiver'])->name('caregivers.fetch');
