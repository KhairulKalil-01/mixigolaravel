<?php

namespace App\Http\Controllers;

use Spatie\Permission\Middleware\PermissionMiddleware;
use App\Models\Staff;
use App\Models\Branch;
use App\Models\Department;
use Illuminate\Http\Request;

class StaffController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', PermissionMiddleware::class . ':View Staff'])->only(['index', 'show', 'fetchStaff']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Create Staff'])->only(['create', 'store']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Edit Staff'])->only(['edit', 'update']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Delete Staff'])->only(['destroy']);
    }


    public function index()
    {
        return view('staff.index');
    }

    public function fetchStaff()
    {
        $staff = Staff::with('branch')->get()->map(function ($staff) {
            return [
                'id' => $staff->id,
                'full_name' => $staff->full_name,
                'branch_name' => $staff->branch->branch_name ?? ''
            ];
        });
        return response()->json([
            'data' => $staff
        ]);
    }

    public function create()
    {
        $departments = Department::all();
        $branches = Branch::all();
        return view('staff.create', compact('branches', 'departments'));
    }

    public function store(Request $request)
    {
        $rules = [
            'full_name' => 'required|string|max:255',
            'sex' => 'required|in:1,2',
            'religion' => 'nullable|string|max:50',
            'marital_status' => 'nullable|string|max:50',
            'department_id' => 'required|exists:departments,id',
            'branch_id' => 'required|exists:branches,id',
            'joining_date' => 'required|date',
            'ic_num' => 'required|string|max:15',
            'passport' => 'nullable|string|max:255',
            'emergency_contact' => 'nullable|string|max:255',
            'emergency_phone_no' => 'nullable|string|max:225',
            'mobileno'  => 'nullable|string|max:15',
            'permanent_address' => 'nullable|string|max:255',
            'present_address' => 'nullable|string|max:255',
        ];

        /* // If current user is admin, allow login credentials creation
        if (auth()->user()->hasAnyRole(['admin', 'superadmin'])) {
            $rules = array_merge($rules, [
                'name'     => 'required|string|max:255|unique:users,name',
                'email'    => 'required|email|max:255|unique:users,email',
                'password' => 'required|string|min:8',
            ]);
        } */

        $validated = $request->validate($rules);

        // Create staff record
        $staff = Staff::create([
            'full_name' => $validated['full_name'],
            'sex' => $validated['sex'],
            'religion' => $validated['religion'] ?? null,
            'marital_status' => $validated['marital_status'] ?? null,
            'department_id' => $validated['department_id'],
            'branch_id' => $validated['branch_id'],
            'joining_date' => $validated['joining_date'],
            'ic_num' => $validated['ic_num'],
            'passport' => $validated['passport'] ?? null,
            'emergency_contact' => $validated['emergency_contact'] ?? null,
            'emergency_phone_no' => $validated['emergency_phone_no'] ?? null,
            'mobileno' => $validated['mobileno'] ?? null,
            'permanent_address' => $validated['permanent_address'] ?? null,
            'present_address' => $validated['present_address'] ?? null,
        ]);

        // If admin, also create user account
        /* if (auth()->user()->hasAnyRole(['admin', 'superadmin'])) {
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        $staff->user_id = $user->id;
        $staff->save();
    } */

        return redirect()->route('staff.index')->with('success', 'Staff created successfully.');
    }

    public function show(string $id)
    {
        $staff = Staff::findOrFail($id);
        return view('staff.show', compact('staff'));
    }

    public function edit(string $id)
    {
        $staff = Staff::findOrFail($id);
        $departments = Department::all();
        $branches = Branch::all();
        return view('staff.edit', compact('staff', 'branches', 'departments'));
    }

    public function update(Request $request, string $id)
    {
        $staff = Staff::findOrFail($id);

        // Common staff fields validation
        $rules = [
            'full_name' => 'required|string|max:255',
            'sex' => 'required|in:1,2',
            'religion' => 'nullable|string|max:50',
            'marital_status' => 'nullable|string|max:50',
            'department_id' => 'required|exists:departments,id',
            'branch_id' => 'required|exists:branches,id',
            'joining_date' => 'required|date',
            'ic_num' => 'required|string|max:15',
            'passport' => 'nullable|string|max:255',
            'emergency_contact' => 'nullable|string|max:255',
            'emergency_phone_no' => 'nullable|string|max:225',
            'mobileno'  => 'nullable|string|max:15',
            'permanent_address' => 'nullable|string|max:255',
            'present_address' => 'nullable|string|max:255',
        ];

        /*  // If current user is admin, allow login credentials update
        if (auth()->user()->hasAnyRole(['admin', 'superadmin'])) {
            $rules = array_merge($rules, [
                'name'     => 'required|string|max:255|unique:users,name,' . $staff->user_id,
                'email'    => 'required|email|max:255|unique:users,email,' . $staff->user_id,
                'password' => 'nullable|string|min:8',
            ]);
        } */

        $validated = $request->validate($rules);

        // Update staff details
        $staff->update([
            'full_name' => $validated['full_name'],
            'sex' => $validated['sex'],
            'religion' => $validated['religion'] ?? null,
            'marital_status' => $validated['marital_status'] ?? null,
            'department_id' => $validated['department_id'],
            'branch_id' => $validated['branch_id'],
            'joining_date' => $validated['joining_date'],
            'ic_num' => $validated['ic_num'] ?? null,
            'emergency_contact' => $validated['emergency_contact'] ?? null,
            'emergency_phone_no' => $validated['emergency_phone_no'] ?? null,
            'passport' => $validated['passport'] ?? null,
            'mobileno' => $validated['mobileno'] ?? null,
            'permanent_address' =>  $validated['permanent_address'] ?? null,
            'present_address' => $validated['present_address'] ?? null,
        ]);

        // If admin, update user credentials
        /* if (auth()->user()->hasAnyRole(['admin', 'superadmin']) && $staff->user) {
            $staff->user->name  = $validated['name'];
            $staff->user->email = $validated['email'];

            if (!empty($validated['password'])) {
                $staff->user->password = bcrypt($validated['password']);
            }

            $staff->user->save();
        } */

        return redirect()->route('staff.index')->with('success', 'Staff updated successfully.');
    }

    public function destroy(string $id)
    {
        //
    }
}
