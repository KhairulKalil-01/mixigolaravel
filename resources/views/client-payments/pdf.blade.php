<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Payment for - {{ $client_payment->invoice->invoice_number }}</title>
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

        /* table */

        .quotation-body table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 12px;
        }

        .quotation-body th,
        .quotation-body td {
            border: 1px solid #000;
            padding: 10px;
            text-align: left;
        }

        .quotation-body th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .quotation-body tfoot td {
            font-weight: bold;
            background-color: #fafafa;
        }

        .quotation-body tfoot tr td {
            padding: 12px 10px;
            text-align: right;
        }

        .quotation-body tfoot tr td:first-child {
            text-align: right;
        }

        .quotation-body tfoot tr td:last-child {
            font-size: 13px;
            font-weight: bold;
            color: #222;
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
        <div class="title">Payment Receipt</div>
    </div>

    <div class="quotation-details">
        <div class="quotation-date left">
            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($client_payment->created_at)->format('d M Y') }}</p>
        </div>
        <div class="right">
            <div>
                <p><strong>Receipt Number: </strong> {{ $client_payment->receipt_number }}</p>
                <p><strong>Payment for: </strong> {{ $client_payment->invoice->invoice_number }}</p>
            </div>
        </div>
    </div>

    <div class="details">
        <div class="client-details left">
            <p><strong>Client:</strong> {{ $client_payment->client->name ?? '-' }}</p>
            <p><strong>Phone:</strong> {{ $client_payment->client->mobileno ?? '-' }}</p>

        </div>
    </div>


    <div class="overflow-view">
        <div class="quotation-body">
            <table>
                <thead>
                    <tr>
                        <th>Invoice</th>
                        <th>Inv. Amount (RM)</th>
                        <th>Paid Amount (RM)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $client_payment->invoice->invoice_number }}</td>
                        <td>{{ number_format($client_payment->invoice->total_amount, 2) }}</td>
                        <td>{{ number_format($client_payment->amount, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
    <div class="footer">
        Thank you for choosing our services. For inquiries, please contact us at <strong>013-6441136</strong> - Sales
    </div>

</body>

</html>
