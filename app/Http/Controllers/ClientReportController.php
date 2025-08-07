<?php

namespace App\Http\Controllers;

use Spatie\Permission\Middleware\PermissionMiddleware;
use Illuminate\Http\Request;
use App\Models\Client;

class ClientReportController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', PermissionMiddleware::class . ':Client Report']);
    }

    public function index()
    {
        $totalClients = Client::count();
        return view('client-report', compact('totalClients'));
    }
}
