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

                        <form action="{{ route('admin.order.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label for="product" class="form-label">{{ @trans('portal.product') }} <span
                                            class="text-danger">*</span></label>
                                    <select name="product" class="form-control form-select me-md-2">
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}"
                                                {{ $product->id == old('product') ? 'selected' : '' }}>
                                                {{ $product->product_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('product')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="order_quantity" class="form-label">{{ @trans('portal.order_quantity') }}
                                        <span class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control @error('order_quantity') is-invalid @enderror"
                                        id="order_quantity" name="order_quantity"
                                        value="{{ old('order_quantity') }}">
                                    @error('order_quantity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
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
    </div>
@endsection
