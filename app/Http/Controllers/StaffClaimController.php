<?php

namespace App\Http\Controllers;

use Spatie\Permission\Middleware\PermissionMiddleware;
use App\Models\StaffClaim;
use App\Models\Staff;
use App\StaffClaimStatus;
use Illuminate\Http\Request;

class StaffClaimController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', PermissionMiddleware::class . ':View Staff Claim'])->only(['index', 'show', 'fetchClaimsByStaff']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Create Staff Claim'])->only(['create', 'store']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Edit Staff Claim'])->only(['edit', 'update']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Delete Staff Claim'])->only(['destroy']);
    }

    public function index()
    {
        return view('staff-claims.index');
    }

    public function fetchClaimsByStaff(Request $request)
    {
        $staffId = auth()->user()->staff->id;

        $claims = StaffClaim::with('staff:id,full_name')
            ->where('staff_id', $staffId)
            ->get()
            ->map(function ($claim) {
                return [
                    'id' => $claim->id,
                    'staff_name' => $claim->staff->full_name,
                    'claim_type' => $claim->claim_type,
                    'amount' => $claim->amount,
                    'status' => $claim->status_label,
                ];
            });
        return response()->json(['data' => $claims]);
    }

    public function create()
    {
        return view('staff-claims.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'claim_date' => 'required|date',
            'claim_type' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'description' => 'required|string',
            'receipt' => 'nullable|file|mimes:pdf,jpeg,jpg,png|max:2048',
        ]);

        $staffId = Staff::where('user_id', auth()->id())->value('id');

        // Default receipt path is null
        $receiptPath = null;

        if ($request->hasFile('receipt')) {
            // Store in storage/app/public/receipts
            $receiptPath = $request->file('receipt')->store('receipts', 'public');
        }

        StaffClaim::create([
            'staff_id' => $staffId,
            'claim_date' => $request->claim_date,
            'claim_type' => $request->claim_type,
            'amount' => $request->amount,
            'description' => $request->description,
            'receipt_path' => $receiptPath,
        ]);

        return redirect()->route('staff-claims.index')->with('success', 'Staff claim created successfully.');
    }

    public function show(StaffClaim $staffClaim)
    {
        $staffClaim->load('staff:id,full_name');
        return view('staff-claims.show', compact('staffClaim'));
    }


    public function edit(StaffClaim $staffClaim)
    {
        $claim = $staffClaim;
        return view('staff-claims.edit', compact('claim'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StaffClaim $staffClaim)
    {
        $validated = $request->validate([
            'claim_date' => 'required|date',
            'claim_type' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'description' => 'required|string',
            'receipt' => 'nullable|file|mimes:pdf,jpeg,jpg,png|max:2048',
        ]);

        // Keep old path as default
        $receiptPath = $staffClaim->receipt_path;

        if ($request->hasFile('receipt')) {
            // Delete old file if exists
            if ($staffClaim->receipt_path && \Storage::disk('public')->exists($staffClaim->receipt_path)) {
                \Storage::disk('public')->delete($staffClaim->receipt_path);
            }

            // Save new file
            $receiptPath = $request->file('receipt')->store('receipts', 'public');
        }

        $staffClaim->update([
            'claim_date' => $request->claim_date,
            'claim_type' => $request->claim_type,
            'amount' => $request->amount,
            'description' => $request->description,
            'receipt_path' => $receiptPath,
        ]);

        return redirect()->route('staff-claims.index')->with('success', 'Staff claim updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StaffClaim $staffClaim)
    {
        if ($staffClaim->status != 0) { // Not Pending
            return response()->json([
                'success' => false,
                'message' => 'This claim has been approved/paid and cannot be deleted.'
            ], 400); // 400 Bad Request
        }

        // Delete receipt file if it exists
        if ($staffClaim->receipt_path && \Storage::disk('public')->exists($staffClaim->receipt_path)) {
            \Storage::disk('public')->delete($staffClaim->receipt_path);
        }

        $staffClaim->delete();
        return response()->json([
            'success' => true,
            'message' => 'Claim deleted successfully.'
        ], 200);
    }
}
