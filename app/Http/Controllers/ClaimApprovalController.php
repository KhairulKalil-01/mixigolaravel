<?php

namespace App\Http\Controllers;

use Spatie\Permission\Middleware\PermissionMiddleware;
use App\Models\StaffClaim;
use App\StaffClaimStatus;
use App\ClaimPaymentMethod;
use Illuminate\Http\Request;

class ClaimApprovalController extends Controller
{
    public function __construct()
    {
        //Spaties Permission Middleware
        $this->middleware(['auth', PermissionMiddleware::class . ':View Claim Approval'])->only(['index', 'show', 'fetchClaimsByStaff']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Edit Claim Approval'])->only(['edit', 'update']);
    }

    public function index()
    {
        return view('claim-approvals.index');
    }

    public function fetchClaimApprovals(Request $request)
    {
        $claims = StaffClaim::with('staff')->get()->map(function ($claim) {
            return [
                'id' => $claim->id,
                'staff_name' => $claim->staff->full_name,
                'claim_type' => $claim->claim_type,
                'amount' => $claim->amount,
                'approved_amount' => $claim->approved_amount ?? 'N/A',
                'status' => $claim->status_label,
                'payment_method' => $claim->payment_method_label,
            ];
        });
        return response()->json(['data' => $claims]);
    }

    public function show($id)
    {
        $staffClaim = StaffClaim::with('staff')->findOrFail($id);
        return view('claim-approvals.show', compact('staffClaim'));
    }

    public function edit($id)
    {
        $statuses = StaffClaimStatus::cases();
        $paymentMethods = ClaimPaymentMethod::cases();
        $staffClaim = StaffClaim::with('staff')->findOrFail($id);
        return view('claim-approvals.edit', compact('staffClaim', 'statuses', 'paymentMethods'));
    }

    public function update(Request $request, $id)
    {
        $staffClaim = StaffClaim::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:' . implode(',', array_map(fn($case) => $case->value, StaffClaimStatus::cases())),
            'payment_method' => 'required|in:' . implode(',', array_map(fn($case) => $case->value, ClaimPaymentMethod::cases())),
            'approved_amount' => 'required|numeric|min:0',
            'remarks' => 'nullable|string',
        ]);

        $staffClaim->update([
            'status' => $validated['status'],
            'payment_method' => $validated['payment_method'],
            'approved_amount' => $validated['approved_amount'],
            'remarks' => $validated['remarks'],
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return redirect()->route('claim-approvals.index')->with('success', 'Claim updated successfully!');
    }
}
