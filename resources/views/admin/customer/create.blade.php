@extends('layouts.app')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">
                {{ @trans('portal.customers') . ' ' . @trans('portal.add') }}
            </h1>
        </div>
        <div class="ms-auto pageheader-btn d-none d-xl-flex d-lg-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.customer.index') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ @trans('portal.customers') }}</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <form action="{{ route('admin.customer.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label for="customer_name" class="form-label">{{ @trans('portal.customer_name') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('customer_name') is-invalid @enderror"
                                        id="customer_name" name="customer_name" value="{{ old('customer_name') }}">
                                    @error('customer_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="shop_name" class="form-label">{{ @trans('portal.shop_name') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('shop_name') is-invalid @enderror"
                                        id="shop_name" name="shop_name" value="{{ old('shop_name') }}">
                                    @error('shop_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="shop_address" class="form-label">{{ @trans('portal.shop_address') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('shop_address') is-invalid @enderror"
                                        id="shop_address" name="shop_address" value="{{ old('shop_address') }}">
                                    @error('shop_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="customer_number" class="form-label">{{ @trans('portal.mobile') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('customer_number') is-invalid @enderror"
                                        id="customer_number" name="customer_number" maxlength="10"
                                        value="{{ old('customer_number') }}">
                                    @error('customer_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="col-md-6 mb-3">
                                    <label for="customer_email" class="form-label">{{ @trans('portal.customer_email') }} </label>
                                    <input type="email" class="form-control @error('customer_email') is-invalid @enderror"
                                        id="customer_email" name="customer_email" value="{{ old('customer_email') }}">
                                    @error('customer_email')
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

                                <div class="col-md-6 mb-3">
                                    <label for="city" class="form-label">{{ @trans('portal.city') }}<span
                                            class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control @error('city') is-invalid @enderror" id="city"
                                        name="city" value="{{ old('city') }}" min="0">
                                    @error('city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="customer_image" class="form-label">{{ @trans('portal.customer_image') }}</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror"
                                        id="customer_image" name="customer_image" accept="image/*">
                                    @error('customer_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        {{ @trans('portal.accepted_formats') }}
                                    </small>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="shop_image" class="form-label">{{ @trans('portal.shop_image') }}</label>
                                    <input type="file" class="form-control @error('shop_image') is-invalid @enderror"
                                        id="shop_image" name="shop_image" accept="image/*">
                                    @error('shop_image')
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
                                    <a href="{{ route('admin.customer.index') }}" class="btn btn-secondary">
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
