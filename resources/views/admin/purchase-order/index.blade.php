@extends('layouts.app')

<style>
    @media (max-width: 767.98px) {
        .filter-bar > select,
        .filter-bar > input,
        .filter-bar > .filter-date-wrap { width: 100% !important; flex: 0 0 100% !important; }
        .filter-bar > .filter-date-wrap input { width: 100% !important; }
    }
</style>

@section('content')
    <div class="page-header d-flex flex-wrap justify-content-between align-items-center my-0">
        <div><h1 class="page-title">Purchase Orders</h1></div>
        <div class="ms-auto pageheader-btn d-none d-xl-flex d-lg-flex mt-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Purchase Orders</li>
            </ol>
        </div>
        <div class="ms-auto pageheader-btn d-flex d-md-none mt-0">
            <a href="{{ route('admin.purchase-order.create') }}" class="btn btn-secondary me-2">
                <span class="d-none d-sm-inline">Add</span> <i class="fa fa-plus"></i>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card overflow-hidden">
                <div class="p-4 card-body">
                    <div class="d-flex flex-wrap flex-lg-nowrap gap-2 align-items-center mb-3 filter-bar">
                        <select id="selected_data" onchange="reloadTable()" class="form-select flex-shrink-0" style="width:80px;">
                            <option value="4">4</option>
                            <option value="10" selected>10</option>
                            <option value="16">16</option>
                            <option value="24">24</option>
                            <option value="32">32</option>
                        </select>
                        <div class="filter-date-wrap flex-shrink-0" style="width:155px;">
                            <small class="d-block d-lg-none text-muted" style="font-size:11px; margin-bottom:2px;">Start Date</small>
                            <input type="date" name="start_date" class="form-control" id="start-date" placeholder="Start Date" data-fp-onchange="checkDatesAndReload">
                        </div>
                        <div class="filter-date-wrap flex-shrink-0" style="width:155px;">
                            <small class="d-block d-lg-none text-muted" style="font-size:11px; margin-bottom:2px;">End Date</small>
                            <input type="date" name="end_date" class="form-control" id="end-date" placeholder="End Date" data-fp-onchange="checkDatesAndReload">
                        </div>
                        <input type="text" name="search" class="form-control" id="search-val"
                            onkeyup="reloadTable()" style="flex:1 1 0; min-width:0;"
                            @if(empty($search)) placeholder="Search..." @else value="{{ $search }}" @endif>
                        <a href="{{ route('admin.purchase-order.create') }}" class="btn btn-secondary flex-shrink-0 d-none d-md-flex align-items-center gap-1">
                            <i class="fa fa-plus"></i> <span>Add</span>
                        </a>
                    </div>

                    <div id="po-table" class="mt-4">
                        @include('admin.purchase-order.view')
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete Modal --}}
    <div class="modal fade" id="po-delete" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Purchase Order</h5>
                </div>
                <form action="{{ route('admin.purchase-order.destroy') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <input type="hidden" name="purchase_order_id" id="purchase_order_id" value="">
                        <span>Do you want to delete this purchase order?</span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary close-btn" data-bs-dismiss="modal">Cancel</button>
                        <input type="submit" class="btn btn-primary" value="Confirm">
                    </div>
                </form>
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
        $(document).on('click', '.po-delete-btn', function() {
            $('#purchase_order_id').val($(this).data('po-id'));
        });
    });

    function checkDatesAndReload() {
        var s = $('#start-date').val();
        var e = $('#end-date').val();
        if (s || e) reloadTable();
    }

    function reloadTable() {
        var search    = $('#search-val').val();
        var limit     = $('#selected_data').val();
        var startDate = $('#start-date').val();
        var endDate   = $('#end-date').val();

        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        $.ajax({
            type: "GET",
            url: "{{ route('admin.purchase-order.index') }}",
            data: { search: search, limit: limit, start_date: startDate, end_date: endDate },
            success: function(response) { $('#po-table').html(response); },
        });
    }
    </script>
@endsection
