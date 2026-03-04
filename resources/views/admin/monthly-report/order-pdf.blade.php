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

        /* ── ORDERS TABLE ────────────────────────── */
        .section-title {
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #78716c;
            margin-bottom: 8px;
        }

        .orders-table {
            width: 100%;
            border-collapse: collapse;
        }

        .orders-table thead tr {
            background: #1c1917;
        }

        .orders-table th {
            padding: 9px 10px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #e7e5e4;
            border: none;
            text-align: left;
        }

        .orders-table th.text-right {
            text-align: right;
        }

        .orders-table th.text-center {
            text-align: center;
        }

        .orders-table tbody tr {
            border-bottom: 1px solid #f5f5f4;
        }

        .orders-table tbody tr.row-even {
            background: #fafaf9;
        }

        .orders-table tbody tr.row-odd {
            background: #ffffff;
        }

        .orders-table td {
            padding: 9px 10px;
            vertical-align: middle;
            border: none;
            font-size: 10.5px;
        }

        .orders-table .sr-no {
            color: #a8a29e;
            font-size: 9px;
            font-weight: bold;
            text-align: center;
        }

        .orders-table .customer-main {
            font-weight: bold;
            color: #1c1917;
            font-size: 11px;
        }

        .orders-table .customer-sub {
            font-size: 9px;
            color: #78716c;
            margin-top: 1px;
        }

        .orders-table .product-name {
            color: #292524;
        }

        .orders-table .qty {
            text-align: center;
            font-weight: bold;
            color: #44403c;
        }

        .orders-table .price {
            text-align: right;
            color: #57534e;
        }

        .orders-table .amount {
            text-align: right;
            font-weight: bold;
            color: #1c1917;
        }

        .orders-table .date-col {
            text-align: center;
            font-size: 9.5px;
            color: #78716c;
        }

        .orders-table .status-col {
            text-align: center;
        }

        /* Status badges */
        .badge {
            display: inline-block;
            padding: 2px 7px;
            border-radius: 10px;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-delivered {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #6ee7b7;
        }

        .badge-pending {
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fcd34d;
        }

        .badge-cancelled {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        /* ── TOTALS SECTION ──────────────────────── */
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
                    <div class="receipt-badge">Monthly Order Receipt</div>
                    <div class="receipt-title">ORDER REPORT</div>
                    <div class="receipt-sub">
                        @if($monthName)
                            {{ $monthName }}
                        @else
                            All Orders
                        @endif
                    </div>
                    <div class="receipt-meta">
                        <strong>Receipt No:</strong> {{ $receiptNo }}<br>
                        <strong>Generated:</strong> {{ $reportDate }}<br>
                        <strong>Total Orders:</strong> {{ $orders->count() }}
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
                    <div class="info-value-sub"><strong>Total Entries:</strong> {{ $orders->count() }}</div>
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
                    <div class="info-value-sub"><strong>Total Orders:</strong> {{ $orders->count() }}</div>
                    <div class="info-value-sub"><strong>Customers:</strong> {{ $orders->unique('customer_id')->count() }}</div>
                </td>
            </tr>
        </table>
        @endif

        <!-- ─── SUMMARY STRIP ──────────────────────── -->
        <table class="summary-strip">
            <tr>
                <td class="summary-cell" style="border-right: none; border-radius: 4px 0 0 4px;">
                    <div class="summary-cell-value">{{ $orders->count() }}</div>
                    <div class="summary-cell-label">Total Orders</div>
                </td>
                <td class="summary-cell" style="border-right: none;">
                    <div class="summary-cell-value">{{ $orders->unique('customer_id')->count() }}</div>
                    <div class="summary-cell-label">Customers</div>
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

        <!-- ─── ORDERS TABLE ───────────────────────── -->
        <div class="section-title">Order Details</div>

        <table class="orders-table">
            <thead>
                <tr>
                    <th style="width: 32px;" class="text-center">#</th>
                    @if(!$customerInfo)
                    <th style="width: 150px;">Customer / Shop</th>
                    @endif
                    <th>Product</th>
                    <th style="width: 75px;" class="text-center">Qty (KG)</th>
                    <th style="width: 80px;" class="text-right">Unit Price</th>
                    <th style="width: 90px;" class="text-right">Amount</th>
                    {{-- <th style="width: 70px;" class="text-center">Status</th> --}}
                    <th style="width: 80px;" class="text-center">Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $index => $order)
                    @php
                        $rowClass = ($index % 2 === 0) ? 'row-even' : 'row-odd';
                    @endphp
                    <tr class="{{ $rowClass }}">
                        <td class="sr-no">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</td>
                        @if(!$customerInfo)
                        <td>
                            <div class="customer-main">{{ $order->customer_name ?? 'N/A' }}</div>
                            <div class="customer-sub">{{ $order->shop_name ?? '-' }}</div>
                        </td>
                        @endif
                        <td class="product-name">{{ $order->product_name ?? '-' }}</td>
                        <td class="qty">{{ number_format($order->order_quantity, 0) }}</td>
                        <td class="price">&#8377; {{ number_format($order->order_price, 2) }}</td>
                        <td class="amount">&#8377; {{ number_format($order->calculated_total, 2) }}</td>
                        {{-- <td class="status-col">
                            <span class="badge {{ $badgeClass }}">{{ $statusLabel }}</span>
                        </td> --}}
                        <td class="date-col">
                            {{ date('d M Y', strtotime($order->created_at)) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center" style="padding: 20px; color: #a8a29e;">
                            No orders found for the selected period.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- ─── TOTALS SECTION ─────────────────────── -->
        <table class="totals-wrapper">
            <tr>
                <td class="totals-left">
                    <div class="note-box">
                        <strong>Note:</strong><br>
                        &bull; This is a computer-generated receipt and does not require a signature.<br>
                        {{-- &bull; All amounts are in Indian Rupees (&#8377;).<br> --}}
                        &bull; For any queries, contact us at the address mentioned above.
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
                            <td class="t-value">{{ number_format($totalOrderQuantity) }} KG</td>
                        </tr>
                        <tr>
                            <td class="t-label">Sub Total</td>
                            <td class="t-value">&#8377; {{ number_format($totalOrderAmount, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="t-label">Tax / GST</td>
                            <td class="t-value" style="color: #78716c; font-weight: normal;">Included</td>
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
                    This receipt was generated automatically by the Brahmani Farsan Hub system.<br>
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
