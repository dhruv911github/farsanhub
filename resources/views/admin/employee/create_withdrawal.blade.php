@extends('layouts.app')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">
                {{ @trans('portal.employee') . ' ' . @trans('portal.withdrawal') }}
            </h1>
        </div>
        <div class="ms-auto pageheader-btn d-none d-xl-flex d-lg-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.employee.index') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ @trans('portal.withdrawal') }}</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-lg-6 row">
                <div class="card col-12">
                    <div class="card-body">
                        <h5 class="pb-2 border-bottom">&#11166; {{ @trans('portal.add_withdrawal') }}</h5>
                        <form action="{{ route('admin.employee.withdrawal.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="row">
                                <input type="hidden" name="employee_id" id="employee_id" value="{{ $employee_id }}">

                                <div class="mb-3 col-md-6">
                                    <label for="withdrawal_amount" class="form-label">{{ @trans('portal.amount') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="number" step="0.01"
                                        class="form-control @error('withdrawal_amount') is-invalid @enderror"
                                        id="withdrawal_amount" name="withdrawal_amount"
                                        value="{{ old('withdrawal_amount') }}" min="0">
                                    @error('withdrawal_amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="withdrawal_date" class="form-label">{{ @trans('portal.date') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="date"
                                        class="form-control @error('withdrawal_date') is-invalid @enderror"
                                        id="withdrawal_date" name="withdrawal_date" value="{{ old('withdrawal_date') }}">
                                    @error('withdrawal_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-save"></i> {{ @trans('portal.save') }}
                                    </button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
                @if (!$withdrawals->isEmpty())
                    <div class="card col-12">
                        <div class="card-body">
                            <h5 class="mb-2">&#11166; {{ @trans('portal.final_salary') }}</h5>
                            <div class='table-responsive'>
                                <table class="table table-bordered border-bottom w-100 table-checkable no-footer "
                                    id="logs-table">
                                    <thead>
                                        <tr role="row">
                                            <th class="text-uppercase fw-bold">{{ @trans('portal.name') }}</th>
                                            <th class="text-uppercase fw-bold">{{ @trans('portal.month') }}</th>
                                            <th class="text-uppercase fw-bold">{{ @trans('portal.salary') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($finalSalary as $data)
                                            <tr>
                                                <td>{{ $data->name ? $data->name : '-' }}</td>
                                                <td>{{ $data->month_year ? $data->month_year : '-' }}</td>
                                                <td>₹ {{ $data->final_salary ? number_format($data->final_salary, 2) : '-' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-md-12 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="mb-2 pb-2 border-bottom">&#11166; {{ @trans('portal.withdrawal') }}</h5>
                        <div class="mb-3">
                            <label for="month_year" class="form-label">{{ @trans('portal.select_month_year') }}</label>
                            <select name="month_year" id="month_year" class="form-select">
                                <option value="">Select Month-Year</option>
                                @foreach ($monthYears as $month)
                                    <option value="{{ $month }}"
                                        {{ $month == $selectedMonthYear ? 'selected' : '' }}>
                                        {{ $month }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div id="withdrawal_data">
                            @include('admin.employee.withdrawal_view')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


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
        $('#month_year').on('change', function() {
            var selectedMonthYear = $(this).val();
            if (selectedMonthYear !== '' && selectedMonthYear !== 'Select Month-Year') {
                fetchMonthWiseData(selectedMonthYear);
            }
        });
    });

    function fetchMonthWiseData(monthYear) {
        console.log(monthYear);

        $.ajax({
            url: "{{ route('admin.employee.withdrawal', ['id' => $employee_id]) }}", // Correct route
            type: 'GET',
            data: {
                month_year: monthYear, // Send the selected month_year as data
            },
            success: function(response) {
                // On success, update the DOM with the returned HTML
                $('#withdrawal_data').html(response.html);
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }

</script>
