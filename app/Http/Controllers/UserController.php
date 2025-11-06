<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Branch;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        //Spaties Permission Middleware
        $this->middleware(['auth', PermissionMiddleware::class . ':View User'])->only(['index', 'show', 'fetchUser']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Create User'])->only(['create', 'store']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Edit User'])->only(['edit', 'update']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Delete User'])->only(['destroy']);
    }

    public function index()
    {
        return view('users.index');
    }

    public function fetchUser(Request $request)
    {
        $users = User::with('roles:id,name')->get()->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'roles' => $user->roles->pluck('name'),
            ];
        });
        return response()->json([
            'data' => $users
        ]);
    }

    public function show(User $user)
    {
        $user->load(['roles', 'permissions']);

        return view('users.show', compact('user'));
    }


    public function create()
    {
        $roles = Role::all();
        $action = route('users.store');
        $method = 'POST';
        return view('users.create', compact('roles', 'action', 'method'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'roles'    => 'array'
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        if (!empty($validated['roles'])) {
            $user->syncRoles($validated['roles']);
        }

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $action = route('users.update', $user->id);
        $method = 'PUT';
        return view('users.edit', compact('user', 'roles', 'action', 'method'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
            'roles'    => 'array'
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        if (!empty($validated['roles'])) {
            $user->syncRoles($validated['roles']);
        } else {
            $user->syncRoles([]); // remove all roles if none checked
        }

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
