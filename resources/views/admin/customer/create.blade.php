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

                        <form action="{{ route('admin.customer.store') }}" method="POST" enctype="multipart/form-data" id="customer-form">
                            @csrf
                            @method('POST')
                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label for="customer_name" class="form-label">{{ @trans('portal.customer_name') }} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('customer_name') is-invalid @enderror"
                                        id="customer_name" name="customer_name" value="{{ old('customer_name') }}">
                                    @error('customer_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="shop_name" class="form-label">{{ @trans('portal.shop_name') }} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('shop_name') is-invalid @enderror"
                                        id="shop_name" name="shop_name" value="{{ old('shop_name') }}">
                                    @error('shop_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Google Maps address autocomplete --}}
                                <div class="col-md-6 mb-3">
                                    <label for="shop_address" class="form-label">
                                        {{ @trans('portal.shop_address') }} <span class="text-danger">*</span>
                                        <small class="text-muted">(Search on Google Maps)</small>
                                    </label>
                                    <input type="text" class="form-control @error('shop_address') is-invalid @enderror"
                                        id="shop_address" name="shop_address"
                                        placeholder="Type to search address..."
                                        value="{{ old('shop_address') }}" autocomplete="off">
                                    <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
                                    <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">
                                    @error('shop_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="customer_number" class="form-label">{{ @trans('portal.mobile') }} <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control @error('customer_number') is-invalid @enderror"
                                        id="customer_number" name="customer_number"
                                        placeholder="+91 XXXXX XXXXX"
                                        value="{{ old('customer_number') }}">
                                    @error('customer_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="customer_email" class="form-label">{{ @trans('portal.customer_email') }}</label>
                                    <input type="email" class="form-control @error('customer_email') is-invalid @enderror"
                                        id="customer_email" name="customer_email" value="{{ old('customer_email') }}">
                                    @error('customer_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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

                                <div class="col-md-6 mb-3">
                                    <label for="city" class="form-label">{{ @trans('portal.city') }} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('city') is-invalid @enderror"
                                        id="city" name="city" value="{{ old('city') }}">
                                    @error('city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="customer_image" class="form-label">{{ @trans('portal.customer_image') }}</label>
                                    <input type="file" class="form-control @error('customer_image') is-invalid @enderror"
                                        id="customer_image" name="customer_image" accept="image/*"
                                        onchange="previewImage(this, 'customer_image_preview')">
                                    @error('customer_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">{{ @trans('portal.accepted_formats') }}</small>
                                    <div class="mt-2">
                                        <img id="customer_image_preview" src="#" alt="Preview" class="img-thumbnail d-none" style="max-width:200px;">
                                    </div>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="shop_image" class="form-label">{{ @trans('portal.shop_image') }}</label>
                                    <input type="file" class="form-control @error('shop_image') is-invalid @enderror"
                                        id="shop_image" name="shop_image" accept="image/*"
                                        onchange="previewImage(this, 'shop_image_preview')">
                                    @error('shop_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">{{ @trans('portal.accepted_formats') }}</small>
                                    <div class="mt-2">
                                        <img id="shop_image_preview" src="#" alt="Preview" class="img-thumbnail d-none" style="max-width:200px;">
                                    </div>
                                </div>

                                <div class="mb-3 d-flex flex-wrap gap-2">
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

@if(env('GOOGLE_MAPS_API_KEY'))
<script>
function initAutocomplete() {
    var input = document.getElementById('shop_address');
    var autocomplete = new google.maps.places.Autocomplete(input, { types: ['geocode'] });
    autocomplete.addListener('place_changed', function () {
        var place = autocomplete.getPlace();
        if (place.geometry) {
            document.getElementById('latitude').value  = place.geometry.location.lat();
            document.getElementById('longitude').value = place.geometry.location.lng();
            document.getElementById('shop_address').value = place.formatted_address;
            // Auto-fill city if available
            var cityComp = (place.address_components || []).find(c => c.types.includes('locality'));
            if (cityComp) {
                document.getElementById('city').value = cityComp.long_name;
            }
        }
    });
}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initAutocomplete" async defer></script>
@endif

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

<script>
// Phone number formatting/normalization
document.getElementById('customer_number').addEventListener('paste', function(e) {
    e.preventDefault();
    var pasted = (e.clipboardData || window.clipboardData).getData('text');
    this.value = normalizePhone(pasted);
});
document.getElementById('customer_number').addEventListener('blur', function() {
    if (this.value) this.value = normalizePhone(this.value);
});

function normalizePhone(raw) {
    // Keep only digits
    var digits = raw.replace(/\D/g, '');
    // Strip leading country code (91 for India if more than 10 digits)
    if (digits.length > 10) {
        digits = digits.slice(-10);
    }
    return digits;
}
</script>
@endsection
