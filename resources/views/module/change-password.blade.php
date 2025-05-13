@extends('layouts.app')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">
            {{ @trans('portal.change_password') }}
        </h1>
    </div>
    <div class="ms-auto pageheader-btn d-none d-xl-flex d-lg-flex">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ @trans('portal.change_password') }}</li>
        </ol>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
            @if(session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session()->has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
                <div class="card-body">
                    <form id="frmAddEditUser" method="post" action="{{ route('admin.changePassword.save') }}">
                        @csrf
                        <div class="form-body row">
                            <!-- Current Password Field -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="current_password">{{ @trans('messages.current_password') }}
                                        <span class="required">*</span></label>
                                    <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" placeholder="Enter Password" value="{{ old('current_password') }}" />

                                    <!-- Validation Error for Current Password -->
                                    @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-6"></div>

                            <!-- New Password Field -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="password">{{ @trans('messages.new_password') }}
                                        <span class="required">*</span></label>
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter Password" value="{{ old('password') }}" />

                                    <!-- Validation Error for New Password -->
                                    @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Confirm New Password Field -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="password_confirmation">{{ @trans('messages.confirm_new_password') }}
                                        <span class="required">*</span></label>
                                    <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Enter Password Again" value="{{ old('password_confirmation') }}" />

                                    <!-- Validation Error for Password Confirmation -->
                                    @error('password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="col-md-12">
                                <input type="submit" class="btn step-btn" value="{{ @trans('messages.save') }}">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('pageJs')
{!! JsValidator::formRequest('App\Http\Requests\Admin\ChangePasswordRequest', '#frmAddEditUser') !!}
@endpush

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session()->has('success'))
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
