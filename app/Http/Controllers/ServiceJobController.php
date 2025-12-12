<?php

namespace App\Http\Controllers;

use Spatie\Permission\Middleware\PermissionMiddleware;
use App\Models\ServiceJob;
use App\Models\Client;
use App\Models\PrepaidRecord;
use App\Models\Invoice;
use App\Models\Caregiver;
use App\Models\PrepaidDeduction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;


class ServiceJobController extends Controller
{
    public function __construct()
    {
        //Spaties Permission Middleware
        $this->middleware(['auth', PermissionMiddleware::class . ':View Job'])->only(['index', 'show', 'fetchJob', 'fetchPendingJobs']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Create Job'])->only(['create', 'store']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Edit Job'])->only(['edit', 'update']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Delete Job'])->only(['destroy']);
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('service-jobs.index');
    }

    public function fetchJob()
    {
        $jobs = ServiceJob::with(['invoice.client', 'caregiver'])->orderBy('start_datetime', 'desc')->get();

        $jobs = $jobs->map(function ($job) {
            return [
                'id' => $job->id,
                'invoice_number' => $job->invoice->invoice_number ?? '-',
                'client_name' => $job->invoice->client->name ?? '-',
                'caregiver_name' => $job->caregiver->name ?? 'Not Assigned',
                'start_date' => $job->start_datetime->format('Y-m-d'),
                'start_time' => $job->start_datetime->format('H:i'),
            ];
        });

        return response()->json(['data' => $jobs]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $api_token = session('api_token');
        $clients = Client::all();
        return view('service-jobs.create', compact(['clients', 'api_token']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validation and Data Prep
        // 2. Fetch Dependent Data BEFORE Transaction
        // 3. Prepaid Check and Validation
        // 4. Transaction Block
        // 5. Correct Deduction: Create a new PrepaidDeduction record
        $rules = [
            'client_id' => 'required|exists:clients,id',
            'invoice_id' => 'required|exists:invoices,id',
            'patient_id' => 'required|exists:patients,id',
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date|after:start_datetime',
            'caregiver_id' => 'required|exists:caregivers,id',
            'prepaid_id' => 'nullable|exists:prepaid_records,id',
            'mileage_amount' => 'nullable|numeric|min:0',
            'caregiver_payout_per_hour' => 'required|numeric|min:0',
        ];

        $data = $request->validate($rules);

        $start = Carbon::parse($data['start_datetime']);
        $end = Carbon::parse($data['end_datetime']);
        $minutes = $start->diffInMinutes($end);
        $hours = round($minutes / 60, 2);

        $invoice = Invoice::with('quotation.items.servicePricing')->findOrFail($data['invoice_id']);
        $quotationItem = $invoice->quotation->items->first();

        if (!$quotationItem) {
            return response()->json(['message' => 'Cannot determine service rate: No items on quotation.'], 422);
        }
        
        $servicePricing = $quotationItem->servicePricing;

        if (!$servicePricing || !$servicePricing->number_of_hours || $servicePricing->number_of_hours <= 0) {
            return response()->json(['message' => 'Cannot determine hourly rate for the service on this invoice.'], 422);
        }

        $pricePerHour = (float) ($quotationItem->unit_price / $servicePricing->number_of_hours);
        $servicePrice = round($pricePerHour * $hours, 2);

        // Payout Calculation
        $payoutPerHour = (float) $data['caregiver_payout_per_hour'];
        $caregiverPayoutTotal = round($payoutPerHour * $hours, 2);


        // 3. Prepaid Check and Validation
        $prepaid = null;
        if (!empty($data['prepaid_id'])) {
            $prepaid = PrepaidRecord::where('id', $data['prepaid_id'])
                ->where('invoice_id', $data['invoice_id'])
                ->whereNotNull('package_hour') // Critical check for base hour value
                ->lockForUpdate()
                ->first();

            if (!$prepaid) {
                return response()->json(['message' => 'Selected prepaid not found for this invoice.'], 422);
            }

            // Use the Accessor and explicitly cast to float for safe comparison
            $remaining = (float) $prepaid->remaining_hour;
            $required = (float) $hours;

            if ($remaining < $required) {
                return response()->json(['message' => 'Not enough prepaid hours remaining. Current: ' . $remaining], 422);
            }
        }

        // 4. Transaction Block
        DB::beginTransaction();
        try {
            $job = ServiceJob::create([
                'client_id' => $data['client_id'],
                'caregiver_id' => $data['caregiver_id'],
                'patient_id' => $data['patient_id'],
                'invoice_id' => $data['invoice_id'],
                'prepaid_record_id' => $data['prepaid_id'] ?? null,
                'start_datetime' => $start,
                'end_datetime' => $end,
                'hours' => $hours,
                'service_price' => $servicePrice,
                'price_per_hour' => $pricePerHour,
                'mileage_amount' => $data['mileage_amount'] ?? 0,
                'caregiver_payout_total' => $caregiverPayoutTotal, // Compute and insert in one call
                'caregiver_payout_per_hour' => $payoutPerHour,      // Include the rate used
                'status' => \App\ServiceJobStatus::PENDING,
                'created_by' => $request->user()->id,
            ]);

            // 5. Correct Deduction: Create a new PrepaidDeduction record
            if ($prepaid) {
                PrepaidDeduction::create([
                    'prepaid_record_id' => $prepaid->id,
                    'service_job_id'    => $job->id,
                    'actual_hour'       => $hours,
                    'deducted_hour'     => $hours,
                ]);
            }

            DB::commit();

            //return response()->json(['message' => 'Job created', 'data' => $job], 201);
            return redirect()->route('service-jobs.index')->with('success', 'Job created.');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error('Job create failed: ' . $e->getMessage() . ' Trace: ' . $e->getTraceAsString());
            return response()->json(['message' => 'Failed to create job.'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ServiceJob $serviceJob)
    {
        return view('service-jobs.show', compact('serviceJob'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ServiceJob $serviceJob)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ServiceJob $serviceJob)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceJob $serviceJob)
    {
        //
    }
}
