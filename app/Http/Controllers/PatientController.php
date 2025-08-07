<?php

namespace App\Http\Controllers;
use Spatie\Permission\Middleware\PermissionMiddleware;
use App\Models\Client;
use App\Models\Patient;
use App\Models\Branch;
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
        $patients = Patient::with('clients')->get();

        return response()->json([
            'data' => $patients
        ]);
    }

    public function create()
    {
        $branches = Branch::all();
        $clients = Client::all();

        return view('patients.create', compact('clients', 'branches'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'branch_id' => 'required|int',
            'ic_num' => 'nullable|string|max:255',
            'age' => 'nullable|int',
            'sex' => 'required|string|max:255',
            'weight' => 'nullable|int',
            'condition_description' => 'nullable|string|max:255',
            'mobileno' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'is_active' => 'nullable|boolean',
            'clients' => 'nullable|array',
        ]);

        $patientData = collect($validated)->except('clients')->toArray();
        $patient = Patient::create($patientData);

        if (!empty($validated['clients'])) {
            $patient->clients()->sync($validated['clients']);
        }

        return redirect()->route('patients.index')->with('success', 'Patient created successfully.');
    }

    public function show(Patient $patient)
    {
        $patient->load(['clients', 'branch']);

        return view('patients.show', compact('patient'));
    }

    public function edit(Patient $patient)
    {
        $branches = Branch::all();
        $clients = Client::all(); // Get all clients
        $clientPatientIds = $patient->clients->pluck('id')->toArray();

        return view('patients.edit', compact('patient', 'clients', 'clientPatientIds', 'branches'));
    }

    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'branch_id' => 'required|int',
            'ic_num' => 'nullable|string|max:255',
            'age' => 'nullable|int',
            'sex' => 'required|string|max:255',
            'weight' => 'nullable|int',
            'condition_description' => 'nullable|string|max:255',
            'mobileno' => 'required|string|max:20',
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

    public function destroy(int $id)
    {
        $patient = Patient::findOrFail($id);
        $patient->delete();
        return response()->json(['success' => true, 'message' => 'Patient deleted successfully.']);
    }
}
