<?php

namespace App\Http\Controllers;

use Spatie\Permission\Middleware\PermissionMiddleware;
use App\Models\StaffSalaryAdvance;
use App\SalaryAdvanceStatus;
use Illuminate\Http\Request;

class StaffSalaryAdvanceApprovalController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', PermissionMiddleware::class . ':View Staff Advance Approval'])->only(['index', 'show', 'fetchAllStaffAdvances']);
        //$this->middleware(['auth', PermissionMiddleware::class . ':Create Staff Advance Approval'])->only(['create', 'store']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Edit Staff Advance Approval'])->only(['edit', 'update']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Delete Staff Advance Approval'])->only(['destroy']);
    }
    public function index()
    {
        return view('staff-salary-advance-approvals.index');
    }

    public function fetchAllStaffAdvances()
    {

        $advances = StaffSalaryAdvance::with('staff:id,full_name')
            ->get()
            ->map(function ($advance) {
                return [
                    'id' => $advance->id,
                    'staff_name' => $advance->staff->full_name,
                    'amount' => $advance->amount,
                    'status' => $advance->status_label,
                ];
            });
        return response()->json(['data' => $advances]);
    }

    public function show(StaffSalaryAdvance $staff_salary_advance_approval)
    {
        $advance = $staff_salary_advance_approval->load('staff:id,full_name');
        return view('staff-salary-advance-approvals.show', compact('advance'));
    }

    public function edit(StaffSalaryAdvance $staff_salary_advance_approval)
    {
        $statuses = SalaryAdvanceStatus::cases();
        $advance = $staff_salary_advance_approval;
        return view('staff-salary-advance-approvals.edit', compact('advance', 'statuses'));
    }

    public function update(Request $request, StaffSalaryAdvance $staff_salary_advance_approval)
    {
        $validated = $request->validate([
            'status' => 'required|in:' . implode(',', array_map(fn($case) => $case->value, SalaryAdvanceStatus::cases())),
            'approval_remarks' => 'nullable',
        ]);

        $staff_salary_advance_approval->update([
            'status' => $validated['status'],
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'approval_remarks' => $validated['approval_remarks'],
        ]);

        return redirect()->route('staff-salary-advance-approvals.index')->with('success', 'Salary advance status updated successfully.');
    }
}
