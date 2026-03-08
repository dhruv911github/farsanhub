<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Order Receipt - {{ $monthYear }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #1c1917;
            line-height: 1.5;
            background: #fff;
        }

        /* ── PAGE LAYOUT ─────────────────────────── */
        .page {
            padding: 30px 36px;
        }

        /* ── TOP ACCENT BAR ──────────────────────── */
        .accent-bar {
            background: #d97706;
            height: 5px;
            width: 100%;
            margin-bottom: 24px;
        }

        /* ── HEADER ──────────────────────────────── */
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 22px;
        }

        .brand-logo {
            vertical-align: middle;
        }

        .brand-logo img {
            width: 80px;
            height: auto;
        }

        .brand-info {
            vertical-align: top;
            padding-top: 4px;
            padding-left: 10px;
        }

        .brand-name {
            font-size: 17px;
            font-weight: bold;
            color: #1c1917;
            text-transform: uppercase;
            letter-spacing: 1px;
            line-height: 1.2;
        }

        .brand-tagline {
            font-size: 9px;
            color: #78716c;
            letter-spacing: 0.5px;
            margin-top: 2px;
        }

        .brand-address {
            font-size: 9.5px;
            color: #57534e;
            margin-top: 6px;
            line-height: 1.6;
        }

        .receipt-info {
            vertical-align: top;
            text-align: right;
        }

        .receipt-badge {
            display: inline-block;
            background: #fef3c7;
            color: #92400e;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 3px 10px;
            border-radius: 20px;
            border: 1px solid #fcd34d;
        }

        .receipt-title {
            font-size: 20px;
            font-weight: bold;
            color: #1c1917;
            margin-top: 8px;
            line-height: 1;
        }

        .receipt-sub {
            font-size: 11px;
            color: #78716c;
            margin-top: 4px;
        }

        .receipt-meta {
            margin-top: 10px;
            font-size: 9.5px;
            color: #57534e;
            line-height: 1.8;
        }

        .receipt-meta strong {
            color: #1c1917;
        }

        /* ── DIVIDER ─────────────────────────────── */
        .divider {
            border: none;
            border-top: 1.5px solid #e7e5e4;
            margin: 0 0 20px 0;
        }

        .divider-amber {
            border-top: 2px solid #d97706;
        }

        /* ── CUSTOMER INFO BLOCK ─────────────────── */
        .info-grid {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 22px;
        }

        .info-box {
            width: 50%;
            vertical-align: top;
            padding: 14px 16px;
            border: 1px solid #e7e5e4;
            border-radius: 4px;
            background: #fafaf9;
        }

        .info-box-right {
            padding-left: 20px;
            background: #fff;
            border: 1px solid #e7e5e4;
            border-left: 3px solid #d97706;
        }

        .info-box-spacer {
            width: 16px;
        }

        .info-label {
            font-size: 8.5px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #a8a29e;
            margin-bottom: 6px;
        }

        .info-value-main {
            font-size: 13px;
            font-weight: bold;
            color: #1c1917;
            margin-bottom: 2px;
        }

        .info-value-sub {
            font-size: 10px;
            color: #57534e;
            margin-bottom: 1px;
        }

        .info-value-small {
            font-size: 9px;
            color: #78716c;
        }

        /* ── SUMMARY STRIP ───────────────────────── */
        .summary-strip {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 22px;
        }

        .summary-cell {
            width: 25%;
            text-align: center;
            padding: 12px 8px;
            background: #fffbeb;
            border: 1px solid #fde68a;
        }

        .summary-cell-value {
            font-size: 16px;
            font-weight: bold;
            color: #92400e;
        }

        .summary-cell-label {
            font-size: 8.5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #a8a29e;
            margin-top: 3px;
        }

        /* ── SECTION TITLE ───────────────────────── */
        .section-title {
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #78716c;
            margin-bottom: 8px;
        }

        /* ── PIVOT TABLE ─────────────────────────── */
        .pivot-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: auto;
        }

        .pivot-table thead tr {
            background: #1c1917;
        }

        .pivot-table thead th {
            padding: 9px 8px;
            font-size: 8.5px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: #e7e5e4;
            border: 1px solid #44403c;
            text-align: center;
        }

        .pivot-table thead th.date-header {
            text-align: left;
            width: 90px;
        }

        .pivot-table thead th.total-header {
            background: #292524;
            color: #fcd34d;
            width: 70px;
        }

        .pivot-table tbody tr {
            border-bottom: 1px solid #f5f5f4;
        }

        .pivot-table tbody tr.row-even {
            background: #fafaf9;
        }

        .pivot-table tbody tr.row-odd {
            background: #ffffff;
        }

        .pivot-table tbody td {
            padding: 8px 8px;
            border: 1px solid #f0efee;
            font-size: 10px;
            vertical-align: middle;
        }

        .pivot-table tbody td.date-cell {
            font-size: 9.5px;
            font-weight: bold;
            color: #44403c;
            text-align: left;
            white-space: nowrap;
        }

        .pivot-table tbody td.qty-cell {
            text-align: center;
            color: #57534e;
        }

        .pivot-table tbody td.qty-cell.has-value {
            font-weight: bold;
            color: #1c1917;
        }

        .pivot-table tbody td.qty-empty {
            text-align: center;
            color: #d4d0cb;
            font-size: 9px;
        }

        .pivot-table tbody td.row-total-cell {
            text-align: center;
            font-weight: bold;
            color: #92400e;
            background: #fffbeb;
            border-left: 2px solid #fcd34d;
        }

        /* Monthly total row */
        .pivot-table tfoot tr.monthly-total-row {
            background: #1c1917;
        }

        .pivot-table tfoot td {
            padding: 10px 8px;
            border: 1px solid #44403c;
            font-size: 10px;
            font-weight: bold;
            text-align: center;
        }

        .pivot-table tfoot td.monthly-label {
            text-align: left;
            color: #fcd34d;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        .pivot-table tfoot td.monthly-qty {
            color: #e7e5e4;
        }

        .pivot-table tfoot td.monthly-grand {
            color: #fcd34d;
            background: #292524;
            font-size: 11px;
        }

        /* ── TOTALS / NOTE SECTION ───────────────── */
        .totals-wrapper {
            margin-top: 20px;
            width: 100%;
            border-collapse: collapse;
        }

        .totals-left {
            width: 55%;
            vertical-align: bottom;
            padding-right: 16px;
        }

        .note-box {
            background: #fafaf9;
            border: 1px solid #e7e5e4;
            border-left: 3px solid #d97706;
            padding: 10px 14px;
            font-size: 9.5px;
            color: #57534e;
            line-height: 1.7;
        }

        .note-box strong {
            color: #1c1917;
        }

        .totals-right {
            width: 45%;
            vertical-align: top;
        }

        .totals-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #e7e5e4;
        }

        .totals-table td {
            padding: 8px 14px;
            border-bottom: 1px solid #f5f5f4;
            font-size: 10.5px;
        }

        .totals-table .t-label {
            color: #78716c;
        }

        .totals-table .t-value {
            text-align: right;
            font-weight: bold;
            color: #1c1917;
        }

        .totals-table .grand-row {
            background: #1c1917;
        }

        .totals-table .grand-row td {
            border-bottom: none;
            padding: 11px 14px;
        }

        .totals-table .grand-label {
            color: #e7e5e4;
            font-size: 11px;
            font-weight: bold;
        }

        .totals-table .grand-value {
            text-align: right;
            color: #fcd34d;
            font-size: 15px;
            font-weight: bold;
        }

        /* ── FOOTER ──────────────────────────────── */
        .footer-divider {
            border: none;
            border-top: 1px solid #e7e5e4;
            margin: 28px 0 14px 0;
        }

        .footer-table {
            width: 100%;
            border-collapse: collapse;
        }

        .footer-left {
            font-size: 9px;
            color: #a8a29e;
            vertical-align: middle;
        }

        .footer-right {
            text-align: right;
            font-size: 9px;
            color: #a8a29e;
            vertical-align: middle;
        }

        .footer-right strong {
            color: #78716c;
        }

        /* ── BOTTOM ACCENT ───────────────────────── */
        .bottom-bar {
            background: #d97706;
            height: 4px;
            width: 100%;
            margin-top: 18px;
        }

        /* ── HELPERS ─────────────────────────────── */
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .fw-bold { font-weight: bold; }
        .page-break { page-break-after: always; }
    </style>
