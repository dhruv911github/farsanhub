@extends('layouts.app')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">
                {{ @trans('portal.employees') . ' ' . @trans('portal.add') }}
            </h1>
        </div>
        <div class="ms-auto pageheader-btn d-none d-xl-flex d-lg-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.employee.index') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ @trans('portal.employees') }}</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <!-- @if ($errors->any())
    <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
                            </ul>
                        </div>
    @endif -->

                        <form action="{{ route('admin.employee.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">{{ @trans('portal.name') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name') }}">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="address" class="form-label">{{ @trans('portal.address') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror"
                                        id="address" name="address" value="{{ old('address') }}">
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="mobile_number" class="form-label">{{ @trans('portal.mobile') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('mobile_number') is-invalid @enderror"
                                        id="mobile_number" name="mobile_number" maxlength="10"
                                        value="{{ old('mobile_number') }}">
                                    @error('mobile_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="adhar_number" class="form-label">{{ @trans('portal.adhar_number') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('adhar_number') is-invalid @enderror"
                                        id="adhar_number" name="adhar_number" maxlength="12"
                                        value="{{ old('adhar_number') }}">
                                    @error('adhar_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">{{ @trans('portal.email') }} </label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email') }}">
                                    @error('email')
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
                                    <label for="salary" class="form-label">{{ @trans('portal.salary') }} (₹)<span
                                            class="text-danger">*</span></label>
                                    <input type="number" step="0.01"
                                        class="form-control @error('salary') is-invalid @enderror" id="salary"
                                        name="salary" value="{{ old('salary') }}" min="0">
                                    @error('salary')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- <div class="mb-3 col-md-6">
                                <label for="comment" class="form-label">{{ @trans('portal.comment') }} <span>*(Max 1000 characters)</span></label>
                                <textarea class="form-control @error('comment') is-invalid @enderror"
                                    id="comment"
                                    name="comment"
                                    rows="3">{{ old('comment') }}</textarea>
                                @error('comment')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div> --}}

                                <div class="mb-3 col-md-6">
                                    <label for="image" class="form-label">{{ @trans('portal.employee_image') }}</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror"
                                        id="image" name="image" accept="image/*">
                                    @error('image')
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
                                    <a href="{{ route('admin.employee.index') }}" class="btn btn-secondary">
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
