@extends('layouts.app')

@section('content')
    <div class="page-header d-flex flex-wrap justify-content-between align-items-center my-0">
        <div>
            <h1 class="page-title">{{ @trans('portal.reports') }}</h1>
        </div>
        <div class="ms-auto pageheader-btn d-none d-xl-flex d-lg-flex mt-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.monthly-report.index') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ @trans('portal.reports') }}</li>
            </ol>
        </div>
    </div>

    <div class="row">

        <div class="col-sm-12 col-md-6 col-lg-4 mb-2">
            <div class="card ">
                <div class="card-body">
                    <form action="{{ route('admin.monthly-report.order') }}" method="GET" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label>{{ trans('portal.orders') }}</label>
                            <select name="customer_id" class="form-control form-select me-md-2 mb-3">
                                <option value="">{{ trans('portal.select_customer') }}</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}"
                                        {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->customer_name }} - {{ $customer->shop_name }}
                                    </option>
                                @endforeach
                            </select>

                            <select name="month_year" class="form-control form-select me-md-2">
                                <option value="">{{ trans('portal.select_month_year') }}</option>
                                @foreach ($orderMonths as $month)
                                    <option value="{{ $month['value'] }}"
                                        {{ old('month_year') == $month['value'] ? 'selected' : '' }}>
                                        {{ $month['label'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6 ps-0 d-flex gap-2">

                            <!-- Excel Button -->
                            <button type="button" id="orderExcelBtn" class="btn btn-primary" title="Export Excel">
                                <i class="fa fa-file-excel-o"></i>
                            </button>

                            <!-- PDF Button -->
                            <button type="button" id="pdfExportBtn" class="btn btn-secondary" title="Export PDF">
                                <i class="fa fa-file-pdf-o"></i>
                            </button>

                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-6 col-lg-2 mb-2">
            <div class="card ">
                <div class="card-body">
                    <form action="{{ route('admin.monthly-report.customer') }}" method="GET"
                        enctype="multipart/form-data">
                        <div>
                            <label>{{ trans('portal.customers') }}</label>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6 ps-0 d-flex gap-2">

                            <!-- Excel Button -->
                            <button type="submit" name="export_type" value="excel" class="btn btn-primary"
                                title="Export Excel">
                                <i class="fa fa-file-excel-o"></i>
                            </button>

                            <!-- PDF Button -->
                            {{-- <button type="submit" name="export_type" value="pdf" class="btn btn-secondary"
                                title="Export PDF">
                                <i class="fa fa-file-pdf-o"></i>
                            </button> --}}

                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-6 col-lg-2 mb-2">
            <div class="card ">
                <div class="card-body">
                    <form action="{{ route('admin.monthly-report.product') }}" method="GET"
                        enctype="multipart/form-data">
                        <div>
                            <label>{{ trans('portal.products') }}</label>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6 ps-0 d-flex gap-2">

                            <!-- Excel Button -->
                            <button type="submit" name="export_type" value="excel" class="btn btn-primary"
                                title="Export Excel">
                                <i class="fa fa-file-excel-o"></i>
                            </button>

                            <!-- PDF Button -->
                            {{-- <button type="submit" name="export_type" value="pdf" class="btn btn-secondary"
                                title="Export PDF">
                                <i class="fa fa-file-pdf-o"></i>
                            </button> --}}

                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            const orderWarning = Swal.mixin({
                toast: true, position: 'top-end', showConfirmButton: false, timer: 3500
            });

            function submitOrderForm(exportType) {
                const form = document.getElementById('orderExcelBtn').closest('form');
                const monthYear = form.querySelector('select[name="month_year"]').value;

                if (!monthYear) {
                    orderWarning.fire({
                        icon: 'warning',
                        text: 'Please select a month and year before exporting.'
                    });
                    return;
                }

                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'export_type';
                input.value = exportType;
                form.appendChild(input);
                form.submit();
            }

            document.getElementById('orderExcelBtn').addEventListener('click', function () {
                submitOrderForm('excel');
            });

            document.getElementById('pdfExportBtn').addEventListener('click', function () {
                submitOrderForm('pdf');
            });
        </script>
        @if (session()->has('success'))
            <script>
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                })
                Toast.fire({
                    icon: 'success',
                    text: "{{ session('success') }}",
                })
            </script>
        @endif

        @if (session()->has('error'))
            <script>
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                })
                Toast.fire({
                    icon: 'error',
                    text: "{{ session('error') }}",
                })
            </script>
        @endif
    @endsection
