@extends('layouts.app')

@section('content')
<div class="page-header">
        <div>
            <h1 class="page-title">
                {{ @trans('portal.add') }} {{ @trans('portal.content') }}
            </h1>
        </div>
        <div class="ms-auto pageheader-btn d-none d-xl-flex d-lg-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.contents.index') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ @trans('portal.add') }} {{ @trans('portal.content') }}</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <!-- @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif -->

                        <form action="{{ route('admin.contents.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3 col-md-12 col-lg-6">
                                <label for="image" class="form-label">{{ @trans('portal.poster') }}</label>
                                <input type="file"
                                       class="form-control @error('image') is-invalid @enderror"
                                       id="image"
                                       name="image"
                                       accept="image/*">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    {{ @trans('portal.accepted_formats') }}
                                </small>
                            </div>

                            <div class="mb-3 col-md-12 col-lg-6">
                                <label for="upload_date" class="form-label">{{ @trans('portal.date') }}</label>
                                <input type="date"
                                       class="form-control @error('upload_date') is-invalid @enderror"
                                       id="upload_date"
                                       name="upload_date"
                                       value="{{ old('upload_date', date('Y-m-d')) }}">
                                @error('upload_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-12 col-lg-6">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> {{ @trans('portal.save') }}
                                </button>
                            </div>
                            <!-- <div class="mb-3">
                                <a href="{{ route('admin.contents.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Back to List
                                </a>
                            </div> -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
