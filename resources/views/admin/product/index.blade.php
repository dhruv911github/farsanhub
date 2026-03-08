@extends('layouts.app')

<style>
    .product-card {
        position: relative;
        border-radius: 16px;
        padding: 1rem;
        background: #fff;
        box-shadow: 0 0 0 2px rgba(255, 0, 0, 0.1);
        background-clip: padding-box;
        transition: transform 0.2s ease, box-shadow 0.3s ease;
        border: 2px solid transparent;
        background-origin: border-box;
        background-image: linear-gradient(#fff, #fff), linear-gradient(45deg, #ffcccc, #ff9999);
        background-clip: padding-box, border-box;
    }
    .product-card:hover { transform: translateY(-5px); box-shadow: 0 8px 20px rgba(253, 13, 13, 0.4); }
    .product-card .card-body img { object-fit: cover; border: 3px solid #dee2e6; border-radius: 8px; }
    .product-card ul li { margin-bottom: 6px; }
    .clickable-image { cursor: pointer; }
    @media (max-width: 767.98px) {
        .filter-bar > select,
        .filter-bar > input { width: 100% !important; flex: 0 0 100% !important; }
    }
</style>

@section('content')
<div class="page-header d-flex flex-wrap justify-content-between align-items-center my-0">
    <div><h1 class="page-title">{{ @trans('portal.products') }}</h1></div>
    <div class="ms-auto pageheader-btn d-none d-xl-flex d-lg-flex mt-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('login') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ @trans('portal.products') }}</li>
        </ol>
    </div>
    <div class="ms-auto pageheader-btn d-flex d-md-none mt-0">
        <a href="{{ route('admin.product.create') }}" class="btn btn-secondary me-2">
            <span class="d-none d-sm-inline">{{ @trans('portal.add') }}</span> <i class="fa fa-plus"></i>
        </a>
    </div>
</div>

<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
        <div class="card overflow-hidden products">
            <div class="p-4 card-body">
                {{-- Filter Row --}}
                <div class="d-flex flex-wrap flex-lg-nowrap gap-2 align-items-center mb-3 filter-bar">
                    <select id="selected_data" onchange="reloadTable()" class="form-select flex-shrink-0" style="width:80px;">
                        <option value="4">4</option>
                        <option value="8" selected>8</option>
                        <option value="16">16</option>
                        <option value="24">24</option>
                        <option value="32">32</option>
                    </select>
                    <select id="filter-customer" onchange="reloadTable()" class="form-select" style="flex:1 1 0; min-width:0;">
                        <option value="">-- {{ @trans('portal.customer') }} --</option>
                        @foreach($customers as $c)
                            <option value="{{ $c->id }}" {{ (isset($customerId) && $customerId == $c->id) ? 'selected' : '' }}>
                                {{ $c->shop_name ?: $c->customer_name }}
                            </option>
                        @endforeach
                    </select>
                    <select id="filter-product" onchange="reloadTable()" class="form-select" style="flex:1 1 0; min-width:0;">
                        <option value="">-- {{ @trans('portal.product') }} --</option>
                        @foreach($allProducts as $p)
                            <option value="{{ $p->id }}" {{ (isset($productId) && $productId == $p->id) ? 'selected' : '' }}>
                                {{ $p->product_name }}
                            </option>
                        @endforeach
                    </select>
                    <input type="text" name="search" class="form-control" id="search-val"
                           onkeyup="reloadTable()" style="flex:2 1 0; min-width:0;"
                           @if (empty($search)) placeholder="Search..."
                           @else value="{{ $search }}" @endif>
                    <a href="{{ route('admin.product.create') }}" class="btn btn-secondary flex-shrink-0 d-none d-md-flex align-items-center gap-1">
                        <i class="fa fa-plus"></i> <span>{{ @trans('portal.add') }}</span>
                    </a>
                </div>

                <div id="product-cards" class="mt-4">
                   @include('admin.product.view')
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Delete Modal --}}
<div class="modal fade" id="user-delete" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete product</h5>
            </div>
            <form action="{{ route('admin.product.destroy') }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <input type="hidden" name="product_id" id="product_id" value="">
                    <span>Do you want to Delete this record?</span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-btn" data-bs-dismiss="modal">Cancel</button>
                    <input type="submit" class="btn btn-primary" value="Confirm">
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Image Modal --}}
<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body d-flex justify-content-center">
                <img src="" alt="Large View" id="popupImage" class="img-fluid">
                <button type="button" class="btn-close border" data-bs-dismiss="modal" aria-label="Close">
                    <span><i class="fa fa-close" style="color:red"></i></span>
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if (session()->has('success'))
<script>
    Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 3500 })
        .fire({ icon: 'success', title: {!! json_encode(session('success')) !!} });
</script>
@endif
@if (session()->has('error'))
<script>
    Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 3500 })
        .fire({ icon: 'error', title: {!! json_encode(session('error')) !!} });
</script>
@endif

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $('.close-btn').click(function() { $('.modal').modal('hide'); });
    $('.user-delete-btn').click(function() { $('#product_id').val($(this).data('product-id')); });
    $(document).on('click', '.clickable-image', function() {
        $('#popupImage').attr('src', $(this).data('image'));
        $('#imageModal').modal('show');
    });
});

function reloadTable() {
    var search     = $('#search-val').val();
    var limit      = $('#selected_data').val();
    var customerId = $('#filter-customer').val();
    var productId  = $('#filter-product').val();

    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

    $.ajax({
        type: "GET",
        url: "{{ route('admin.product.index') }}",
        data: { search: search, limit: limit, customer_id: customerId, product_id: productId },
        success: function(response) { $('#product-cards').html(response); },
    });
}
</script>
@endsection
