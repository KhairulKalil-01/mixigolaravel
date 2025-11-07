<?php

namespace App\Http\Controllers;

use Spatie\Permission\Middleware\PermissionMiddleware;
use App\Models\CommissionClaim;
use App\CommissionClaimStatus;
use Illuminate\Http\Request;

class CommissionApprovalController extends Controller
{
    public function __construct()
    {
        //Spaties Permission Middleware
        $this->middleware(['auth', PermissionMiddleware::class . ':View Commission Approval'])->only(['index', 'show']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Edit Commission Approval'])->only(['edit', 'update']);
    }

    public function index()
    {
        return view('commission-approvals.index');
    }

    public function show(CommissionClaim $commission_approval)
    {
        return view('commission-approvals.show', compact('commission_approval'));
    }

    public function edit(CommissionClaim $commission_approval)
    {
        $statuses = CommissionClaimStatus::cases();
        return view('commission-approvals.edit', compact('commission_approval', 'statuses'));
    }

    public function update(Request $request, CommissionClaim $commission_approval)
    {
        $validated = $request->validate([
            'status' => 'required|in:' . implode(',', array_map(fn($case) => $case->value, CommissionClaimStatus::cases())),
            'approval_remarks' => 'nullable|string',
        ]);

        $commission_approval->update([
            'status' => $validated['status'],
            'approval_remarks' => $validated['approval_remarks'] ?? null,
        ]);

        return redirect()->route('commission-approvals.index')->with('success', 'Commission claim status updated successfully.');
    }
}
