<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Quotation;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::all();
        return view('invoices.index', compact('invoices'));
    }


    public function create()
    {
        $quotations = Quotation::all();
        return view('invoices.create', compact('quotations'));
    }

    public function fetchInvoice()
    {
        $invoices = Invoice::with('quotation.client')->orderBy('created_at', 'desc')->get();

        $invoices = $invoices->map(function ($invoices) {
            return [
                'id' => $invoices->id,
                'invoice_number' => $invoices->invoice_number,
                'client_name' => $invoices->quotation->client->name ?? '-',
                'total_amount' => $invoices->total_amount,
                'payment_status' => $invoices->payment_status,

            ];
        });

        return response()->json(['data' => $invoices]);
    }

    public function store(Request $request)
    {
        $year = now()->year;

        // Get latest invoice number
        $lastInvoice = Invoice::whereYear('created_at', $year)->orderBy('invoice_number', 'desc')->first();

        if ($lastInvoice && preg_match('/INV-' . $year . '-(\d+)/', $lastInvoice->invoice_number, $matches)) {
            $sequence = (int) $matches[1] + 1;
        } else {
            $sequence = 1;
        }

        $invoiceNumber = 'INV-' . $year . '-' . str_pad($sequence, 4, '0', STR_PAD_LEFT);

        // Validation
        $validated = $request->validate([
            'quotation_id' => 'nullable|exists:quotations,id',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:invoice_date',
            'remarks' => 'nullable|string|max:255',
        ]);

        // Create invoice
        $quotation = Quotation::findOrFail($validated['quotation_id']);
        $invoice = Invoice::create([
            'invoice_number' => $invoiceNumber,
            'quotation_id' => $validated['quotation_id'] ?? null,
            'client_id' => $quotation->client_id,
            'paid_amount' => 0,
            'total_amount' => $quotation->final_price,
            'payment_status' => 'unpaid',
            'invoice_date' => $validated['invoice_date'],
            'due_date' => $validated['due_date'],
            'remarks' => $validated['remarks'] ?? null,
        ]);

        return redirect()->route('invoices.index')->with('success', 'Invoice created.');
    }

    public function show(string $id)
    {
        $invoice = Invoice::with('quotation')->findOrFail($id);
        return view('invoices.show', compact('invoice'));
    }

    // Generate PDF
    public function downloadPdf($id)
    {
        $invoice = Invoice::with('quotation')->findOrFail($id);
        $pdf = Pdf::loadView('invoices.pdf', compact('invoice'))->setPaper('A4');

        //return $pdf->download("Quotation-{$quotation->quotation_number}.pdf");
        return $pdf->stream('Invoice-' . $invoice->invoice_number . '.pdf');
    }

    public function edit($id)
    {
        $invoice = Invoice::findOrFail($id);
        $quotations = Quotation::with('client')->get();

        return view('invoices.edit', compact('invoice', 'quotations'));
    }

    public function update(Request $request, $id)
    {
        $invoice = Invoice::findOrFail($id);

        $validated = $request->validate([
            'quotation_id' => 'required|exists:quotations,id',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:invoice_date',
            'remarks' => 'nullable|string|max:255',
        ]);

        $quotation = Quotation::findOrFail($validated['quotation_id']);

        $invoice->update([
            'quotation_id' => $quotation->id,
            'client_id' => $quotation->client_id,
            'invoice_date' => $validated['invoice_date'],
            'due_date' => $validated['due_date'],
            'total_amount' => $quotation->final_price,
            'remarks' => $validated['remarks'],
        ]);

        return redirect()->route('invoices.index')->with('success', 'Invoice updated successfully.');
    }

    public function destroy(string $id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();

        return response()->json(['message' => 'Invoice deleted successfully.']);
    }
}
