<?php

namespace App\Http\Controllers;

use Spatie\Permission\Middleware\PermissionMiddleware;
use App\Models\StaffOvertime;
use App\StaffOvertimeStatus;
use Illuminate\Http\Request;

class StaffOvertimeApprovalController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', PermissionMiddleware::class . ':View Staff Overtime Approval'])->only(['index', 'show', 'fetchClaimsByStaff']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Create Staff Overtime Approval'])->only(['create', 'store']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Edit Staff Overtime Approval'])->only(['edit', 'update']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Delete Staff Overtime Approval'])->only(['destroy']);
    }

    public function index()
    {
        return view('staff-overtime-approvals.index');
    }

    public function fetchOvertimes(Request $request)
    {
        $overtimes = StaffOvertime::with('staff:id,full_name')
            ->get()
            ->map(function ($overtime) {
                return [
                    'id' => $overtime->id,
                    'staff_name' => $overtime->staff->full_name,
                    'overtime_date' => $overtime->start_time?->format('Y-m-d'),
                    'hours' => $overtime->hours,
                    'amount' => $overtime->amount,
                    'status' => $overtime->status_label,
                ];
            });
        return response()->json(['data' => $overtimes]);
    }


    public function show(StaffOvertime $staff_overtime_approval)
    {
        $overtime = $staff_overtime_approval;
        return view('staff-overtime-approvals.show', compact('overtime'));
    }

    public function edit(StaffOvertime $staff_overtime_approval)
    {
        $statuses = StaffOvertimeStatus::cases();
        $overtime = $staff_overtime_approval;
        return view('staff-overtime-approvals.edit', compact('overtime', 'statuses'));
    }

    public function update(Request $request, StaffOvertime $staff_overtime_approval)
    {
        $validated = $request->validate([
            'status' => 'required|in:' . implode(',', array_map(fn($case) => $case->value, StaffOvertimeStatus::cases())),
        ]);

        $staff_overtime_approval->update([
            'status' => $validated['status'],
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return redirect()->route('staff-overtime-approvals.index')->with('success', 'Overtime status updated successfully.');
    }
}
