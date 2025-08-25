<?php

use Spatie\Permission\Middleware\PermissionMiddleware;
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
use App\Http\Controllers\CreditNoteController;
use App\Http\Controllers\RefundController;
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
use Spatie\Permission\Contracts\Permission;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/', function () {
    return redirect()->route('login');
});

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
Route::post('fetch-users', [UserController::class, 'fetchUser'])->name('users.fetch');

// Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

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
Route::resource('caregiver-payments', CaregiverPaymentController::class);
Route::resource('overtimes', OvertimeController::class);

// Staff
Route::resource('staff', StaffController::class);
Route::post('fetch-staff', [StaffController::class, 'fetchStaff'])->name('staff.fetch');


// Invoices
Route::resource('invoices', InvoiceController::class);
Route::post('fetch-invoices', [InvoiceController::class, 'fetchInvoice'])->name('invoices.fetch');
Route::get('/invoices/{invoice}/download-pdf', [InvoiceController::class, 'downloadPdf'])->name('invoices.download_pdf');

// Credit Notes
Route::resource('credit-notes', CreditNoteController::class);
Route::post('fetch-credit-notes', [CreditNoteController::class, 'fetchCreditNote'])->name('credit-notes.fetch');
Route::get('/credit-notes/{credit_note}/download-pdf', [CreditNoteController::class, 'downloadPdf'])->name('credit-notes.download_pdf');

// Refunds
Route::resource('refunds', RefundController::class);
Route::post('fetch-refunds', [RefundController::class, 'fetchRefund'])->name('refunds.fetch');
Route::get('/refunds/{refund}/download-pdf', [RefundController::class, 'downloadPdf'])->name('refunds.download_pdf');
//Route::get('refunds', [RefundController::class, 'index'])->name('refunds.index')->middleware(['auth', PermissionMiddleware::class . ':View Salary Record']);

Route::resource('jobs', JobController::class);

// Client Payments
Route::resource('client-payments', ClientPaymentController::class);
Route::post('fetch-client-payments', [ClientPaymentController::class, 'fetchClientPayment'])->name('client-payments.fetch');
Route::get('/client-payments/{client_payment}/download-pdf', [ClientPaymentController::class, 'downloadPdf'])->name('client-payments.download_pdf');

Route::resource('service-receipts', ServiceReceiptController::class);

// Client
Route::resource('clients', ClientController::class);
Route::post('fetch-clients', [ClientController::class, 'fetchClient'])->name('clients.fetch');

// Patient
Route::resource('patients', PatientController::class);
Route::post('fetch-patients', [PatientController::class, 'fetchPatient'])->name('patients.fetch');

// Quotations
Route::resource('quotations', QuotationController::class);
Route::post('fetch-quotations', [QuotationController::class, 'fetchQuotation'])->name('quotations.fetch');
Route::get('/quotations/{quotation}/download-pdf', [QuotationController::class, 'downloadPdf'])->name('quotations.download_pdf');

// Caregivers
Route::resource('caregivers', CaregiverController::class);
Route::post('fetch-caregivers', [CaregiverController::class, 'fetchCaregiver'])->name('caregivers.fetch');
