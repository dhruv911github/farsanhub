@extends('layouts.app')

<style>
/* ── Base card ─────────────────────────────────── */
.rpt-card {
    border: none;
    border-radius: 14px;
    box-shadow: 0 1px 12px rgba(0,0,0,0.08);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    height: 100%;
    transition: transform 0.18s ease, box-shadow 0.18s ease;
}
.rpt-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 28px rgba(255,153,51,0.18);
}

/* ── Colored top stripe ─────────────────────────── */
.rpt-stripe {
    height: 5px;
    width: 100%;
    background: linear-gradient(90deg, #e07a1a, #FF9933, #ffb366);
}

/* ── Card inner layout ──────────────────────────── */
.rpt-head {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 18px 20px 14px;
}
.rpt-icon {
    width: 52px; height: 52px;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.4rem;
    flex-shrink: 0;
    background: #FFF7EE;
    color: #FF9933;
}
.rpt-title {
    font-size: 1.02rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0 0 3px;
    line-height: 1.2;
}
.rpt-sub {
    font-size: 0.76rem;
    color: #94a3b8;
    margin: 0;
}
.rpt-divider { border: none; border-top: 1px solid #fff3e0; margin: 0; }
.rpt-body {
    padding: 18px 20px 20px;
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

/* ── Form controls ──────────────────────────────── */
.rpt-select {
    border-radius: 9px;
    border: 1.5px solid #ffe0b2;
    font-size: 0.84rem;
    padding: 0.42rem 0.8rem;
    color: #374151;
    background-color: #fff8f0;
    width: 100%;
    transition: border-color 0.15s, box-shadow 0.15s;
}
.rpt-select:focus {
    border-color: #FF9933;
    box-shadow: 0 0 0 3px rgba(255,153,51,0.15);
    outline: none;
    background: #fff;
}
.rpt-label {
    font-size: 0.76rem;
    font-weight: 600;
    color: #e07a1a;
    letter-spacing: 0.04em;
    text-transform: uppercase;
    margin-bottom: 5px;
    display: block;
}

/* ── Export buttons ─────────────────────────────── */
.rpt-btn-row { display: flex; gap: 8px; flex-wrap: wrap; margin-top: auto; padding-top: 14px; }
.rpt-btn {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 7px 18px;
    border-radius: 9px;
    font-size: 0.82rem; font-weight: 600;
    border: none; cursor: pointer;
    transition: filter 0.15s, transform 0.1s;
    letter-spacing: 0.01em;
}
.rpt-btn:hover  { filter: brightness(1.08); transform: scale(1.02); }
.rpt-btn:active { transform: scale(0.97); }
.rpt-btn-excel {
    background: #FF9933;
    color: #fff;
}
.rpt-btn-pdf {
    background: #fff;
    color: #FF9933;
    border: 1.5px solid #FF9933;
}
.rpt-btn-pdf:hover {
    background: #FFF7EE;
}

/* ── Section label ──────────────────────────────── */
.section-eyebrow {
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: #94a3b8;
    margin-bottom: 4px;
}

/* ── Responsive ─────────────────────────────────── */
@media (max-width: 575.98px) {
    .rpt-head { padding: 14px 16px 10px; }
    .rpt-body { padding: 14px 16px 16px; }
    .rpt-icon { width: 44px; height: 44px; font-size: 1.15rem; }
    .rpt-btn  { padding: 7px 12px; font-size: 0.79rem; }
}
</style>

@section('content')

<div class="page-header d-flex flex-wrap justify-content-between align-items-center my-0 mb-3">
    <div>
        <p class="section-eyebrow mb-0">Data Export</p>
        <h1 class="page-title mb-0">{{ @trans('portal.reports') }}</h1>
    </div>
    <div class="ms-auto pageheader-btn d-none d-xl-flex d-lg-flex mt-2">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.monthly-report.index') }}">Home</a></li>
            <li class="breadcrumb-item active">{{ @trans('portal.reports') }}</li>
        </ol>
    </div>
</div>

{{-- ═══════════════════════════════════════════════
     ROW 1 — Orders + Expenses (filter cards)
════════════════════════════════════════════════ --}}
<div class="row g-3 mb-3">

    {{-- SALES ORDERS --}}
    <div class="col-12 col-lg-4">
        <div class="card rpt-card">
            <div class="rpt-stripe"></div>
            <div class="rpt-head">
                <div class="rpt-icon"><i class="fa fa-shopping-cart"></i></div>
                <div>
                    <p class="rpt-title">{{ trans('portal.orders') }}</p>
                    <p class="rpt-sub">Filter by customer &amp; month, then export</p>
                </div>
            </div>
            <hr class="rpt-divider">
            <div class="rpt-body">
                <form action="{{ route('admin.monthly-report.order') }}" method="GET">
                    <div class="mb-3">
                        <label class="rpt-label">{{ trans('portal.customer') }}</label>
                        <select name="customer_id" class="rpt-select">
                            <option value="">— {{ trans('portal.select_customer') }} —</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->customer_name }} · {{ $customer->shop_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="rpt-label">{{ trans('portal.select_month_year') }}</label>
                        <select name="month_year" class="rpt-select">
                            <option value="">— {{ trans('portal.select_month_year') }} —</option>
                            @foreach ($orderMonths as $month)
                                <option value="{{ $month['value'] }}" {{ old('month_year') == $month['value'] ? 'selected' : '' }}>
                                    {{ $month['label'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="rpt-btn-row">
                        <button type="button" id="orderExcelBtn" class="rpt-btn rpt-btn-excel">
                            <i class="fa fa-file-excel-o"></i> Excel
                        </button>
                        <button type="button" id="pdfExportBtn" class="rpt-btn rpt-btn-pdf">
                            <i class="fa fa-file-pdf-o"></i> PDF
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- EXPENSES --}}
    <div class="col-12 col-lg-4">
        <div class="card rpt-card">
            <div class="rpt-stripe"></div>
            <div class="rpt-head">
                <div class="rpt-icon"><i class="fa fa-money"></i></div>
                <div>
                    <p class="rpt-title">{{ trans('portal.expenses') }}</p>
                    <p class="rpt-sub">Filter by month, then export</p>
                </div>
            </div>
            <hr class="rpt-divider">
            <div class="rpt-body">
                <form action="{{ route('admin.monthly-report.expense') }}" method="GET">
                    <div class="mb-3">
                        <label class="rpt-label">{{ trans('portal.select_month_year') }}</label>
                        <select name="month_year" class="rpt-select">
                            <option value="">— {{ trans('portal.select_month_year') }} —</option>
                            @foreach ($expenseMonths as $month)
                                <option value="{{ $month['value'] }}" {{ old('month_year') == $month['value'] ? 'selected' : '' }}>
                                    {{ $month['label'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="rpt-btn-row">
                        <button type="submit" name="export_type" value="excel" class="rpt-btn rpt-btn-excel">
                            <i class="fa fa-file-excel-o"></i> Excel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

{{-- ═══════════════════════════════════════════════
     ROW 2 — Customers + Products (quick export)
════════════════════════════════════════════════ --}}
<div class="row g-3">

    {{-- CUSTOMERS --}}
    <div class="col-12 col-lg-4">
        <div class="card rpt-card">
            <div class="rpt-stripe"></div>
            <div class="rpt-head">
                <div class="rpt-icon"><i class="fa fa-users"></i></div>
                <div>
                    <p class="rpt-title">{{ trans('portal.customers') }}</p>
                    <p class="rpt-sub">Export your full customer list</p>
                </div>
            </div>
            <hr class="rpt-divider">
            <div class="rpt-body">
                <form action="{{ route('admin.monthly-report.customer') }}" method="GET">
                    <p class="text-muted mb-3" style="font-size:0.82rem;">
                        Download all customer records including name, shop, city and contact info.
                    </p>
                    <div class="rpt-btn-row">
                        <button type="submit" name="export_type" value="excel" class="rpt-btn rpt-btn-excel">
                            <i class="fa fa-file-excel-o"></i> Excel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- PRODUCTS --}}
    <div class="col-12 col-lg-4">
        <div class="card rpt-card">
            <div class="rpt-stripe"></div>
            <div class="rpt-head">
                <div class="rpt-icon"><i class="fa fa-cubes"></i></div>
                <div>
                    <p class="rpt-title">{{ trans('portal.products') }}</p>
                    <p class="rpt-sub">Export your full product catalogue</p>
                </div>
            </div>
            <hr class="rpt-divider">
            <div class="rpt-body">
                <form action="{{ route('admin.monthly-report.product') }}" method="GET">
                    <p class="text-muted mb-3" style="font-size:0.82rem;">
                        Download all products with name, base price, unit and status.
                    </p>
                    <div class="rpt-btn-row">
                        <button type="submit" name="export_type" value="excel" class="rpt-btn rpt-btn-excel">
                            <i class="fa fa-file-excel-o"></i> Excel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

{{-- ── JS ────────────────────────────────────────────── --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const orderWarning = Swal.mixin({
        toast: true, position: 'top-end', showConfirmButton: false, timer: 3500
    });

    function submitOrderForm(exportType) {
        const form = document.getElementById('orderExcelBtn').closest('form');
        const monthYear = form.querySelector('select[name="month_year"]').value;

        if (!monthYear) {
            orderWarning.fire({ icon: 'warning', text: 'Please select a month and year before exporting.' });
            return;
        }

        const input = document.createElement('input');
        input.type  = 'hidden';
        input.name  = 'export_type';
        input.value = exportType;
        form.appendChild(input);
        form.submit();
    }

    document.getElementById('orderExcelBtn').addEventListener('click', function () { submitOrderForm('excel'); });
    document.getElementById('pdfExportBtn').addEventListener('click',  function () { submitOrderForm('pdf');   });
</script>

@if (session()->has('success'))
<script>
    Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 3000 })
        .fire({ icon: 'success', text: {!! json_encode(session('success')) !!} });
</script>
@endif
@if (session()->has('error'))
<script>
    Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 3000 })
        .fire({ icon: 'error', text: {!! json_encode(session('error')) !!} });
</script>
@endif

@endsection
