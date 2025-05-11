@extends('layouts.app')

<style>
    .order-card {
        position: relative;
        border-radius: 16px;
        padding: 1rem;
        background: #fff;
        box-shadow: 0 0 0 2px rgba(255, 0, 0, 0.1);
        /* fallback soft red border */
        background-clip: padding-box;
        transition: transform 0.2s ease, box-shadow 0.3s ease;
        border: 2px solid transparent;
        background-origin: border-box;
        background-image:
            linear-gradient(#fff, #fff),
            linear-gradient(45deg, #ffcccc, #ff9999);
        background-clip: padding-box, border-box;
    }

    .order-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(253, 13, 13, 0.4);
    }

    .order-card .card-body img {
        object-fit: cover;
        border: 3px solid #dee2e6;
        border-radius: 8px;
    }

    .order-card ul li {
        margin-bottom: 6px;
    }

    .clickable-image {
        cursor: pointer;
    }
</style>


@section('content')
    <div class="page-header d-flex flex-wrap justify-content-between align-items-center my-0">
        <div>
            <h1 class="page-title">{{ @trans('portal.orders') }}</h1>
        </div>
        <div class="ms-auto pageheader-btn d-none d-xl-flex d-lg-flex mt-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('login') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ @trans('portal.orders') }}</li>
            </ol>
        </div>
        <div class="ms-auto pageheader-btn d-flex d-md-none mt-0">
            <a href="{{ route('admin.order.create') }}" class="btn btn-secondary me-2">
                <span class="d-none d-sm-inline">{{ @trans('portal.add') }}</span> <i class="fa fa-plus"></i>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="card overflow-hidden orders">
                <div class="p-4 card-body">
                    <div class="row d-md-flex justify-content-between align-items-center">
                        <!-- Dropdown: col-12 on mobile, auto on md+ -->
                        <div class="col-12 col-md-auto mb-2 mb-md-0">
                            <select id="selected_data" onchange="reloadTable()" class="form-control form-select me-md-2">
                                <option value="4">4</option>
                                <option value="8">8</option>
                                <option value="16">16</option>
                                <option value="24">24</option>
                                <option value="32">32</option>
                            </select>
                        </div>
                        <!-- Search and Add Button Container -->
                        <div class="col-12 col-md-auto">
                            <div class="d-flex flex-column flex-md-row align-items-stretch">
                                <!-- Date Filters -->
                                <div class="d-flex mb-2 mb-md-0 me-md-2">
                                    <input type="date" name="start_date" class="form-control me-2" id="start-date">
                                    <input type="date" name="end_date" class="form-control" id="end-date"
                                        onchange="checkDatesAndReload()">
                                </div>
                                <!-- Search Input -->
                                <input type="text" name="search" class="form-control mb-2 mb-md-0 me-md-2"
                                    id="search-val" onkeyup="reloadTable()"
                                    @if (empty($search)) placeholder="Search..."
                                   @else value="{{ $search }}" @endif>

                                <!-- Add Button (visible on md and up only) -->
                                <div class="d-none d-md-flex justify-content-end">
                                    <a href="{{ route('admin.order.create') }}" class="btn btn-secondary">
                                        <span class="d-none d-sm-inline">{{ @trans('portal.add') }}</span>
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- order Cards -->
                    <div id="order-cards" class="mt-4 table-responsive">
                        @include('admin.order.view')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="order-delete" tabindex="-1" role="dialog" aria-labelledby="AddmodelLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete order</h5>
                </div>
                <form action="{{ route('admin.order.destroy') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <input type="hidden" name="order_id" id="order_id" value="">
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
                $('#order-delete').modal('show');
            });

            $('.order-delete-btn').click(function() {
                var DataId = $(this).data('order-id');
                $('#order_id').val(DataId);

            });
        });

        function checkDatesAndReload() {
            let startDate = $('#start-date').val();
            let endDate = $('#end-date').val();

            if (startDate && endDate) {
                reloadTable();
            }
        }

        //search and filter
        function reloadTable() {
            let search_string = $('#search-val').val();
            let limit = $('#selected_data').val();
            let startDate = $('#start-date').val();
            let endDate = $('#end-date').val();
            // console.log(search_string);
            // console.log(limit);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "GET",
                url: "{{ route('admin.order.index') }}",
                data: {
                    search: search_string,
                    limit: limit,
                    start_date: startDate,
                    end_date: endDate
                },
                success: function(response) {
                    $('#order-cards').html(response);
                },
                error: function(xhr, status, error) {
                    // console.error('AJAX error:', error);
                    // console.log(xhr.responseText);
                }
            });
        }
    </script>
@endsection
