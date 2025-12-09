<?php

namespace App\Http\Controllers;

use Spatie\Permission\Middleware\PermissionMiddleware;
use App\Models\CommissionBatch;
use Illuminate\Http\Request;
use App\Models\CommissionBatchRecord;
use App\Models\CommissionClaim;
use Carbon\Carbon;

class CommissionBatchController extends Controller
{
    public function __construct()
    {
        //Spaties Permission Middleware
        $this->middleware(['auth', PermissionMiddleware::class . ':View Commission Batch'])->only(['index', 'show', 'commissionShow', 'fetchCommissionBatchRecord']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Create Commission Batch'])->only(['store']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Edit Commission Batch'])->only(['edit', 'update']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Delete Commission Batch'])->only(['destroy']);
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $batches = CommissionBatch::all();
        return view('commission-batches.index', compact('batches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $month = now()->format('m');
        $year = now()->format('Y');
        $createdBy = auth()->id();
        $today = Carbon::today()->format('Y-m-d');

        // Check if batch exists
        if (CommissionBatch::where('month', $month)
            ->where('year', $year)
            ->exists()
        ) {
            return response()->json([
                'message' => 'Commission batch for ' . now()->format('F Y') . ' already exists.'
            ], 409); // 409 Conflict
        }

        // 1. Create new batch
        $batch = CommissionBatch::create([
            'month' => $month,
            'year' => $year,
            'created_by' => $createdBy,
        ]);

        // 2. For every approved commission claims, create commission batch RECORDs
        $commissionList = CommissionClaim::whereNotNull('approved_at')->get();

        foreach ($commissionList as $commission) {

            // 3. Create payroll record for each staff
            CommissionBatchRecord::create([
                'commission_batch_id' => $batch->id,
                'staff_id' => $commission->staff_id ?? null,
                'external_agent_id' => $commission->external_agent_id ?? null,
                'commission_claim_id' => $commission->id,
                'amount' => $commission->amount,
                'description' => null,
            ]);
        }

        return response()->json([
            'message' => 'Commission batch for ' . now()->format('F Y') . ' created successfully.',
            'batch_id' => $batch->id
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show(CommissionBatch $commissionBatch)
    {
        $batch = $commissionBatch;

        return view('commission-batches.show', compact('batch'));
    }

    public function fetchCommissionBatchRecord(Request $request)
    {
        $batchId = $request->input('batch_id');

        $records = CommissionBatchRecord::with(['staff', 'externalAgent'])
            ->where('commission_batch_id', $batchId)
            ->get();

        // Format data for DataTables
        $data = $records->map(function ($record) {
            $claimerType = $record->staff ? 'Staff' : 'External Agent';
            $claimerName = $record->staff->full_name ?? $record->externalAgent->name ?? '-';
            $invoice_number = $record->commissionClaim->invoice->invoice_number ?? '-';


            return [
                'name' => $claimerName,
                'claimer_type' => $claimerType,
                'staff_id' => $record->staff_id,
                'external_agent_id' => $record->external_agent_id,
                'commission_batch_id' => $record->commission_batch_id,
                'id' => $record->id,
                'batch_id' => $record->commission_batch_id,
                'invoice_number' => $invoice_number,
                'amount' => number_format($record->amount, 2),
            ];
        });
        return response()->json(['data' => $data]);
    }

    public function commissionShow(CommissionBatch $batch, CommissionBatchRecord $record)
    {
        // to show individual staff payroll details
        $record->load(['commissionClaim', 'staff', 'externalAgent', 'commissionClaim.invoice']);
        return view('commission-batches.commission_show', compact('batch', 'record'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CommissionBatch $commissionBatch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CommissionBatch $commissionBatch)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CommissionBatch $commissionBatch)
    {
        //
    }
}
