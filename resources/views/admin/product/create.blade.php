@extends('layouts.app')

<style>
    .table-responsive {
        max-height: 400px;
        overflow-y: auto;
    }
    @media (max-width: 576px) {
        .input-group-text { padding: 0.375rem 0.5rem; font-size: 0.8rem; }
        .form-control { font-size: 0.9rem; }
    }
</style>

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
                                    <label for="product_name" class="form-label">{{ @trans('portal.product_name') }} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('product_name') is-invalid @enderror"
                                        id="product_name" name="product_name" value="{{ old('product_name') }}">
                                    @error('product_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="product_base_price" class="form-label">{{ @trans('portal.product_base_price') }} <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa fa-rupee"></i></span>
                                        <input type="number" step="0.01" min="0"
                                            class="form-control @error('product_base_price') is-invalid @enderror"
                                            id="product_base_price" name="product_base_price" value="{{ old('product_base_price') }}"
                                            placeholder="0.00">
                                        <select id="unit" name="unit" class="input-group-text form-select ps-0" style="max-width:100px; border-left:1px solid #ced4da;">
                                            <option value="kg"   {{ old('unit', 'kg') == 'kg'   ? 'selected' : '' }}>/ kg</option>
                                            <option value="Nang" {{ old('unit') == 'Nang' ? 'selected' : '' }}>/ Nang</option>
                                        </select>
                                        @error('product_base_price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="status" class="form-label">{{ @trans('portal.status') }} <span class="text-danger">*</span></label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                        <option value="">-- {{ @trans('portal.status') }} --</option>
                                        <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>{{ @trans('portal.active') }}</option>
                                        <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>{{ @trans('portal.inactive') }}</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="product_image" class="form-label">{{ @trans('portal.product_image') }}</label>
                                    <input type="file" class="form-control @error('product_image') is-invalid @enderror"
                                        id="product_image" name="product_image" accept="image/*"
                                        onchange="previewImage(this, 'product_image_preview')">
                                    @error('product_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">{{ @trans('portal.accepted_formats') }}</small>
                                    <div class="mt-2">
                                        <img id="product_image_preview" src="#" alt="Preview" class="img-thumbnail d-none" style="max-width:200px;">
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-8 col-lg-6 mb-3">
                                    <h4 class="mb-3 text-danger border-bottom pb-2">{{ @trans('portal.customer_specific_pricing') }}</h4>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped align-items-center">
                                            <thead>
                                                <tr>
                                                    <!-- <th width="40%">{{ @trans('portal.customer') }}</th> -->
                                                    <th width="30%" class="text-nowrap">{{ @trans('portal.shop_name') }}</th>
                                                    <th width="70%" class="text-nowrap">{{ @trans('portal.price') }} (₹)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($customers as $customer)
                                                    <tr>
                                                        <!-- <td>{{ $customer->customer_name }}</td> -->
                                                        <td>{{ $customer->shop_name }}</td>
                                                        <td>
                                                            <div class="input-group">
                                                                <input type="number" step="0.01" min="0"
                                                                    class="form-control"
                                                                    name="customer_prices[{{ $customer->id }}]"
                                                                    value="{{ old('customer_prices.' . $customer->id) }}"
                                                                    placeholder="Base Price">
                                                                <span class="input-group-text unit-label">/ kg</span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <small class="text-muted">Leave blank to use the base price defined above.</small>
                                </div>

                                <div class="mb-3 d-flex flex-wrap gap-2">
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

<script>
function previewImage(input, previewId) {
    var preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('d-none');
        };
        reader.readAsDataURL(input.files[0]);
    }
}

document.getElementById('unit').addEventListener('change', function () {
    var label = '/ ' + this.value;
    document.querySelectorAll('.unit-label').forEach(function (el) {
        el.textContent = label;
    });
});
</script>
@endsection
