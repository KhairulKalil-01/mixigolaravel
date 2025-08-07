<?php

namespace App\Http\Controllers;

use Spatie\Permission\Middleware\PermissionMiddleware;
use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', PermissionMiddleware::class . ':View Branch'])->only(['index', 'show', 'fetchBranches']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Create Branch'])->only(['create', 'store']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Edit Branch'])->only(['edit', 'update']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Delete Branch'])->only(['destroy']);
    }

    public function index()
    {
        $branches = Branch::all();
        return view('branches.index', compact('branches'));
    }

    public function fetchBranches(Request $request)
    {
        $branches = Branch::all();

        return response()->json([
            'data' => $branches
        ]);
    }

    public function create()
    {
        return view('branches.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'branch_name' => 'required|string|max:225',
            'email' => 'nullable|email|max:225',
            'city' => 'required|string|max:225',
            'state' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'mobileno' => 'nullable|string|max:20',
        ]);

        Branch::create($validated);
        return redirect()->route('branches.index')->with('success', 'Branch created.');
    }

    public function show(string $id)
    {
        $branch = Branch::findOrFail($id);
        return view('branches.show', compact('branch'));
    }


    public function edit(string $id)
    {
        $branch = Branch::findOrFail($id);
        return view('branches.edit', compact('branch'));
    }

    public function update(Request $request, Branch $branch)
    {
        $validated = $request->validate([
            'branch_name' => 'required|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'mobileno' => 'nullable|string|max:20',
            'email' => 'nullable|string|max:255',
        ]);

        $branch->update($validated);

        return redirect()->route('branches.index')->with('success', 'Branch updated.');
    }

    public function destroy(string $id)
    {
        $branch = Branch::findOrFail($id);
        $branch->delete();

        return response()->json(['message' => 'Branch deleted successfully.']);
    }
}
