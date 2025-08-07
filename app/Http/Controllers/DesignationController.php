<?php

namespace App\Http\Controllers;

use Spatie\Permission\Middleware\PermissionMiddleware;
use App\Models\Designation;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', PermissionMiddleware::class . ':View Designation'])->only(['index', 'show', 'fetchDesignations']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Create Designation'])->only(['create', 'store']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Edit Designation'])->only(['edit', 'update']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Delete Designation'])->only(['destroy']);
    }

    public function index()
    {
        $designations = Designation::all();
        return view('designations.index', compact('designations'));
    }

    public function fetchDesignations(Request $request)
    {
        $designations = Designation::all();

        return response()->json([
            'data' => $designations
        ]);
    }

    public function create()
    {
        return view('designations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'designation_name' => 'required|string|max:225'
        ]);

        Designation::create($validated);
        return redirect()->route('designations.index')->with('success', 'Designation created.');
    }

    public function show(string $id)
    {
        $designation = Designation::findOrFail($id);
        return view('designations.show', compact('designation'));
    }


    public function edit(string $id)
    {
        $designation = Designation::findOrFail($id);
        return view('designations.edit', compact('designation'));
    }


    public function update(Request $request, Designation $designation)
    {
        $validated = $request->validate([
            'designation_name' => 'required|string|max:255'
        ]);

        $designation->update($validated);

        return redirect()->route('designations.index')->with('success', 'Designation updated.');
    }

    public function destroy(string $id)
    {
        $designation = Designation::findOrFail($id);
        $designation->delete();

        return response()->json(['message' => 'Designation deleted successfully.']);
    }
}
