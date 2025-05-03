@extends('layouts.app')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">
            {{ @trans('portal.expenses') .' '. @trans('portal.add') }}
        </h1>
    </div>
    <div class="ms-auto pageheader-btn d-none d-xl-flex d-lg-flex">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.expense.index') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ @trans('portal.expenses') }}</li>
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
                        <ul>
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif -->

                    <form action="{{ route('admin.expense.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="amount" class="form-label">{{ @trans('portal.amount') }} (₹)<span
                                        class="text-danger">*</span></label>
                                <input type="number" step="0.01"
                                    class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount"
                                    value="{{ old('amount') }}" min="0">
                                @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="date" class="form-label">{{ @trans('portal.date') }}</label>
                                <input type="date" class="form-control" name="date" id="date" value="{{ old('date') }}">
                                @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ @trans('portal.purpose') }} <span class="text-danger">*</span></label>
                                <select class="form-select @error('purpose') is-invalid @enderror"
                                id="purpose" name="purpose">
                                    <option value="">{{ @trans('portal.select_purpose') }}</option>
                                    <option value="grocery" {{ old('purpose')=='grocery' ? 'selected' : '' }}>{{ @trans('portal.grocery') }}
                                    </option>
                                    <option value="sabji" {{ old('purpose')=='sabji' ? 'selected' : '' }}>{{ @trans('portal.sabji') }}
                                    </option>
                                    <option value="lightbill" {{ old('purpose')=='lightbill' ? 'selected' : '' }}>{{ @trans('portal.lightbill') }}
                                    </option>
                                    <option value="rent" {{ old('purpose')=='rent' ? 'selected' : '' }}>{{ @trans('portal.rent') }}
                                    </option>
                                    <option value="transportation" {{ old('purpose')=='transportation' ? 'selected' : '' }}>{{ @trans('portal.transportation') }}
                                    </option>
                                    <option value="other" {{ old('purpose')=='other' ? 'selected' : '' }}>{{ @trans('portal.other') }}</option>
                                </select>
                                @error('purpose')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3 col-md-6">
                                <label for="comment" class="form-label">{{ @trans('portal.comment') }} <span>*(Max 1000 characters)</span></label>
                                <textarea class="form-control @error('comment') is-invalid @enderror"
                                    id="comment"
                                    name="comment"
                                    rows="3">{{ old('comment') }}</textarea>
                                @error('comment')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> {{ @trans('portal.save') }}
                                </button>
                                <a href="{{ route('admin.expense.index') }}" class="btn btn-secondary">
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
