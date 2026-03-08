@extends('layouts.app')

<style>
    @media (max-width: 767.98px) {
        .filter-bar > select,
        .filter-bar > input { width: 100% !important; flex: 0 0 100% !important; }
    }
</style>

@section('content')
<div class="page-header d-flex flex-wrap justify-content-between align-items-center my-0">
    <div>
        <h1 class="page-title">{{ @trans('portal.expenses') }}</h1>
    </div>
    <div class="ms-auto pageheader-btn d-none d-xl-flex d-lg-flex mt-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.expense.index') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ @trans('portal.expenses') }}</li>
        </ol>
    </div>
    <div class="ms-auto pageheader-btn d-flex d-md-none mt-0">
        <a href="{{ route('admin.expense.create') }}" class="btn btn-secondary me-2">
            <span class="d-none d-sm-inline">{{ @trans('portal.add') }}</span> <i class="fa fa-plus"></i>
        </a>
    </div>
</div>

<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
        <div class="card overflow-hidden customers">
            <div class="p-4 card-body">
                <div class="d-flex flex-wrap flex-lg-nowrap gap-2 align-items-center mb-3 filter-bar">
                    <select id="selected_data" onchange="reloadTable()" class="form-select flex-shrink-0" style="width:80px;">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="75">75</option>
                        <option value="100">100</option>
                    </select>
                    <input type="text" name="search" class="form-control" id="search-val"
                           onkeyup="reloadTable()" style="flex:1 1 0; min-width:0;"
                           @if (empty($search)) placeholder="Search..."
                           @else value="{{ $search }}" @endif>
                    <a href="{{ route('admin.expense.create') }}" class="btn btn-secondary flex-shrink-0 d-none d-md-flex align-items-center gap-1">
                        <i class="fa fa-plus"></i> <span>{{ @trans('portal.add') }}</span>
                    </a>
                </div>

                <!-- Table content -->
                <div class="mt-4 table-responsive">
                    @include('admin.expense.view')
                </div>
            </div>
        </div>
    </div>
</div>


<!-- change status Modal  -->
<div class="modal fade" id="user-delete" tabindex="-1" role="dialog" aria-labelledby="AddmodelLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete expense</h5>
            </div>
            <form action="{{ route('admin.expense.destroy') }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <input type="hidden" name="expense_id" id="expense_id" value="">
                    <span>Do you want to Delete this record?</span>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Cancel</button>
                    <input type="submit" class="btn btn-primary" value="Confirm">
                </div>
            </form>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if (session()->has('success'))
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


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.close-btn').click(function() {
            // e.preventDefault();
            $('.modal').modal('hide');
        })
        $("#editTechnician").click(function() {
            // e.preventDefault();
            $('#user-delete').modal('show');
        });

        $('.user-delete-btn').click(function() {
            var DataId = $(this).data('expense-id');
            $('#expense_id').val(DataId);

        });
    });

    // Use event delegation to handle clicks on the button
    $('.card-body').on('click', '#sortCreatedAt button', function() {
        var sort = $('#sortCreatedAt').attr('data-sort');
        sort = (sort === 'desc') ? 'asc' : 'desc';
        reloadTable(sort);
    });

    //search and filter
    function reloadTable(sort) {
        let search_string = $('#search-val').val();
        let limit = $('#selected_data').val();
        console.log(search_string);
        console.log(limit);
        

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "GET",
            url: "{{ route('admin.expense.index') }}",
            data: {
                search: search_string,
                limit: limit,
                sort: sort,
            },
            success: function(response) {
                $('.table-responsive').html(response);
            },
        });
    }
</script>
@endsection
