<?php

namespace App\Http\Controllers;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Illuminate\Http\Request;

class SalaryRecordController extends Controller
{
    public function __construct()
    {
        //Spaties Permission Middleware
        $this->middleware(['auth', PermissionMiddleware::class . ':View Salary Record'])->only(['index', 'show', 'downloadPdf', 'fetchSalaryRecord']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Create Salary Record'])->only(['create', 'store']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Edit Salary Record'])->only(['edit', 'update']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Delete Salary Record'])->only(['destroy']);
    }
}
