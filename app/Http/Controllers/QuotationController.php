<?php

namespace App\Http\Controllers;

use Spatie\Permission\Middleware\PermissionMiddleware;
use App\Models\Quotation;
use App\Models\Client;
use App\Models\ServicePricing;
use App\QuotationStatus;
use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade\Pdf;

class QuotationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', PermissionMiddleware::class . ':View Quotation'])->only(['index', 'show', 'downloadPdf', 'fetchQuotation']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Create Quotation'])->only(['create', 'store']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Edit Quotation'])->only(['edit', 'update']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Delete Quotation'])->only(['destroy']);
    }

    public function index()
    {
        $quotations = Quotation::all();
        return view('quotations.index', compact('quotations'));
    }

    public function fetchQuotation(Request $request)
    {
        $quotations = Quotation::with('client')->orderBy('created_at', 'desc')->get();

        $quotations = $quotations->map(function ($quotation) {
            return [
                'id' => $quotation->id,
                'quotation_number' => $quotation->quotation_number,
                'client_name' => $quotation->client->name ?? '-',
                'status_label' => $quotation->status_label,
                'final_price' => $quotation->final_price,
            ];
        });

        return response()->json(['data' => $quotations]);
    }

    public function create()
    {
        $clients = Client::all();
        $servicePricings = ServicePricing::all();
        $statuses = QuotationStatus::cases();

        // dummy items for the form
        $items = collect([['service_pricing_id' => '', 'quantity' => 1, 'subtotal' => '']]);

        return view('quotations.create', compact('clients', 'servicePricings', 'items', 'statuses'));
    }

    public function store(Request $request)
    {
        $year = now()->year;

        // Get the latest quotation number for this year
        $lastQuotation = Quotation::whereYear('created_at', $year)->orderBy('quotation_number', 'desc')->first();

        if ($lastQuotation && preg_match('/QUO-' . $year . '-(\d+)/', $lastQuotation->quotation_number, $matches)) {
            $sequence = (int) $matches[1] + 1;
        } else {
            $sequence = 1;
        }

        $quotationNumber = 'QUO-' . $year . '-' . str_pad($sequence, 4, '0', STR_PAD_LEFT);

        // Validate the request data
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'mileage' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'final_price' => 'nullable|numeric',
            'remarks' => 'nullable|string|max:255',
            'valid_until' => 'nullable|date',
            'items' => 'required|array|min:1',
            'items.*.service_pricing_id' => 'required|exists:service_pricings,id',
            'items.*.quantity' => 'required|integer|min:1',

            'status' => 'required|integer',
        ]);

        $validated['quotation_number'] = $quotationNumber;

        //Quotation::create($validated);
        $quotation = Quotation::create([
            'quotation_number' => $validated['quotation_number'],
            'client_id' => $request->client_id,
            'mileage' => $request->mileage,
            'discount' => $request->discount,
            'final_price' => $request->final_price,
            'remarks' => $request->remarks,
            'valid_until' => $request->valid_until,

            'status' => $request->status,
        ]);

        foreach ($request->items as $item) {
            $service = ServicePricing::findOrFail($item['service_pricing_id']);
            $unitPrice = $service->price;
            $quantity = $item['quantity'];
            $subtotal = $unitPrice * $quantity;

            $quotation->items()->create([
                'service_pricing_id' => $service->id,
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'subtotal' => $subtotal,
                'service_name' => $service->service_name,
            ]);
        }

        return redirect()->route('quotations.index')->with('success', 'Quotation created.');
    }

    public function show(string $id)
    {
        //$quotation = Quotation::findOrFail($id);
        $quotation = Quotation::with('items', 'client')->findOrFail($id);
        return view('quotations.show', compact('quotation'));
    }

    // Generate PDF
    public function downloadPdf($id)
    {
        $quotation = Quotation::with('items', 'client')->findOrFail($id);
        $pdf = Pdf::loadView('quotations.pdf', compact('quotation'))->setPaper('A4');

        //return $pdf->download("Quotation-{$quotation->quotation_number}.pdf");
        return $pdf->stream('quotation-' . $quotation->quotation_number . '.pdf');
    }


    public function edit(string $id)
    {
        $quotation = Quotation::with('items')->findOrFail($id);
        $clients = Client::all();
        $servicePricings = ServicePricing::all();
        $statuses = QuotationStatus::cases();
        $items = $quotation->items;

        return view('quotations.edit', compact('clients', 'servicePricings', 'quotation', 'items', 'statuses'));
    }

    public function update(Request $request, Quotation $quotation)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'mileage' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'final_price' => 'nullable|numeric',
            'remarks' => 'nullable|string|max:255',
            'valid_until' => 'nullable|date',

            'items' => 'required|array|min:1',
            'items.*.service_pricing_id' => 'required|exists:service_pricings,id',
            'items.*.quantity' => 'required|integer|min:1',
            'status' => 'required|integer',
        ]);

        $quotation->update([
            'client_id' => $validated['client_id'],
            'mileage' => $validated['mileage'] ?? 0,
            'discount' => $validated['discount'] ?? 0,
            'final_price' => $validated['final_price'] ?? 0,
            'remarks' => $validated['remarks'] ?? null,
            'valid_until' => $validated['valid_until'] ?? null,
            'status' => $request->status,
        ]);

        // Delete existing items and re-insert
        $quotation->items()->delete();

        foreach ($validated['items'] as $item) {
            $service = ServicePricing::findOrFail($item['service_pricing_id']);
            $unitPrice = $service->price;
            $quantity = $item['quantity'];
            $subtotal = $unitPrice * $quantity;

            $quotation->items()->create([
                'service_pricing_id' => $service->id,
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'subtotal' => $subtotal,
                'service_name' => $service->service_name,
            ]);
        }

        return redirect()->route('quotations.index')->with('success', 'Quotation updated.');
    }

    public function destroy(string $id)
    {
        $quotation = Quotation::findOrFail($id);
        $quotation->delete();

        return response()->json(['message' => 'Quotation deleted successfully.']);
    }
}
