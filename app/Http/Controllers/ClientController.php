<?php

namespace App\Http\Controllers;

use Spatie\Permission\Middleware\PermissionMiddleware;
use App\Models\Client;
use App\Models\Patient;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function __construct()
    {
        //Spaties Permission Middleware
        $this->middleware(['auth', PermissionMiddleware::class . ':View Client'])->only(['index', 'show', 'fetchClient']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Create Client'])->only(['create', 'store']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Edit Client'])->only(['edit', 'update']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Delete Client'])->only(['destroy']);
    }

    public function index()
    {
        $clients = Client::all();
        return view('clients.index', compact('clients'));
    }

    public function fetchClient(Request $request)
    {
        $clients = Client::with('patients')->get();

        return response()->json([
            'data' => $clients
        ]);
    }

    public function create()
    {
        $patients = Patient::all();

        return view('clients.create', compact('patients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'ic_num' => 'nullable|string|max:255',
            'sex' => 'required|string|max:255',
            'mobileno' => 'required|string|max:20',
            'email' => 'nullable|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        Client::create($validated);

        return redirect()->route('clients.index')->with('success', 'Client created successfully.');
    }

    public function show(Client $client)
    {
        $client->load('patients');

        return view('clients.show', compact('client'));
    }

    public function edit(Client $client)
    {
        $patients = Patient::all(); // Get all patients
        $clientPatientIds = $client->patients->pluck('id')->toArray();

        return view('clients.edit', compact('client', 'patients', 'clientPatientIds'));
    }

    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'ic_num' => 'nullable|string|max:255',
            'mobileno' => 'required|string|max:20',
            'email' => 'nullable|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'is_active' => 'nullable|boolean',
            'patients' => 'array',
        ]);

        $client->update(collect($validated)->except('patients')->toArray());

        if ($request->has('patients')) {
            $client->patients()->sync($request->patients); // Update the pivot table
        } else {
            // If no patients selected, detach all
            $client->patients()->detach();
        }

        return redirect()->route('clients.index')->with('success', 'Client updated successfully.');
    }

    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()->route('clients.index')->with('success', 'Client deleted successfully.');
    }
}
