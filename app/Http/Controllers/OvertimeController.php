<?php

namespace App\Http\Controllers;

use Spatie\Permission\Middleware\PermissionMiddleware;
use Illuminate\Http\Request;

class OvertimeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', PermissionMiddleware::class . ':View Overtime'])->only(['index', 'show', 'downloadPdf', 'fetchOvertime']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Create Overtime'])->only(['create', 'store']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Edit Overtime'])->only(['edit', 'update']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Delete Overtime'])->only(['destroy']);
    }
}
