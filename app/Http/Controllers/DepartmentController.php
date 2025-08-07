<?php

namespace App\Http\Controllers;

use Spatie\Permission\Middleware\PermissionMiddleware;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', PermissionMiddleware::class . ':View Department'])->only(['index', 'show', 'fetchDepartments']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Create Department'])->only(['create', 'store']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Edit Department'])->only(['edit', 'update']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Delete Department'])->only(['destroy']);
    }


    public function index()
    {
        $departments = Department::all();
        return view('departments.index', compact('departments'));
    }

    public function fetchDepartments(Request $request)
    {
        $departments = Department::all();

        return response()->json([
            'data' => $departments
        ]);
    }

    public function create()
    {
        return view('departments.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'department_name' => 'required|string|max:225'
        ]);

        Department::create($validated);
        return redirect()->route('departments.index')->with('success', 'Department created.');
    }


    public function show(string $id)
    {
        $department = Department::findOrFail($id);
        return view('departments.show', compact('department'));
    }


    public function edit(string $id)
    {
        $department = Department::findOrFail($id);
        return view('departments.edit', compact('department'));
    }

    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'department_name' => 'required|string|max:255'
        ]);

        $department->update($validated);

        return redirect()->route('departments.index')->with('success', 'Department updated.');
    }

    public function destroy(string $id)
    {
        $department = Department::findOrFail($id);
        $department->delete();

        return response()->json(['message' => 'Department deleted successfully.']);
    }
}
