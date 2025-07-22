<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Quotation - {{ $quotation->quotation_number }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .header {
            padding: 20px;
            /* border-bottom: 2px solid #000; */
            /* overflow: hidden; */
            /* clears floats */

        }

        .header .left {
            float: left;
            width: 50%;
        }

        .header .right {
            float: right;
            width: 50%;
            text-align: right;
        }

        .header img {
            max-width: 100px;
        }

        .title {
            font-size: 22px;
            font-weight: bold;
            margin: 0px 0;
            text-align: center;

        }

        .details {
            padding: 10px 0;
        }

        .details::after {
            content: "";
            display: table;
            clear: both;
        }

        .details .left {
            float: left;
            width: 50%;
        }

        .details .right {
            float: right;
            width: 50%;
            text-align: right;
        }


        .items table {
            width: 100%;
            border-collapse: collapse;
        }

        .items table,
        .items th,
        .items td {
            border: 1px solid #000;
        }

        .items th,
        .items td {
            padding: 10px;
        }

        .footer {
            margin: 20px;
            font-size: 10px;
            text-align: center;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }

        .center {
            margin: 0 auto;
            width: 50%;
            padding: 20px;
        }

        .client-details p {
            margin: 2px 0;
            line-height: 1.2;
        }

        .quotation-details {
            border-bottom: 2px solid #b2b3b0;
            margin: 15px 0;
            padding: 15px 0;
        }

        .quotation-details::after {
            content: "";
            display: table;
            clear: both;
        }

        .quotation-details .left {
            float: left;
            width: 50%
        }

        .quotation-details .right {
            float: right;
            width: 50%;
            text-align: right;
        }

        .banking-details p {
            margin: 2px 0;
            line-height: 1.2;
        }

        .quotation-date p {
            margin: 2px 0;
            line-height: 1.2;
        }

    </style>
</head>

<body>
    <div class="header">
        <div class="left">
            <img src="{{ public_path('assets/images/logo/mixigo-logo.png') }}" alt="Company Logo">
        </div>
        <div class="right">
            <div class="comapany-info">
                <div id="company-name"><strong>MIXIGO SDN BHD 202301008102 (1502023-W)</strong></div>
                <div id="company-address">D-02-15, ONE SOUTH STREET MALL, JALAN OS, TAMAN SERDANG PERDANA, 43300 SERI
                    KEMBANGAN,
                    SELANGOR</strong>
                </div>
            </div>
        </div>
    </div>

    <div class="center">
        <div class="title">Quotation</div>
    </div>

    <div class="quotation-details">
        <div class="quotation-date left">
            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($quotation->created_at)->format('d M Y') }}</p>
            <p><strong>Valid Until:</strong>
                {{ $quotation->valid_until ? \Carbon\Carbon::parse($quotation->valid_until)->format('d M Y') : '-' }}
            </p>
        </div>
        <div class="right">
            <div>
                <p><strong>Quotation Number:</strong> {{ $quotation->quotation_number }}</p>
            </div>
        </div>

    </div>

    <div class="details">
        <div class="client-details left">
            <p><strong>Client:</strong> {{ $quotation->client->name ?? '-' }}</p>
            <p><strong>Phone:</strong> {{ $quotation->client->mobileno ?? '-' }}</p>

        </div>
        <div class="banking-details right">
            <div><strong>Pay To:</strong></div>
            <p>Bank: Maybank</p>
            <p>Acc Name: Mixigo Sdn Bhd</p>
            <p>Acc Number: 562263596895</p>
            <p>Reference: {{ $quotation->quotation_number }}</p>
        </div>
    </div>


    <div class="overflow-view">
        <div class="quotation-body">
            <table>
                <thead>
                    <tr>
                        <th class="text-end text-bold">Service</th>
                        <th class="text-end text-bold">Quantity</th>
                        <th class="text-end text-bold">Price</th>
                        <th class="text-end text-bold">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($quotation->items as $index => $item)
                        <tr>

                            <td>{{ $item->service_name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->unit_price, 2) }}</td>
                            <td>{{ number_format($item->subtotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="quotation-body-bottom">
                <div class="quotation-body-info-item border-bottom">
                    <div class="info-item-td text-end text-bold">Sub Total:</div>
                    <div class="info-item-td text-end">RM {{ number_format($quotation->items->sum('subtotal'), 2) }}
                    </div>
                </div>
                <div class="quotation-body-info-item border-bottom">
                    <div class="info-item-td text-end text-bold">Mileage:</div>
                    <div class="info-item-td text-end">RM {{ number_format($quotation->mileage, 2) }}</div>
                </div>
                <div class="quotation-body-info-item border-bottom">
                    <div class="info-item-td text-end text-bold">Discount:</div>
                    <div class="info-item-td text-end">RM {{ number_format($quotation->discount, 2) }}</div>
                </div>
                <div class="quotation-body-info-item border-bottom">
                    <div class="info-item-td text-end text-bold">Grand Total:</div>
                    <div class="info-item-td text-end">RM {{ number_format($quotation->final_price, 2) }}</div>
                </div>
            </div>
        </div>
    </div>
    <!-- Caregiver End -->
    {{-- <div class="items">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Service Name</th>
                    <th>Quantity</th>
                    <th>Unit Price (RM)</th>
                    <th>Subtotal (RM)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($quotation->items as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->service_name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->unit_price, 2) }}</td>
                        <td>{{ number_format($item->subtotal, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <table style="margin-top: 20px;">
            <tr>
                <th style="text-align:right;">Subtotal:</th>
                <td style="text-align:right;">RM {{ number_format($quotation->items->sum('subtotal'), 2) }}</td>
            </tr>
            <tr>
                <th style="text-align:right;">Mileage:</th>
                <td style="text-align:right;">RM {{ number_format($quotation->mileage, 2) }}</td>
            </tr>
            <tr>
                <th style="text-align:right;">Discount:</th>
                <td style="text-align:right;">RM {{ number_format($quotation->discount, 2) }}</td>
            </tr>
            <tr>
                <th style="text-align:right;">Grand Total:</th>
                <td style="text-align:right; font-weight:bold;">RM {{ number_format($quotation->final_price, 2) }}</td>
            </tr>
        </table>
    </div>
 --}}
    <div class="footer">
        Thank you for considering our services. For inquiries, please contact us at 013-6441136 - Sales
    </div>

</body>

</html>
