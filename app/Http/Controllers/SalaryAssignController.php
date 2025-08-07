<?php

namespace App\Http\Controllers;

use Spatie\Permission\Middleware\PermissionMiddleware;
use Illuminate\Http\Request;

class SalaryAssignController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', PermissionMiddleware::class . ':View Salary Assign'])->only(['index', 'show', 'fetchSalaryAssign']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Create Salary Assign'])->only(['create', 'store']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Edit Salary Assign'])->only(['edit', 'update']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Delete Salary Assign'])->only(['destroy']);
    }
}
