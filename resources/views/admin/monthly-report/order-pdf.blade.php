<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Order Report - {{ $monthYear }}</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #1c1917;
            line-height: 1.5;
            background: #fff;
        }

        .page { padding: 28px 34px; }

        /* ── ACCENT BAR ─── */
        .accent-bar  { background:#d97706; height:5px; width:100%; margin-bottom:22px; }
        .bottom-bar  { background:#d97706; height:4px; width:100%; margin-top:18px; }

        /* ── HEADER ─── */
        .header-table { width:100%; border-collapse:collapse; margin-bottom:20px; }
        .brand-logo   { vertical-align:middle; width:85px; }
        .brand-logo img { width:78px; height:auto; }
        .brand-info   { vertical-align:top; padding-top:4px; padding-left:10px; }
        .brand-name   { font-size:16px; font-weight:bold; color:#1c1917; text-transform:uppercase; letter-spacing:1px; }
        .brand-tagline{ font-size:8.5px; color:#78716c; margin-top:2px; }
        .brand-address{ font-size:9px; color:#57534e; margin-top:5px; line-height:1.6; }
        .receipt-info { vertical-align:top; text-align:right; }
        .receipt-badge{ display:inline-block; background:#fef3c7; color:#92400e; font-size:8.5px; font-weight:bold;
                        text-transform:uppercase; letter-spacing:1px; padding:3px 10px; border-radius:20px; border:1px solid #fcd34d; }
        .receipt-title{ font-size:19px; font-weight:bold; color:#1c1917; margin-top:7px; }
        .receipt-sub  { font-size:10.5px; color:#78716c; margin-top:3px; }
        .receipt-meta { margin-top:9px; font-size:9px; color:#57534e; line-height:1.8; }
        .receipt-meta strong { color:#1c1917; }

        /* ── DIVIDERS ─── */
        .divider        { border:none; border-top:1.5px solid #e7e5e4; margin:0 0 18px 0; }
        .divider-amber  { border-top:2px solid #d97706; }
        .footer-divider { border:none; border-top:1px solid #e7e5e4; margin:24px 0 12px 0; }

        /* ── CUSTOMER / PERIOD INFO ─── */
        .info-grid   { width:100%; border-collapse:collapse; margin-bottom:20px; }
        .info-box    { width:50%; vertical-align:top; padding:12px 14px; border:1px solid #e7e5e4; background:#fafaf9; }
        .info-box-right { border-left:3px solid #d97706; background:#fff; }
        .info-box-spacer { width:14px; }
        .info-label  { font-size:8px; font-weight:bold; text-transform:uppercase; letter-spacing:1px; color:#a8a29e; margin-bottom:5px; }
        .info-value-main { font-size:12.5px; font-weight:bold; color:#1c1917; margin-bottom:2px; }
        .info-value-sub  { font-size:9.5px; color:#57534e; margin-bottom:1px; }
        .info-value-small{ font-size:8.5px; color:#78716c; }

        /* ── SUMMARY STRIP ─── */
        .summary-strip { width:100%; border-collapse:collapse; margin-bottom:20px; }
        .summary-cell  { width:25%; text-align:center; padding:11px 8px; background:#fffbeb; border:1px solid #fde68a; }
        .summary-cell-value { font-size:15px; font-weight:bold; color:#92400e; }
        .summary-cell-label { font-size:8px; text-transform:uppercase; letter-spacing:0.5px; color:#a8a29e; margin-top:2px; }

        /* ── SECTION TITLE ─── */
        .section-title { font-size:9.5px; font-weight:bold; text-transform:uppercase;
                         letter-spacing:1px; color:#78716c; margin-bottom:7px; }

        /* ── ORDERS TABLE ─── */
        .orders-table { width:100%; border-collapse:collapse; }

        .orders-table thead tr { background:#1c1917; }
        .orders-table thead th {
            padding:8px 7px;
            font-size:8px;
            font-weight:bold;
            text-transform:uppercase;
            letter-spacing:0.6px;
            color:#e7e5e4;
            border:1px solid #44403c;
            text-align:center;
            white-space:nowrap;
        }
        .orders-table thead th.th-left { text-align:left; }

        .orders-table tbody tr { border-bottom:1px solid #f0efee; }
        .orders-table tbody tr.row-even { background:#fafaf9; }
        .orders-table tbody tr.row-odd  { background:#ffffff; }

        .orders-table tbody td {
            padding:7px 7px;
            border:1px solid #f0efee;
            font-size:9.5px;
            vertical-align:middle;
        }
        .orders-table tbody td.td-no   { text-align:center; color:#78716c; font-size:9px; }
        .orders-table tbody td.td-date { text-align:center; font-size:9px; color:#57534e; white-space:nowrap; }
        .orders-table tbody td.td-cust { font-weight:600; color:#1c1917; }
        .orders-table tbody td.td-shop { font-size:8.5px; color:#78716c; }
        .orders-table tbody td.td-prod { color:#292524; }
        .orders-table tbody td.td-qty  { text-align:center; font-weight:bold; color:#d97706; white-space:nowrap; }
        .orders-table tbody td.td-rate { text-align:right; color:#57534e; white-space:nowrap; }
        .orders-table tbody td.td-amt  { text-align:right; font-weight:bold; color:#92400e; white-space:nowrap; }
        .orders-table tbody td.td-type { text-align:center; }
        .badge-sell     { background:#d1fae5; color:#065f46; padding:1px 6px; border-radius:20px; font-size:8px; font-weight:bold; }
        .badge-purchase { background:#dbeafe; color:#1e40af; padding:1px 6px; border-radius:20px; font-size:8px; font-weight:bold; }

        /* Grand total row */
        .orders-table tfoot tr { background:#1c1917; }
        .orders-table tfoot td {
            padding:9px 7px;
            border:1px solid #44403c;
            font-size:9.5px;
            font-weight:bold;
            color:#e7e5e4;
        }
        .orders-table tfoot td.ft-label { text-align:left; color:#fcd34d; font-size:8.5px; text-transform:uppercase; }
        .orders-table tfoot td.ft-qty   { text-align:center; color:#e7e5e4; }
        .orders-table tfoot td.ft-amt   { text-align:right; color:#fcd34d; font-size:11px; background:#292524; }

        /* ── TOTALS SECTION ─── */
        .totals-wrapper { margin-top:18px; width:100%; border-collapse:collapse; }
        .totals-left    { width:55%; vertical-align:bottom; padding-right:14px; }
        .note-box {
            background:#fafaf9; border:1px solid #e7e5e4; border-left:3px solid #d97706;
            padding:10px 13px; font-size:9px; color:#57534e; line-height:1.7;
        }
        .note-box strong { color:#1c1917; }
        .totals-right   { width:45%; vertical-align:top; }
        .totals-table   { width:100%; border-collapse:collapse; border:1px solid #e7e5e4; }
        .totals-table td{ padding:7px 12px; border-bottom:1px solid #f5f5f4; font-size:10px; }
        .totals-table .t-label { color:#78716c; }
        .totals-table .t-value { text-align:right; font-weight:bold; color:#1c1917; }
        .totals-table .grand-row td { background:#1c1917; border-bottom:none; padding:10px 12px; }
        .totals-table .grand-label  { color:#e7e5e4; font-size:10.5px; font-weight:bold; }
        .totals-table .grand-value  { text-align:right; color:#fcd34d; font-size:14px; font-weight:bold; }

        /* ── FOOTER ─── */
        .footer-table { width:100%; border-collapse:collapse; }
        .footer-left  { font-size:8.5px; color:#a8a29e; vertical-align:middle; }
        .footer-right { text-align:right; font-size:8.5px; color:#a8a29e; vertical-align:middle; }
        .footer-right strong { color:#78716c; }

        .text-right  { text-align:right; }
        .text-center { text-align:center; }
    </style>
</head>
<body>
<div class="page">

    <div class="accent-bar"></div>

    {{-- HEADER --}}
    <table class="header-table">
        <tr>
            <td class="brand-logo"><img src="{{ $logoPath }}" alt="Logo"></td>
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
                <div class="receipt-title">ORDER STATEMENT</div>
                <div class="receipt-sub">{{ $monthName ?? 'All Orders' }}</div>
                <div class="receipt-meta">
                    <strong>Receipt No:</strong> {{ $receiptNo }}<br>
                    <strong>Generated:</strong> {{ $reportDate }}
                </div>
            </td>
        </tr>
    </table>

    <hr class="divider divider-amber">

    {{-- CUSTOMER / PERIOD INFO --}}
    @if($customerInfo)
    <table class="info-grid">
        <tr>
            <td class="info-box">
                <div class="info-label">Bill To</div>
                <div class="info-value-main">{{ $customerInfo->customer_name }}</div>
                <div class="info-value-sub">{{ $customerInfo->shop_name }}</div>
                @if($customerInfo->shop_address)
                    <div class="info-value-small">{{ $customerInfo->shop_address }}{{ $customerInfo->city ? ', '.$customerInfo->city : '' }}</div>
                @endif
                @if($customerInfo->customer_number)
                    <div class="info-value-small" style="margin-top:3px;"><strong>Phone:</strong> {{ $customerInfo->customer_number }}</div>
                @endif
            </td>
            <td class="info-box-spacer"></td>
            <td class="info-box info-box-right">
                <div class="info-label">Report Details</div>
                <div class="info-value-main">{{ $monthName ?? 'All Records' }}</div>
                <div class="info-value-sub" style="margin-top:5px;">
                    <strong>Period:</strong>
                    @if($monthYear) 01 {{ $monthName }} &ndash; {{ date('t', strtotime($monthYear.'-01')) }} {{ $monthName }}
                    @else All Time @endif
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
                    <div class="info-value-sub" style="margin-top:3px;">
                        01 {{ $monthName }} &ndash; {{ date('t', strtotime($monthYear.'-01')) }} {{ $monthName }}
                    </div>
                @endif
            </td>
            <td class="info-box-spacer"></td>
            <td class="info-box info-box-right" style="width:50%;">
                <div class="info-label">Summary</div>
                <div class="info-value-sub"><strong>Receipt No:</strong> {{ $receiptNo }}</div>
                <div class="info-value-sub"><strong>Generated On:</strong> {{ $reportDate }}</div>
                <div class="info-value-sub"><strong>Customers:</strong> {{ $orders->unique('customer_id')->count() }}</div>
                <div class="info-value-sub"><strong>Orders:</strong> {{ $orders->count() }}</div>
            </td>
        </tr>
    </table>
    @endif

    {{-- SUMMARY STRIP --}}
    <table class="summary-strip">
        <tr>
            <td class="summary-cell" style="border-right:none; border-radius:4px 0 0 4px;">
                <div class="summary-cell-value">{{ $orders->count() }}</div>
                <div class="summary-cell-label">Total Orders</div>
            </td>
            <td class="summary-cell" style="border-right:none;">
                <div class="summary-cell-value">{{ $orders->unique('customer_id')->count() }}</div>
                <div class="summary-cell-label">Customers</div>
            </td>
            <td class="summary-cell" style="border-right:none;">
                <div class="summary-cell-value">{{ rtrim(rtrim(number_format($totalOrderQuantity, 4), '0'), '.') }}</div>
                <div class="summary-cell-label">Total Quantity</div>
            </td>
            <td class="summary-cell" style="border-radius:0 4px 4px 0;">
                <div class="summary-cell-value">&#8377; {{ number_format($totalOrderAmount, 2) }}</div>
                <div class="summary-cell-label">Grand Total</div>
            </td>
        </tr>
    </table>

    {{-- ORDERS TABLE --}}
    <div class="section-title">Order Details &mdash; {{ $monthName ?? 'All Orders' }}</div>

    <table class="orders-table">
        <thead>
            <tr>
                <th style="width:26px;">#</th>
                <th style="width:62px;">Date</th>
                <th class="th-left">Customer</th>
                <th class="th-left">Product</th>
                <th style="width:62px;">Qty</th>
                <th style="width:56px;">Rate (&#8377;)</th>
                <th style="width:70px;">Amount (&#8377;)</th>
                <th style="width:52px;">Type</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $i => $order)
            @php
                $rowDate    = $order->order_date ?: date('Y-m-d', strtotime($order->created_at));
                $dispDate   = date('d-m-Y', strtotime($rowDate));
                $lineAmount = $order->order_quantity * $order->order_price;
            @endphp
            <tr class="{{ $loop->even ? 'row-even' : 'row-odd' }}">
                <td class="td-no">{{ $i + 1 }}</td>
                <td class="td-date">{{ $dispDate }}</td>
                <td>
                    <div class="td-cust">{{ $order->customer_name }}</div>
                    <div class="td-shop">{{ $order->shop_name }}</div>
                </td>
                <td class="td-prod">{{ $order->product_name }}</td>
                <td class="td-qty">{{ rtrim(rtrim(number_format($order->order_quantity, 4), '0'), '.') }}
                    <span style="font-size:8px; font-weight:normal;">{{ $order->unit ?? 'kg' }}</span>
                </td>
                <td class="td-rate">{{ number_format($order->order_price, 2) }}</td>
                <td class="td-amt">{{ number_format($lineAmount, 2) }}</td>
                <td class="td-type">
                    @if(($order->type ?? 'sell') === 'purchase')
                        <span class="badge-purchase">Purchase</span>
                    @else
                        <span class="badge-sell">Sell</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="ft-label">Grand Total</td>
                <td class="ft-qty">{{ rtrim(rtrim(number_format($totalOrderQuantity, 4), '0'), '.') }}</td>
                <td></td>
                <td class="ft-amt">&#8377; {{ number_format($totalOrderAmount, 2) }}</td>
                <td></td>
            </tr>
        </tfoot>
    </table>

    {{-- TOTALS SECTION --}}
    <table class="totals-wrapper">
        <tr>
            <td class="totals-left">
                <div class="note-box">
                    <strong>Note:</strong><br>
                    &bull; Rate is the effective price per unit for this order.<br>
                    &bull; Amount = Quantity &times; Rate.<br>
                    &bull; This is a computer-generated report and does not require a signature.
                </div>
            </td>
            <td class="totals-right">
                <table class="totals-table">
                    <tr>
                        <td class="t-label">Total Orders</td>
                        <td class="t-value">{{ $orders->count() }}</td>
                    </tr>
                    <tr>
                        <td class="t-label">Total Quantity</td>
                        <td class="t-value">{{ rtrim(rtrim(number_format($totalOrderQuantity, 4), '0'), '.') }}</td>
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

    <div class="bottom-bar"></div>

</div>
</body>
</html>
