<?php

namespace App\Http\Controllers;

use Spatie\Permission\Middleware\PermissionMiddleware;
use App\Models\StaffOvertime;
use App\Models\SalaryStructure;
use Illuminate\Http\Request;

class StaffOvertimeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', PermissionMiddleware::class . ':View Staff Overtime'])->only(['index', 'show', 'fetchClaimsByStaff']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Create Staff Overtime'])->only(['create', 'store']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Edit Staff Overtime'])->only(['edit', 'update']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Delete Staff Overtime'])->only(['destroy']);
    }

    protected function getHourlyRate()
    {
        $staff = auth()->user()->staff;
        $salary = $staff->salaryStructure ?? null;

        if (!$salary) {
            return 0;
        }

        $weeklyHours = $salary->work_hour_per_day * $salary->work_day_per_week;

        if ($weeklyHours <= 0) {
            return 0;
        }

        $monthlyHours = $weeklyHours * 4.33; // average weeks in a month
        $hourlyRate = $salary->base_salary / $monthlyHours;
        return round($hourlyRate, 2);
    }


    public function index()
    {
        return view('staff-overtimes.index');
    }

    public function fetchStaffOvertimes(Request $request)
    {
        $staffId = auth()->user()->staff->id;

        $overtimes = StaffOvertime::with('staff:id,full_name')
            ->where('staff_id', $staffId)
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

    public function create()
    {
        $hourlyRate = $this->getHourlyRate();
        return view('staff-overtimes.create', compact('hourlyRate'));
    }

    public function store(Request $request)
    {
        $staffId = auth()->user()->staff->id;
        $rate = $this->getHourlyRate();

        $validated = $request->validate([
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time', // ensures end > start
            'multiplier' => 'required|numeric|min:0',
        ]);

        $start = new \Carbon\Carbon($validated['start_time']);
        $end   = new \Carbon\Carbon($validated['end_time']);


        $diffSeconds = $end->timestamp - $start->timestamp; // difference in seconds
        $hours = round($diffSeconds / 3600, 2); // convert to hours
        $amount = round($hours * $rate * $validated['multiplier'], 2); // calculate amount

        StaffOvertime::create([
            'staff_id' => $staffId,
            'start_time' => $start,
            'end_time' => $end,
            'hours' => $hours,
            'amount' => $amount,
            'hourly_rate' => $rate,
            'multiplier' => $validated['multiplier'],
        ]);

        return redirect()->route('staff-overtimes.index')
            ->with('success', 'Overtime saved successfully.');
    }

    public function show(StaffOvertime $staffOvertime)
    {
        $overtime = $staffOvertime;
        return view('staff-overtimes.show', compact('overtime'));
    }

    // No edit and update for this module
    /*     public function edit(StaffOvertime $staffOvertime)
    {
       if ($staffOvertime->status != 0) {
            return redirect()->route('staff-overtimes.index')->with('error', 'Can only edit pending overtime.');
        }

        $overtime = $staffOvertime;
        $hourlyRate = $this->getHourlyRate();
        return view('staff-overtimes.edit', compact('overtime', 'hourlyRate'));
    } 

    public function update(Request $request, StaffOvertime $staff_overtime)
    {
        $rate = $this->getHourlyRate();

        $validated = $request->validate([
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time', // ensures end > start
            'multiplier' => 'required|numeric|min:0',
        ]);

        $start = new \Carbon\Carbon($validated['start_time']);
        $end = new \Carbon\Carbon($validated['end_time']);
        $diffSeconds = $end->timestamp - $start->timestamp; // difference in seconds
        $hours = round($diffSeconds / 3600, 2); // convert to hours
        $amount = round($hours * $rate * $validated['multiplier'], 2);

        $staff_overtime->update([
            'start_time' => $start,
            'end_time' => $end,
            'hourly_rate' => $rate,
            'hours' => $hours,
            'amount' => $amount,
            'multiplier' => $validated['multiplier'],
        ]);

        return redirect()->route('staff-overtimes.index')->with('success', 'Overtime record updated successfully.');
    }
 */
    public function destroy(StaffOvertime $staff_overtime)
    {
        if ($staff_overtime->status != 0) { // Not Pending
            return response()->json([
                'success' => false,
                'message' => 'Can only delete pending overtime.'
            ], 400); // 400 Bad Request
        }

        $staff_overtime->delete();
        return response()->json([
            'success' => true,
            'message' => 'Claim deleted successfully.'
        ], 200);
    }
}
