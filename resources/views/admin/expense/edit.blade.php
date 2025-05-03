@extends('layouts.app')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">
            {{ @trans('portal.expenses') .' '. @trans('portal.edit') }}
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
                    <form action="{{ route('admin.expense.update', $expense) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">

                            <div class="mb-3 col-md-6">
                                <label for="amount" class="form-label">{{ @trans('portal.amount') }} (₹)<span class="text-danger">*</span></label>
                                <input type="number" step="0.01" class="form-control @error('amount') is-invalid @enderror"
                                    id="amount" name="amount" value="{{ old('amount', $expense->amount) }}" required min="0">
                                @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="date" class="form-label">{{ @trans('portal.date') }}</label>
                                <input type="date"
                                    class="form-control @error('date') is-invalid @enderror"
                                    id="date"
                                    name="date"
                                    value="{{ old('date', $expense->date) }}">
                                @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="purpose" class="form-label">{{ @trans('portal.purpose') }}</label>
                                <select class="form-select @error('purpose') is-invalid @enderror"
                                id="purpose"
                                name="purpose"
                                required>
                                <option value="">{{ @trans('portal.purpose') }}</option>
                                <option value="grocery" {{ old('purpose', $expense->purpose) == 'grocery' ? 'selected' : '' }}>{{ @trans('portal.grocery') }}</option>
                                <option value="sabji" {{ old('purpose', $expense->purpose) == 'sabji' ? 'selected' : '' }}>{{ @trans('portal.sabji') }}</option>
                                <option value="lightbill" {{ old('purpose', $expense->purpose) == 'lightbill' ? 'selected' : '' }}>{{ @trans('portal.lightbill') }}</option>
                                <option value="rent" {{ old('purpose', $expense->purpose) == 'rent' ? 'selected' : '' }}>{{ @trans('portal.rent') }}</option>
                                <option value="transportation" {{ old('purpose', $expense->purpose) == 'transportation' ? 'selected' : '' }}>{{ @trans('portal.transportation') }}</option>
                                <option value="other" {{ old('purpose', $expense->purpose) == 'other' ? 'selected' : '' }}>{{ @trans('portal.other') }}</option>
                                </select>
                                @error('purpose')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3 col-md-12">
                                <label for="comment" class="form-label">{{ @trans('portal.comment') }} <span>*(Max 1000 characters)</span></label>
                                <textarea class="form-control @error('comment') is-invalid @enderror"
                                    id="comment"
                                    name="comment"
                                    rows="3">{{ old('comment', $expense->comment) }}</textarea>
                                @error('comment')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> {{ @trans('portal.update') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
