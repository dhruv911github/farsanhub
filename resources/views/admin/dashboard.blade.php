@extends('layouts.app')

<style>
/* ── STAT CARDS ─────────────────────────────────── */
.dash-card {
    border-radius: 14px;
    border: none;
    overflow: hidden;
    transition: transform .2s ease, box-shadow .2s ease;
    box-shadow: 0 2px 12px rgba(0,0,0,.07);
}
.dash-card:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(0,0,0,.12); }

.dash-card .icon-box {
    width: 54px; height: 54px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 22px;
    flex-shrink: 0;
}
.dash-card .stat-label { font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: .6px; color: #9ca3af; }
.dash-card .stat-value { font-size: 26px; font-weight: 700; color: #1c1917; line-height: 1.1; margin-top: 4px; }
.dash-card .trend       { font-size: 11.5px; margin-top: 6px; }
.dash-card .trend.up    { color: #10b981; }
.dash-card .trend.down  { color: #ef4444; }
.dash-card .trend.neutral { color: #9ca3af; }

/* ── CHART CARDS ────────────────────────────────── */
.chart-card {
    border-radius: 14px;
    border: none;
    box-shadow: 0 2px 12px rgba(0,0,0,.07);
}
.chart-card .chart-title {
    font-size: 13px; font-weight: 700; text-transform: uppercase;
    letter-spacing: .6px; color: #44403c;
}
.chart-card .chart-sub { font-size: 11px; color: #a8a29e; }

/* ── TABLE CARDS ────────────────────────────────── */
.table-card {
    border-radius: 14px; border: none;
    box-shadow: 0 2px 12px rgba(0,0,0,.07);
}
.table-card .section-label {
    font-size: 12px; font-weight: 700; text-transform: uppercase;
    letter-spacing: .6px; color: #44403c; margin-bottom: 14px;
}
.dash-table { width: 100%; border-collapse: collapse; }
.dash-table th {
    font-size: 14px !important; font-weight: 700; text-transform: uppercase; letter-spacing: .5px;
    color: #a8a29e; padding: 8px 10px; border-bottom: 2px solid #f5f5f4;
}
.dash-table td { font-size: 12px; color: #292524; padding: 10px 10px; border-bottom: 1px solid #f5f5f4; vertical-align: middle; }
.dash-table tr:last-child td { border-bottom: none; }
.dash-table .main-text { font-weight: 600; color: #1c1917; }
.dash-table .sub-text  { font-size: 10.5px; color: #a8a29e; margin-top: 1px; }
.dash-table .amt       { font-weight: 700; color: #d97706; }

/* ── TOP CUSTOMER LIST ──────────────────────────── */
.cust-row {
    display: flex; align-items: center; gap: 12px;
    padding: 9px 0; border-bottom: 1px solid #f5f5f4;
}
.cust-row:last-child { border-bottom: none; }
.cust-avatar {
    width: 36px; height: 36px; border-radius: 50%;
    background: #fef3c7; color: #92400e;
    font-size: 13px; font-weight: 700;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.cust-name  { font-size: 12.5px; font-weight: 600; color: #1c1917; }
.cust-shop  { font-size: 10.5px; color: #a8a29e; }
.cust-badge {
    margin-left: auto; background: #fef3c7; color: #92400e;
    font-size: 10px; font-weight: 700; padding: 3px 9px;
    border-radius: 20px; white-space: nowrap;
}

/* ── PRODUCT BAR ────────────────────────────────── */
.prod-row { margin-bottom: 14px; }
.prod-row:last-child { margin-bottom: 0; }
.prod-label { display: flex; justify-content: space-between; margin-bottom: 4px; }
.prod-label span:first-child { font-size: 12px; font-weight: 600; color: #292524; }
.prod-label span:last-child  { font-size: 11px; color: #a8a29e; }
.prod-bar-wrap { height: 8px; background: #f5f5f4; border-radius: 99px; overflow: hidden; }
.prod-bar-fill { height: 100%; border-radius: 99px; background: linear-gradient(90deg, #d97706, #fbbf24); }

/* ── MONTH BADGE ────────────────────────────────── */
.month-badge {
    display: inline-block; padding: 3px 10px; border-radius: 20px;
    background: #fef3c7; color: #92400e; font-size: 10.5px; font-weight: 600;
}

/* ── AMBER ACCENT ───────────────────────────────── */
.text-amber { color: #d97706; }
.bg-amber-soft { background: #fef3c7; }
.border-amber  { border-color: #fcd34d !important; }
</style>

@section('content')

{{-- ── PAGE HEADER ──────────────────────────────────── --}}
<div class="page-header d-flex flex-wrap justify-content-between align-items-center my-0">
    <div class="d-flex align-items-center gap-2">
        <h1 class="page-title">{{ @trans('messages.dashboard') }}</h1>
        <span class="month-badge d-inline-block">{{ now()->format('F Y') }}</span>
    </div>
    <div class="ms-auto pageheader-btn d-none d-xl-flex d-lg-flex mt-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </div>
</div>

{{-- ── ROW 1 : STAT CARDS ───────────────────────────── --}}
<div class="row g-3 mb-3">

    {{-- Customers --}}
    <div class="col-12 col-md-6 col-xl-3">
        <div class="card dash-card p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="icon-box" style="background:#dbeafe;">
                    <i class="fa fa-users" style="color:#3b82f6;"></i>
                </div>
                <div>
                    <div class="stat-label">Customers</div>
                    <div class="stat-value">{{ number_format($totalCustomers) }}</div>
                </div>
            </div>
            <div class="trend neutral mt-2">
                <i class="fa fa-circle"></i> All time total
            </div>
        </div>
    </div>

    {{-- Orders --}}
    <div class="col-12 col-md-6 col-xl-3">
        <div class="card dash-card p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="icon-box" style="background:#fef3c7;">
                    <i class="fa fa-shopping-bag" style="color:#d97706;"></i>
                </div>
                <div>
                    <div class="stat-label">Total Orders</div>
                    <div class="stat-value">{{ number_format($totalOrders) }}</div>
                </div>
            </div>
            @php
                $orderDiff = $thisMonthOrders - $lastMonthOrders;
                $orderTrend = $orderDiff > 0 ? 'up' : ($orderDiff < 0 ? 'down' : 'neutral');
                $orderIcon  = $orderDiff > 0 ? 'fa-arrow-up' : ($orderDiff < 0 ? 'fa-arrow-down' : 'fa-minus');
            @endphp
            <div class="trend {{ $orderTrend }} mt-2">
                <i class="fa {{ $orderIcon }}"></i>
                {{ $thisMonthOrders }} this month
                @if($lastMonthOrders > 0)
                    ({{ $orderDiff >= 0 ? '+' : '' }}{{ $orderDiff }} vs last month)
                @endif
            </div>
        </div>
    </div>

    {{-- Products --}}
    <div class="col-12 col-md-6 col-xl-3">
        <div class="card dash-card p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="icon-box" style="background:#d1fae5;">
                    <i class="fa fa-cube" style="color:#10b981;"></i>
                </div>
                <div>
                    <div class="stat-label">Products</div>
                    <div class="stat-value">{{ number_format($totalProducts) }}</div>
                </div>
            </div>
            <div class="trend neutral mt-2">
                <i class="fa fa-circle"></i> All time total
            </div>
        </div>
    </div>

    {{-- This Month Revenue --}}
    <div class="col-12 col-md-6 col-xl-3">
        <div class="card dash-card p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="icon-box" style="background:#fce7f3;">
                    <i class="fa fa-inr" style="color:#db2777;"></i>
                </div>
                <div>
                    <div class="stat-label">This Month Revenue</div>
                    <div class="stat-value" style="font-size:20px;">&#8377; {{ number_format($thisMonthRevenue, 0) }}</div>
                </div>
            </div>
            @php
                $revDiff = $thisMonthRevenue - $lastMonthRevenue;
                $revTrend = $revDiff > 0 ? 'up' : ($revDiff < 0 ? 'down' : 'neutral');
                $revIcon  = $revDiff > 0 ? 'fa-arrow-up' : ($revDiff < 0 ? 'fa-arrow-down' : 'fa-minus');
                $revPct   = $lastMonthRevenue > 0 ? round(abs($revDiff) / $lastMonthRevenue * 100, 1) : 0;
            @endphp
            <div class="trend {{ $revTrend }} mt-2">
                <i class="fa {{ $revIcon }}"></i>
                @if($revPct > 0)
                    {{ $revPct }}% {{ $revDiff >= 0 ? 'more' : 'less' }} than last month
                @else
                    Same as last month
                @endif
            </div>
        </div>
    </div>

</div>

{{-- ── ROW 2 : CHARTS ───────────────────────────────── --}}
<div class="row g-3 mb-3">

    {{-- Monthly Revenue + Orders (area chart) --}}
    <div class="col-12 col-xl-8">
        <div class="card chart-card p-4 h-100">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <div class="chart-title">Monthly Overview</div>
                    <div class="chart-sub">Revenue &amp; order count — last 6 months</div>
                </div>
                <div class="d-flex gap-2 flex-wrap justify-content-end">
                    <span style="font-size:11px;"><span style="display:inline-block;width:10px;height:10px;border-radius:50%;background:#d97706;margin-right:4px;"></span>Revenue</span>
                    <span style="font-size:11px;"><span style="display:inline-block;width:10px;height:10px;border-radius:50%;background:#3b82f6;margin-right:4px;"></span>Orders</span>
                </div>
            </div>
            <div style="position:relative; height:260px;">
                <canvas id="monthlyChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Top Products doughnut --}}
    <div class="col-12 col-xl-4">
        <div class="card chart-card p-4 h-100">
            <div class="chart-title mb-1">Top Products</div>
            <div class="chart-sub mb-3">By total quantity (KG)</div>
            <div style="position:relative; height:200px; display:flex; justify-content:center;">
                <canvas id="productChart"></canvas>
            </div>
            {{-- Legend --}}
            @php $donutColors = ['#d97706','#3b82f6','#10b981','#8b5cf6','#ef4444']; @endphp
            <div class="mt-3">
                @foreach($topProducts as $i => $p)
                <div class="prod-row">
                    <div class="prod-label">
                        <span>{{ $p->product_name }}</span>
                        <span>{{ number_format($p->total_qty, 0) }} KG</span>
                    </div>
                    @php $maxQty = $topProducts->max('total_qty'); @endphp
                    <div class="prod-bar-wrap">
                        <div class="prod-bar-fill" style="width:{{ $maxQty > 0 ? round($p->total_qty / $maxQty * 100) : 0 }}%; background:{{ $donutColors[$i % 5] }};"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

</div>

{{-- ── ROW 3 : RECENT ORDERS + TOP CUSTOMERS ───────── --}}
<div class="row g-3 mb-3">

    {{-- Recent Orders table --}}
    <div class="col-12 col-xl-7">
        <div class="card table-card p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="section-label mb-0">Recent Orders</div>
                <a href="{{ route('admin.order.index') }}" class="btn btn-secondary flex-shrink-0 d-none d-md-flex align-items-center gap-1" style="font-size:11px;">View All</a>
            </div>
            <div class="table-responsive">
                <table class="dash-table mb-2">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Product</th>
                            <th class="text-center text-nowrap">Qty (KG)</th>
                            <th class="text-end">Amount</th>
                            <th class="text-end">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                        <tr>
                            <td>
                                <div class="main-text">{{ $order->customer_name }}</div>
                                <div class="sub-text">{{ $order->shop_name }}</div>
                            </td>
                            <td>{{ $order->product_name }}</td>
                            <td class="text-center">{{ number_format($order->order_quantity, 0) }}</td>
                            <td class="text-center amt">&#8377; {{ number_format($order->calculated_total, 0) }}</td>
                            <td class="text-end" style="font-size:11px; color:#a8a29e; white-space:nowrap;">{{ $order->display_date }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center" style="color:#a8a29e; padding:24px 0;">No orders yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Top Customers --}}
    <div class="col-12 col-xl-5">
        <div class="card table-card p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="section-label mb-0">Top Customers</div>
                <a href="{{ route('admin.customer.index') }}" class="btn btn-secondary flex-shrink-0 d-none d-md-flex align-items-center gap-1" style="font-size:11px;">View All</a>
            </div>
            @forelse($topCustomers as $c)
            <div class="cust-row">
                <div class="cust-avatar">{{ strtoupper(substr($c->customer_name, 0, 1)) }}</div>
                <div>
                    <div class="cust-name">{{ $c->customer_name }}</div>
                    <div class="cust-shop">{{ $c->shop_name }} &bull; {{ number_format($c->total_qty, 0) }} KG</div>
                </div>
                <div class="cust-badge">{{ $c->order_count }} orders</div>
            </div>
            @empty
            <div style="color:#a8a29e; font-size:13px; text-align:center; padding:24px 0;">No customers yet.</div>
            @endforelse
        </div>
    </div>

</div>

{{-- ── ROW 4 : QUANTITY BAR CHART ───────────────────── --}}
<div class="row g-3 mb-4">
    <div class="col-12">
        <div class="card chart-card p-4">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <div class="chart-title">Monthly Quantity Dispatched</div>
                    <div class="chart-sub">Total KG dispatched per month — last 6 months</div>
                </div>
            </div>
            <div style="position:relative; height:200px;">
                <canvas id="quantityChart"></canvas>
            </div>
        </div>
    </div>
</div>

{{-- ── CHART.JS ─────────────────────────────────────── --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    const labels   = {!! json_encode($chartLabels) !!};
    const orders   = {!! json_encode($chartOrders) !!};
    const revenue  = {!! json_encode($chartRevenue) !!};
    const quantity = {!! json_encode($chartQuantity) !!};

    // ── Monthly Overview (Revenue + Orders, dual-axis) ──────────
    const ctx1 = document.getElementById('monthlyChart').getContext('2d');
    const revGrad = ctx1.createLinearGradient(0, 0, 0, 260);
    revGrad.addColorStop(0, 'rgba(217,119,6,.25)');
    revGrad.addColorStop(1, 'rgba(217,119,6,0)');

    new Chart(ctx1, {
        type: 'line',
        data: {
            labels,
            datasets: [
                {
                    label: 'Revenue (₹)',
                    data: revenue,
                    borderColor: '#d97706',
                    backgroundColor: revGrad,
                    borderWidth: 2.5,
                    fill: true,
                    tension: .4,
                    pointBackgroundColor: '#d97706',
                    pointRadius: 4,
                    yAxisID: 'yRev',
                },
                {
                    label: 'Orders',
                    data: orders,
                    borderColor: '#3b82f6',
                    backgroundColor: 'transparent',
                    borderWidth: 2,
                    fill: false,
                    tension: .4,
                    pointBackgroundColor: '#3b82f6',
                    pointRadius: 4,
                    borderDash: [5,3],
                    yAxisID: 'yOrd',
                },
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => ctx.dataset.yAxisID === 'yRev'
                            ? ' ₹ ' + Number(ctx.raw).toLocaleString('en-IN')
                            : ' ' + ctx.raw + ' orders'
                    }
                }
            },
            scales: {
                yRev: {
                    position: 'left',
                    grid: { color: '#f5f5f4' },
                    ticks: { font: { size: 10 }, callback: v => '₹' + (v >= 1000 ? (v/1000).toFixed(0)+'k' : v) }
                },
                yOrd: {
                    position: 'right',
                    grid: { drawOnChartArea: false },
                    ticks: { font: { size: 10 }, precision: 0 }
                },
                x: { grid: { display: false }, ticks: { font: { size: 11 } } }
            }
        }
    });

    // ── Top Products Doughnut ────────────────────────────────────
    const prodNames = {!! json_encode($topProducts->pluck('product_name')) !!};
    const prodQtys  = {!! json_encode($topProducts->pluck('total_qty')) !!};
    const donutColors = ['#d97706','#3b82f6','#10b981','#8b5cf6','#ef4444'];

    new Chart(document.getElementById('productChart'), {
        type: 'doughnut',
        data: {
            labels: prodNames,
            datasets: [{
                data: prodQtys,
                backgroundColor: donutColors,
                borderWidth: 2,
                borderColor: '#fff',
                hoverOffset: 6,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: { label: ctx => ' ' + ctx.label + ': ' + ctx.raw + ' KG' }
                }
            }
        }
    });

    // ── Monthly Quantity Bar ────────────────────────────────────
    const ctx3 = document.getElementById('quantityChart').getContext('2d');
    const qGrad = ctx3.createLinearGradient(0, 0, 0, 200);
    qGrad.addColorStop(0, 'rgba(217,119,6,.85)');
    qGrad.addColorStop(1, 'rgba(251,191,36,.35)');

    new Chart(ctx3, {
        type: 'bar',
        data: {
            labels,
            datasets: [{
                label: 'Quantity (KG)',
                data: quantity,
                backgroundColor: qGrad,
                borderRadius: 6,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: { callbacks: { label: ctx => ' ' + ctx.raw + ' KG' } }
            },
            scales: {
                y: { grid: { color: '#f5f5f4' }, ticks: { font: { size: 10 }, callback: v => v + ' KG' } },
                x: { grid: { display: false }, ticks: { font: { size: 11 } } }
            }
        }
    });
</script>

@endsection
