<?php

namespace App\Http\Controllers;
use Spatie\Permission\Middleware\PermissionMiddleware;
use App\Models\ClientPayment;
use App\Models\Client;
use App\Models\Quotation;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;


use Illuminate\Http\Request;

class ClientPaymentController extends Controller
{
    public function index()
    {
        $clientPayments = ClientPayment::all();
        return view('client-payments.index', compact('clientPayments'));
    }

    public function fetchClientPayment(Request $request)
    {
        $clientPayments = ClientPayment::with('client')->orderBy('created_at', 'desc')->get();

        $clientPayments = $clientPayments->map(function ($clientPayments) {
            return [
                'id' => $clientPayments->id,
                'invoice_number' => $clientPayments->invoice->invoice_number,
                'client_name' => $clientPayments->invoice->client->name ?? '-',
                'amount' => $clientPayments->amount,
                'payment_date' => $clientPayments->payment_date,

            ];
        });

        return response()->json([
            'data' => $clientPayments
        ]);
    }

    public function create()
    {
        // fix to only show invoices that are not 'paid'
        $invoices = Invoice::all();

        return view('client-payments.create', compact('invoices'));
    }

    public function store(Request $request)
    {
        $year = now()->year;

        // Get latest invoice number
        $lastReceipt = CLientPayment::whereYear('created_at', $year)->orderBy('receipt_number', 'desc')->first();

        if ($lastReceipt && preg_match('/RCPT-' . $year . '-(\d+)/', $lastReceipt->receipt_number, $matches)) {
            $sequence = (int) $matches[1] + 1;
        } else {
            $sequence = 1;
        }

        $receiptNumber = 'RCPT-' . $year . '-' . str_pad($sequence, 4, '0', STR_PAD_LEFT);


        $validated = $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'payment_type' => 'nullable|integer',
            'payment_status' => 'required|integer',
            'payment_method' => 'required|integer',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'remarks' => 'nullable|string|max:255',
        ]);

        $invoice = Invoice::findOrFail($request->invoice_id);
        $validated['receipt_number'] = $receiptNumber;
        $clientId = $invoice->client_id;
        $validated['client_id'] = $clientId;
        ClientPayment::create($validated);

        return redirect()->route('client-payments.index')->with('success', 'Client payment created successfully.');
    }

    // Generate PDF
    public function downloadPdf($id)
    {
        $client_payment = ClientPayment::with('invoice')->findOrFail($id);
        $pdf = Pdf::loadView('client-payments.pdf', compact('client_payment'))->setPaper('A4');

        //return $pdf->download("Quotation-{$quotation->quotation_number}.pdf");
        return $pdf->stream('Payment for -' . $client_payment->invoice->invoice_number . '.pdf');
    }


    public function show(string $id)
    {
        $client_payment = ClientPayment::findOrFail($id);
        return view('client-payments.show', compact('client_payment'));
    }

    public function edit(string $id)
    {
        $invoices = Invoice::all();
        $client_payment = ClientPayment::findOrFail($id);

        return view('client-payments.edit', compact('invoices', 'client_payment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'payment_type' => 'nullable|integer',
            'payment_status' => 'required|integer',
            'payment_method' => 'required|integer',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'remarks' => 'nullable|string|max:255',
        ]);

        $client_payment = ClientPayment::findOrFail($id);
        $client_payment->update($validated);

        return redirect()->route('client-payments.index')->with('success', 'Client payment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $client_payment = ClientPayment::findOrFail($id);
        $client_payment->delete();

        return response()->json(['message' => 'Client payment deleted successfully.']);
    }
}
