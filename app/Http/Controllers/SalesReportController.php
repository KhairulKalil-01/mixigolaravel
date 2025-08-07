<?php

namespace App\Http\Controllers;

use Spatie\Permission\Middleware\PermissionMiddleware;
use Illuminate\Http\Request;

class SalesReportController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', PermissionMiddleware::class . ':Sales Report']);
    }

    public function index()
    {
        return view('reports.sales', compact('sales'));
    }
}
