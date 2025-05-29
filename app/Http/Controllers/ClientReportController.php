<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;

class ClientReportController extends Controller
{
    public function index()
    {
       $totalClients = Client::count(); 
       return view('client-report', compact('totalClients'));
    }
}
