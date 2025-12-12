<?php

namespace App\Http\Controllers;

use App\Models\PrepaidRecord;
use App\Models\PrepaidDeduction;
use App\Models\Invoice;
use App\Models\Client;
use Illuminate\Http\Request;

class PrepaidRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('prepaid-records.index');
    }

    public function fetchPrepaidRecord()
    {
        $prepaidRecords = PrepaidRecord::with('client', 'invoice')->select('prepaid_records.*')->get()->map(function ($record) {
            return [
                'id' => $record->id,

                'invoice_number' => $record->invoice ? $record->invoice->invoice_number : 'N/A',
                'client_name' => $record->invoice?->client?->name ?? 'N/A',
                'package_hour' => $record->package_hour,
                'balance' => $record->balance,
                'status' => $record->status_label,
                'created_at' => $record->created_at->toDateString(),
            ];
        });

        return response()->json(['data' => $prepaidRecords]);
    }

    public function getPrepaids($invoiceId)
    {
        // Fetch prepaid rows tied to invoice + tied quotation_item
        $prepaids = PrepaidRecord::where('invoice_id', $invoiceId)
            ->with([
                'prepaidDeductions',
                'quotationItem' => function ($q) {
                    $q->select('id', 'quotation_id', 'service_name', 'unit_price');
                }
            ])
            ->get();

        $data = [];

        foreach ($prepaids as $pre) {

            // total used hours from deductions table
            $used = $pre->prepaidDeductions->sum('deducted_hour');

            // remaining hours
            $remaining = $pre->package_hour - $used;

            // extract correct quotation item (guaranteed because we linked it)
            $item = $pre->quotationItem;

            if (!$item) {
                continue; // safety guard: skip if no linked item
            }

            // correct price per hour
            $pricePerHour = $item->unit_price / $pre->package_hour;

            $data[] = [
                'id'             => $pre->id,
                'service_name'   => $item->service_name,
                'package_hour'   => $pre->package_hour,
                'unit_price'     => $item->unit_price,
                'status'         => $pre->status_label ?? $pre->status,
                'description'    => $pre->description,
                'remaining_hour' => $remaining,
                'price_per_hour' => round($pricePerHour, 2),
            ];
        }

        return response()->json(['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('prepaid-records.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PrepaidRecord $prepaidRecord)
    {
        $prepaidRecord->load('prepaidDeductions', 'client', 'invoice');
        return view('prepaid-records.show', compact('prepaidRecord'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PrepaidRecord $prepaidRecord)
    {
        return view('prepaid-records.edit', compact('prepaidRecord'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PrepaidRecord $prepaidRecord)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PrepaidRecord $prepaidRecord)
    {
        // no delete for now
    }
}
