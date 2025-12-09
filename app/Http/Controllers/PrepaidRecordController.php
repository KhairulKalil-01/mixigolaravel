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
