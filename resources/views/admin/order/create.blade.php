@extends('layouts.app')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">
                {{ @trans('portal.orders') . ' ' . @trans('portal.add') }}
            </h1>
        </div>
        <div class="ms-auto pageheader-btn d-none d-xl-flex d-lg-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.order.index') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ @trans('portal.orders') }}</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <form action="{{ route('admin.order.store') }}" method="POST">
                            @csrf
                            @method('POST')
                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label for="customer" class="form-label">{{ @trans('portal.customer') }} <span class="text-danger">*</span></label>
                                    <select name="customer" id="customer" class="form-control form-select @error('customer') is-invalid @enderror">
                                        <option value="">-- {{ @trans('portal.customer') }} --</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}" {{ $customer->id == old('customer') ? 'selected' : '' }}>
                                                {{ $customer->shop_name ?: $customer->customer_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('customer')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="product" class="form-label">{{ @trans('portal.product') }} <span class="text-danger">*</span></label>
                                    <select name="product" id="product" class="form-control form-select @error('product') is-invalid @enderror">
                                        <option value="">-- {{ @trans('portal.product') }} --</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}" {{ $product->id == old('product') ? 'selected' : '' }}>
                                                {{ $product->product_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('product')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="order_quantity" class="form-label">{{ @trans('portal.order_quantity') }} (kg) <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="number" step="0.01" min="0.01"
                                            class="form-control @error('order_quantity') is-invalid @enderror"
                                            id="order_quantity" name="order_quantity"
                                            value="{{ old('order_quantity') }}" placeholder="e.g. 2.5">
                                        <span class="input-group-text">kg</span>
                                        @error('order_quantity')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="order_date" class="form-label">{{ @trans('portal.date') }} <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('order_date') is-invalid @enderror"
                                        id="order_date" name="order_date"
                                        value="{{ old('order_date', date('Y-m-d', strtotime('+1 day'))) }}">
                                    @error('order_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 d-flex flex-wrap gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-save"></i> {{ @trans('portal.save') }}
                                    </button>
                                    <a href="{{ route('admin.order.index') }}" class="btn btn-secondary">
                                        <i class="fa fa-arrow-left"></i> {{ @trans('portal.cancel') }}
                                    </a>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
