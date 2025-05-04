@extends('layouts.app')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">
                {{ @trans('portal.products') . ' ' . @trans('portal.add') }}
            </h1>
        </div>
        <div class="ms-auto pageheader-btn d-none d-xl-flex d-lg-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.product.index') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ @trans('portal.products') }}</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label for="product_name" class="form-label">{{ @trans('portal.product_name') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('product_name') is-invalid @enderror"
                                        id="product_name" name="product_name" value="{{ old('product_name') }}">
                                    @error('product_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="product_base_price" class="form-label">{{ @trans('portal.product_base_price') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('product_base_price') is-invalid @enderror"
                                        id="product_base_price" name="product_base_price" value="{{ old('product_base_price') }}">
                                    @error('product_base_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="status" class="form-label">{{ @trans('portal.status') }} <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status"
                                        name="status">
                                        <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>
                                            {{ @trans('portal.active') }}</option>
                                        <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>
                                            {{ @trans('portal.inactive') }}</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="product_image" class="form-label">{{ @trans('portal.product_image') }}</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror"
                                        id="product_image" name="product_image" accept="image/*">
                                    @error('product_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        {{ @trans('portal.accepted_formats') }}
                                    </small>
                                </div>

                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-save"></i> {{ @trans('portal.save') }}
                                    </button>
                                    <a href="{{ route('admin.product.index') }}" class="btn btn-secondary">
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
