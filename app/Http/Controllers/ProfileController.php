<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $staff = $user->staff;

        $validated = $request->validate([
            // staff fields
            'present_address' => 'nullable|string|max:255',
            'permanent_address' => 'nullable|string|max:255',
            'mobileno' => 'nullable|string|max:15',
            'emergency_contact' => 'required|string|max:255',
            'emergency_phone_no' => 'required|string|max:20',
            'passport' => 'nullable|string|max:255',

            // user fields
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        // Update staff info
        if ($staff) {
            $staff->update([
                'present_address' => $validated['present_address'] ?? $staff->present_address,
                'permanent_address' => $validated['permanent_address'] ?? $staff->permanent_address,
                'mobileno' => $validated['mobileno'] ?? $staff->mobileno,
                'emergency_contact' => $validated['emergency_contact'] ?? $staff->emergency_contact,
                'emergency_phone_no' => $validated['emergency_phone_no'] ?? $staff->emergency_phone_no,
                'passport' => $validated['passport'] ?? $staff->passport,
            ]);
        }

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully!');
    }
}
