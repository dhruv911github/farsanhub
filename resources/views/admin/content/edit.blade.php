@extends('layouts.app')

@section('content')
<div class="page-header">
        <div>
            <h1 class="page-title">
                {{ @trans('portal.edit') }} {{ @trans('portal.content') }}
            </h1>
        </div>
        <div class="ms-auto pageheader-btn d-none d-xl-flex d-lg-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.contents.index') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ @trans('portal.edit') }} {{ @trans('portal.content') }}</li>
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
                    <form action="{{ route('admin.contents.update', $content) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="image" class="form-label">{{ @trans('portal.poster') }}</label>
                            @if($content->image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $content->image) }}"
                                         alt="{{ $content->name }}"
                                         class="img-thumbnail"
                                         style="max-width: 200px;">
                                </div>
                            @endif
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

                        <div class="mb-3">
                            <label for="upload_date" class="form-label">{{ @trans('portal.date') }}</label>
                            <input type="date"
                                   class="form-control @error('upload_date') is-invalid @enderror"
                                   id="upload_date"
                                   name="upload_date"
                                   value="{{ old('upload_date', $content->upload_date->format('Y-m-d')) }}"
                                   required>
                            @error('upload_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> {{ @trans('portal.update') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
