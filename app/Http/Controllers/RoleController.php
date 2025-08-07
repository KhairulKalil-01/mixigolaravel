<?php

namespace App\Http\Controllers;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Module;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function index()
    {
        //exclude superadmin
        //$roles = Role::where('id', '!=', 1)->get();
        $roles = Role::all();
        return view('roles.index', compact('roles'));
    }

    public function fetchRoles(Request $request)
    {
        //exclude superadmin
        //$roles = Role::where('id', '!=', 1)->get();
        $roles = Role::all();

        return response()->json([
            'data' => $roles
        ]);
    }

    public function create()
    {
        // Only superadmin can create role
        if (!Auth::check() || !Auth::user()->hasRole('superadmin')) {
            abort(403, 'Contact superadmin to complete the task.');
        }

        $modules = Module::with('permissions')->get();
        return view('roles.create', compact('modules'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:roles,name',
            'guard_name' => 'required|string',
            'permissions' => 'required|array',
        ]);

        // Create new role
        $role = Role::create([
            'name' => $validated['name'],
            'guard_name' => $validated['guard_name'],
        ]);

        // Assign selected permissions
        $permissionNames = Permission::whereIn('id', $validated['permissions'])->pluck('name')->toArray();
        $role->syncPermissions($permissionNames);

        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    public function show(Role $role)
    {
        $modules = Module::with('permissions')->get();

        return view('roles.show', compact('role', 'modules'));
    }

    public function edit(Role $role)
    {
        // Prevent from editing superadmin role from direct url
       /*  if ($role->id == 1) {
            abort(403, 'Unauthorized action.');
        } */

        // only superadmin can create role
        if (!Auth::check() || !Auth::user()->hasRole('superadmin')) {
            abort(403, 'Contact superadmin to complete the task.');
        }

        $modules = Module::with('permissions')->get();
        $rolePermissions = $role->permissions->pluck('id')->toArray();

        return view('roles.edit', compact('role', 'modules', 'rolePermissions'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'permissions' => 'required|array',
        ]);

        $role->update(['name' => $request->name]);

        // Convert IDs to names
        $permissionNames = Permission::whereIn('id', $request->permissions)->pluck('name')->toArray();

        $role->syncPermissions($permissionNames);

        return redirect()->route('roles.index')->with('success', 'Role updated');
    }

    public function destroy(Role $role)
    {
        // Prevent from deleting superadmin role
        if ($role->id == 1) {
            abort(403, 'Unauthorized action.');
        }

        // Only superadmin can delete roles
        if (!Auth::check() || !Auth::user()->hasRole('superadmin')) {
            abort(403, 'Contact superadmin to complete the task.');
        }

        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Role deleted');
    }
}
