<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::all();
        return view('patients.index', compact('patients'));
    }

    public function fetchPatient(Request $request)
    {
        $patients = Patient::all();

        return response()->json([
            'data' => $patients
        ]);
    }

    public function create()
    {
        $clients = Client::all();

        return view('patients.create', compact('clients'));
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

        Patient::create($validated);

        return redirect()->route('patients.index')->with('success', 'Patient created successfully.');
    }

    public function show(Patient $patient)
    {
        $patient->load('clients');

        return view('patients.show', compact('patient'));
    }

    public function edit(Patient $patient)
    {
        $clients = Client::all(); // Get all clients
        $clientPatientIds = $patient->clients->pluck('id')->toArray();

        return view('patients.edit', compact('patient', 'clients', 'clientPatientIds'));
    }

    public function update(Request $request, Patient $patient)
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
            'clients' => 'nullable|array',
        ]);

        $patient->update(collect($validated)->except('clients')->toArray());

        if ($request->has('clients')) {
            $patient->clients()->sync($request->clients); // Update the pivot table
        } else {
            // If no patients selected, detach all
            $patient->clients()->detach();
        }

        return redirect()->route('patients.index')->with('success', 'Patient updated successfully.');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();

        return redirect()->route('patients.index')->with('success', 'Patient deleted successfully.');
    }
}
