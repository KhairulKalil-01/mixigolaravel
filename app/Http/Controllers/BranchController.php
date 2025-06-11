<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    /*  public function __construct()
    {
        $this->middleware('permission: Branches')->only('index');
        $this->middleware('permission: Create Branch')->only('create', 'store');
        $this->middleware('permission: View Branch')->only('show');
        $this->middleware('permission: Edit Branch')->only('edit', 'update');
        $this->middleware('permission: Delete Branch')->only('destroy');
    }
 */

    /**
     * Display a listing of the resource.
     */
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('branches.create');
    }

    /**
     * Store a newly created resource in storage.
     */
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('branches.edit', compact('branch'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Branch $branch)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'mobileno' => 'nullable|string|max:20',
        ]);

        $branch->update($validated);

        return redirect()->route('branches.index')->with('success', 'Branch updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
