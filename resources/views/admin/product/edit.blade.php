@extends('layouts.app')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">
                {{ @trans('portal.products') . ' ' . @trans('portal.edit') }}
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
                        <form action="{{ route('admin.product.update', $product) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label for="product_name" class="form-label">{{ @trans('portal.product_name') }} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('product_name') is-invalid @enderror"
                                        id="product_name" name="product_name" value="{{ old('product_name', $product->product_name) }}">
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
                                            id="product_base_price" name="product_base_price"
                                            value="{{ old('product_base_price', $product->product_base_price) }}"
                                            placeholder="0.00">
                                        <span class="input-group-text">/ kg</span>
                                        @error('product_base_price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="customer_id" class="form-label">{{ @trans('portal.customer') }}</label>
                                    <select class="form-select" id="customer_id" name="customer_id">
                                        <option value="">-- {{ @trans('portal.customer') }} --</option>
                                        @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}"
                                                {{ old('customer_id', $product->customer_id) == $customer->id ? 'selected' : '' }}>
                                                {{ $customer->shop_name ?: $customer->customer_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="status" class="form-label">{{ @trans('portal.status') }} <span class="text-danger">*</span></label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                        <option value="">-- {{ @trans('portal.status') }} --</option>
                                        <option value="Active" {{ old('status', $product->status) == 'Active' ? 'selected' : '' }}>{{ @trans('portal.active') }}</option>
                                        <option value="Inactive" {{ old('status', $product->status) == 'Inactive' ? 'selected' : '' }}>{{ @trans('portal.inactive') }}</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="product_image" class="form-label">{{ @trans('portal.product_image') }}</label>
                                    <div class="mb-2">
                                        <img id="product_image_preview"
                                            src="{{ ($product->product_image && file_exists(public_path('storage/' . $product->product_image))) ? asset('storage/' . $product->product_image) : '#' }}"
                                            alt="{{ $product->product_name }}" class="img-thumbnail {{ ($product->product_image && file_exists(public_path('storage/' . $product->product_image))) ? '' : 'd-none' }}" style="max-width: 200px;">
                                    </div>
                                    <input type="file" class="form-control @error('product_image') is-invalid @enderror"
                                        id="product_image" name="product_image" accept="image/*"
                                        onchange="previewImage(this, 'product_image_preview')">
                                    @error('product_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">{{ @trans('portal.accepted_formats') }}</small>
                                </div>

                                <div class="mb-3 d-flex flex-wrap gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-save"></i> {{ @trans('portal.update') }}
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
</script>
@endsection
