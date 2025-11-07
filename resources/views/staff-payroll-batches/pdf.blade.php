<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>M{{ $payslip->batch->month }} - {{ $payslip->staff->full_name }}</title>
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
            padding: 10px 20px;
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

        .details p {
            margin: 2px 0;
            line-height: 1.4;
        }

        .payslip-body table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 12px;
        }

        .payslip-body th,
        .payslip-body td {
            border: 1px solid #000;
            padding: 8px 10px;
            text-align: left;
        }

        .payslip-body th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .payslip-body tfoot td {
            font-weight: bold;
            background-color: #fafafa;
        }

        .payslip-body tfoot tr td {
            padding: 12px 10px;
            text-align: right;
        }

        .payslip-body tfoot tr td:last-child {
            font-size: 13px;
            font-weight: bold;
            color: #222;
        }

        .footer {
            margin: 20px;
            font-size: 10px;
            text-align: center;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="left">
            <img src="{{ public_path('assets/images/logo/mixigo-logo.png') }}" alt="Company Logo">
        </div>
        <div class="right">
            <div class="company-info">
                <div><strong>MIXIGO SDN BHD 202301008102 (1502023-W)</strong></div>
                <div>D-02-15, ONE SOUTH STREET MALL,<br> JALAN OS, TAMAN SERDANG PERDANA,<br>43300 SERI KEMBANGAN,
                    SELANGOR</div>
                <div><small>Contact: mixigo.hr@gmail.com  | 017 6891136</small></div>
            </div>
        </div>
    </div>

    <div class="title">Payslip</div>

    <div class="details">
        <div class="left">
            <p><strong>Name:</strong> {{ $payslip->staff->full_name }}</p>
            <p><strong>IC No:</strong> {{ $payslip->staff->ic_num }}</p>
            <p><strong>Department:</strong> {{ $payslip->staff->department->department_name }}</p>
        </div>
        <div class="right">
            <p><strong>Month:</strong> {{ \Carbon\Carbon::create()->month($payslip->batch->month)->format('F') }}</p>
            <p><strong>Payment Period:</strong> {{ $payslip->batch->period_start->format('d M Y') }} -
                {{ $payslip->batch->period_end->format('d M Y') }}</p>


            <p><strong>Base Salary:</strong> RM
                {{ number_format($payslip->staff->currentSalaryStructure->base_salary, 2) }}</p>
        </div>
    </div>

    <div class="payslip-body">
        <table>
            <thead>
                <tr>
                    <th>Earnings</th>
                    <th>Amount (RM)</th>
                    <th>Deductions</th>
                    <th>Amount (RM)</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $earnings = $payslip->items->where('type', 1)->values();
                    $deductions = $payslip->items->where('type', 2)->values();
                    $maxRows = max($earnings->count(), $deductions->count());
                @endphp

                @for ($i = 0; $i < $maxRows; $i++)
                    <tr>
                        <td>{{ $earnings[$i]->description ?? '' }}</td>
                        <td style="text-align: right;">
                            {{ isset($earnings[$i]) ? number_format($earnings[$i]->amount, 2) : '' }}
                        </td>
                        <td>{{ $deductions[$i]->description ?? '' }}</td>
                        <td style="text-align: right;">
                            {{ isset($deductions[$i]) ? number_format($deductions[$i]->amount, 2) : '' }}
                        </td>
                    </tr>
                @endfor
            </tbody>
            <tfoot>
                <tr>
                    <td><strong>Total Earnings</strong></td>
                    <td style="text-align: right;">RM
                        {{ number_format($payslip->items->where('type', 1)->sum('amount'), 2) }}</td>
                    <td><strong>Total Deductions</strong></td>
                    <td style="text-align: right;">RM
                        {{ number_format($payslip->items->where('type', 2)->sum('amount'), 2) }}</td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: right;"><strong>Net Pay:</strong></td>
                    <td style="text-align: right;"><strong>RM {{ number_format($payslip->net_salary, 2) }}</strong>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="footer">
        This payslip is computer-generated and does not require a signature.
    </div>

</body>

</html>
