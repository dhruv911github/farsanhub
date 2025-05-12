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
        {{-- <div class="col-sm-12 col-md-6 col-lg-3 mb-2">
            <div class="card ">
                <div class="card-body">
                    <form action="{{ route('admin.monthly-report.expense') }}" method="GET"
                        enctype="multipart/form-data">
                        <div class="mb-3">
                            <label>{{ trans('messages.expense') }}</label>
                            <select name="month_year" class="form-control form-select me-md-2">
                                @foreach ($expenseMonths as $month)
                                    <option value="{{ $month->value }}"
                                        {{ $month->value == $selectedMonthYear ? 'selected' : '' }}>
                                        {{ $month->label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-3">
                            <input type="submit" class="btn btn-primary" value="{{ trans('portal.export') }}">
                        </div>
                    </form>
                </div>
            </div>
        </div> --}}
       
        <div class="col-sm-12 col-md-6 col-lg-3 mb-2">
            <div class="card ">
                <div class="card-body">
                    <form action="{{ route('admin.monthly-report.customer') }}" method="GET"
                        enctype="multipart/form-data">
                        <div class="mb-3">
                            <label>{{ trans('portal.customers') }}</label>
                            {{-- <select name="month_year" class="form-control form-select me-md-2">
                                @foreach ($contactMonths as $month)
                                    <option value="{{ $month->value }}"
                                        {{ $month->value == $selectedMonthYear ? 'selected' : '' }}>
                                        {{ $month->label }}
                                    </option>
                                @endforeach
                            </select> --}}
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-3">
                            <input type="submit" class="btn btn-primary" value="{{ trans('portal.export') }}">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-6 col-lg-3 mb-2">
            <div class="card ">
                <div class="card-body">
                    <form action="{{ route('admin.monthly-report.product') }}" method="GET"
                        enctype="multipart/form-data">
                        <div class="mb-3">
                            <label>{{ trans('portal.products') }}</label>
                            {{-- <select name="month_year" class="form-control form-select me-md-2">
                                @foreach ($contactMonths as $month)
                                    <option value="{{ $month->value }}"
                                        {{ $month->value == $selectedMonthYear ? 'selected' : '' }}>
                                        {{ $month->label }}
                                    </option>
                                @endforeach
                            </select> --}}
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-3">
                            <input type="submit" class="btn btn-primary" value="{{ trans('portal.export') }}">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-6 col-lg-3 mb-2">
            <div class="card ">
                <div class="card-body">
                    <form action="{{ route('admin.monthly-report.order') }}" method="GET"
                        enctype="multipart/form-data">
                        <div class="mb-3">
                            <label>{{ trans('portal.orders') }}</label>
                            <select name="customer_id" class="form-control form-select me-md-2 mb-3">
                                <option value="">{{ trans('portal.select_customer') }}</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}">
                                        {{ $customer->customer_name }} - {{ $customer->shop_name }}
                                    </option>
                                @endforeach
                            </select>
                            
                            <select name="month_year" class="form-control form-select me-md-2">
                                <option value="">{{ trans('portal.select_month_year') }}</option>
                                @foreach ($orderMonths as $month)
                                    <option value="{{ $month->value }}">
                                        {{ $month->label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-3">
                            <input type="submit" class="btn btn-primary" value="{{ trans('portal.export') }}">
                        </div>
                    </form>
                </div>
            </div>
        </div>
       
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
