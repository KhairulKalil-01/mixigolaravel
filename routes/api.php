<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PrepaidRecordController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\CaregiverController;
use App\Http\Controllers\ServiceJobController;


// Group all API routes that require authentication
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Clients (for dropdown)
    Route::get('/clients', [ClientController::class, 'getClients']);

    // Invoices for a client (includes quotation + items)
    Route::get('/client/{id}/invoices', [InvoiceController::class, 'getInvoices']);

    // Prepaids for an invoice
    Route::get('/invoice/{id}/prepaids', [PrepaidRecordController::class, 'getPrepaids']);

    // Patients for a client
    Route::get('/client/{id}/patients', [PatientController::class, 'getPatients']);

    // Available caregivers for a timeslot (optional: pass start/end)
    /* Route::get('/caregivers/available', [CaregiverController::class, 'available']); */

    // All caregivers
    Route::get('/caregivers', [CaregiverController::class, 'getCaregivers']);

    // Create job (store)
    Route::post('/jobs', [ServiceJobController::class, 'store']);
});
