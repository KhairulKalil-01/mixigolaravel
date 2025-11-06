<?php

namespace App\Http\Controllers;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Illuminate\Http\Request;

class CaregiverPaymentController extends Controller
{
    public function __construct()
    {
        //Spaties Permission Middleware
        $this->middleware(['auth', PermissionMiddleware::class . ':View Caregiver Payment'])->only(['index', 'show', 'downloadPdf', 'fetchCaregiverPayment']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Create Caregiver Payment'])->only(['create', 'store']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Edit Caregiver Payment'])->only(['edit', 'update']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Delete Caregiver Payment'])->only(['destroy']);
    }
}