</head>

<body>
<div class="page">

    <!-- TOP ACCENT BAR -->
    <div class="accent-bar"></div>

    <!-- ─── HEADER ─────────────────────────────── -->
    <table class="header-table">
        <tr>
            <td class="brand-logo" style="width: 85px;">
                <img src="{{ $logoPath }}" alt="Logo">
            </td>
            <td class="brand-info">
                <div class="brand-name">Brahmani Khandvi &amp; Farsan</div>
                <div class="brand-tagline">Authentic Gujarati Snacks &amp; Farsan</div>
                <div class="brand-address">
                    Shop No-06, Arkview Tower, near Hari Om Subhanpura Water Tank,<br>
                    Subhanpura, Vadodara, Gujarat &ndash; 390021
                </div>
            </td>
            <td class="receipt-info">
                <div class="receipt-badge">Monthly Order Report</div>
                <div class="receipt-title">PRODUCT MATRIX</div>
                <div class="receipt-sub">
                    @if($monthName)
                        {{ $monthName }}
                    @else
                        All Orders
                    @endif
                </div>
                <div class="receipt-meta">
                    <strong>Receipt No:</strong> {{ $receiptNo }}<br>
                    <strong>Generated:</strong> {{ $reportDate }}
                </div>
            </td>
        </tr>
    </table>

    <hr class="divider divider-amber">

    <!-- ─── CUSTOMER / PERIOD INFO ─────────────── -->
    @if($customerInfo)
    <table class="info-grid">
        <tr>
            <td class="info-box">
                <div class="info-label">Bill To</div>
                <div class="info-value-main">{{ $customerInfo->customer_name }}</div>
                <div class="info-value-sub">{{ $customerInfo->shop_name }}</div>
                @if($customerInfo->shop_address)
                    <div class="info-value-small">{{ $customerInfo->shop_address }}{{ $customerInfo->city ? ', ' . $customerInfo->city : '' }}</div>
                @endif
                @if($customerInfo->customer_number)
                    <div class="info-value-small" style="margin-top:4px;">
                        <strong>Phone:</strong> {{ $customerInfo->customer_number }}
                    </div>
                @endif
                @if($customerInfo->customer_email)
                    <div class="info-value-small">
                        <strong>Email:</strong> {{ $customerInfo->customer_email }}
                    </div>
                @endif
            </td>
            <td class="info-box-spacer"></td>
            <td class="info-box info-box-right">
                <div class="info-label">Report Details</div>
                <div class="info-value-main">{{ $monthName ?? 'All Records' }}</div>
                <div class="info-value-sub" style="margin-top:6px;">
                    <strong>Period:</strong>
                    @if($monthYear)
                        01 {{ $monthName }} &ndash; {{ date('t', strtotime($monthYear . '-01')) }} {{ $monthName }}
                    @else
                        All Time
                    @endif
                </div>
                <div class="info-value-sub"><strong>Receipt No:</strong> {{ $receiptNo }}</div>
                <div class="info-value-sub"><strong>Generated On:</strong> {{ $reportDate }}</div>
            </td>
        </tr>
    </table>
    @else
    <table class="info-grid">
        <tr>
            <td class="info-box" style="width:50%;">
                <div class="info-label">Report Period</div>
                <div class="info-value-main">{{ $monthName ?? 'All Orders' }}</div>
                @if($monthYear)
                    <div class="info-value-sub" style="margin-top:4px;">
                        01 {{ $monthName }} &ndash; {{ date('t', strtotime($monthYear . '-01')) }} {{ $monthName }}
                    </div>
                @endif
            </td>
            <td class="info-box-spacer"></td>
            <td class="info-box info-box-right" style="width:50%;">
                <div class="info-label">Summary</div>
                <div class="info-value-sub"><strong>Receipt No:</strong> {{ $receiptNo }}</div>
                <div class="info-value-sub"><strong>Generated On:</strong> {{ $reportDate }}</div>
                <div class="info-value-sub"><strong>Customers:</strong> {{ $orders->unique('customer_id')->count() }}</div>
            </td>
        </tr>
    </table>
    @endif

    @php
        // ── BUILD PIVOT MATRIX ──────────────────────
        // Unique sorted products
        $pivotProducts = $orders->pluck('product_name')->unique()->sort()->values();

        // Group orders by date (sort key Y-m-d, display key d M Y)
        $byDate = [];
        foreach ($orders as $order) {
            $rawDate  = $order->order_date ?: date('Y-m-d', strtotime($order->created_at));
            $sortKey  = date('Y-m-d', strtotime($rawDate));
            $dispDate = date('d M Y', strtotime($rawDate));

            if (!isset($byDate[$sortKey])) {
                $byDate[$sortKey] = ['_display' => $dispDate];
            }
            $pName = $order->product_name;
            $byDate[$sortKey][$pName] = ($byDate[$sortKey][$pName] ?? 0) + $order->order_quantity;
        }
        ksort($byDate);

        // Per-product column totals
        $pivotProductTotals = [];
        foreach ($pivotProducts as $p) {
            $pivotProductTotals[$p] = 0;
        }
        foreach ($byDate as $row) {
            foreach ($pivotProducts as $p) {
                $pivotProductTotals[$p] += ($row[$p] ?? 0);
            }
        }

        // Per-date row totals
        $pivotDateTotals = [];
        foreach ($byDate as $key => $row) {
            $sum = 0;
            foreach ($pivotProducts as $p) {
                $sum += ($row[$p] ?? 0);
            }
            $pivotDateTotals[$key] = $sum;
        }

        $pivotGrandQty  = array_sum($pivotDateTotals);
        $totalDays      = count($byDate);
        $totalProdCount = $pivotProducts->count();
    @endphp

    <!-- ─── SUMMARY STRIP ──────────────────────── -->
    <table class="summary-strip">
        <tr>
            <td class="summary-cell" style="border-right: none; border-radius: 4px 0 0 4px;">
                <div class="summary-cell-value">{{ $totalDays }}</div>
                <div class="summary-cell-label">Total Days</div>
            </td>
            <td class="summary-cell" style="border-right: none;">
                <div class="summary-cell-value">{{ $totalProdCount }}</div>
                <div class="summary-cell-label">Total Products</div>
            </td>
            <td class="summary-cell" style="border-right: none;">
                <div class="summary-cell-value">{{ number_format($totalOrderQuantity) }} KG</div>
                <div class="summary-cell-label">Total Quantity</div>
            </td>
            <td class="summary-cell" style="border-radius: 0 4px 4px 0;">
                <div class="summary-cell-value">&#8377; {{ number_format($totalOrderAmount, 2) }}</div>
                <div class="summary-cell-label">Grand Total</div>
            </td>
        </tr>
    </table>

    <!-- ─── PIVOT MATRIX TABLE ─────────────────── -->
    <div class="section-title">Product Quantity Matrix &mdash; {{ $monthName ?? 'All Orders' }}</div>

    <table class="pivot-table">
        <thead>
            <tr>
                <th class="date-header">Date</th>
                @foreach($pivotProducts as $product)
                    <th>{{ $product }}</th>
                @endforeach
                <th class="total-header">Total (KG)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($byDate as $sortKey => $row)
                <tr class="{{ $loop->even ? 'row-even' : 'row-odd' }}">
                    <td class="date-cell">{{ $row['_display'] }}</td>
                    @foreach($pivotProducts as $product)
                        @if(isset($row[$product]) && $row[$product] > 0)
                            <td class="qty-cell has-value">{{ number_format($row[$product], 0) }}</td>
                        @else
                            <td class="qty-empty">&mdash;</td>
                        @endif
                    @endforeach
                    <td class="row-total-cell">{{ number_format($pivotDateTotals[$sortKey], 0) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="monthly-total-row">
                <td class="monthly-label">Monthly Total</td>
                @foreach($pivotProducts as $product)
                    <td class="monthly-qty">{{ number_format($pivotProductTotals[$product], 0) }}</td>
                @endforeach
                <td class="monthly-grand">{{ number_format($pivotGrandQty, 0) }}</td>
            </tr>
        </tfoot>
    </table>

    <!-- ─── TOTALS / NOTE SECTION ─────────────── -->
    <table class="totals-wrapper">
        <tr>
            <td class="totals-left">
                <div class="note-box">
                    <strong>Note:</strong><br>
                    &bull; Quantities are in KG. Each cell shows total KG ordered for that product on that date.<br>
                    &bull; &mdash; indicates no order for that product on that date.<br>
                    &bull; This is a computer-generated report and does not require a signature.
                </div>
            </td>
            <td class="totals-right">
                <table class="totals-table">
                    <tr>
                        <td class="t-label">Total Days with Orders</td>
                        <td class="t-value">{{ $totalDays }}</td>
                    </tr>
                    <tr>
                        <td class="t-label">Total Products</td>
                        <td class="t-value">{{ $totalProdCount }}</td>
                    </tr>
                    <tr>
                        <td class="t-label">Total Quantity (KG)</td>
                        <td class="t-value">{{ number_format($totalOrderQuantity) }} KG</td>
                    </tr>
                    <tr>
                        <td class="t-label">Grand Total Amount</td>
                        <td class="t-value">&#8377; {{ number_format($totalOrderAmount, 2) }}</td>
                    </tr>
                    <tr class="grand-row">
                        <td class="grand-label">Grand Total</td>
                        <td class="grand-value">&#8377; {{ number_format($totalOrderAmount, 2) }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- ─── FOOTER ─────────────────────────────── -->
    <hr class="footer-divider">
    <table class="footer-table">
        <tr>
            <td class="footer-left">
                This report was generated automatically by the Brahmani Farsan Hub system.<br>
                &copy; {{ date('Y') }} Brahmani Khandvi &amp; Farsan House. All rights reserved.
            </td>
            <td class="footer-right">
                <strong>Brahmani Khandvi &amp; Farsan House</strong><br>
                Shop No-06, Arkview Tower, Subhanpura, Vadodara &ndash; 390021
            </td>
        </tr>
    </table>

    <!-- BOTTOM ACCENT BAR -->
    <div class="bottom-bar"></div>

</div>
</body>

</html>
