<?php

namespace App\Http\Controllers;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Illuminate\Http\Request;

class SalaryReportController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', PermissionMiddleware::class . ':Salary Report']);
    }
}
