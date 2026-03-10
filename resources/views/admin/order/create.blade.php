@extends('layouts.app')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">
                {{ @trans('portal.orders') . ' ' . @trans('portal.add') }}
            </h1>
        </div>
        <div class="ms-auto pageheader-btn d-none d-xl-flex d-lg-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.order.index') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ @trans('portal.orders') }}</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <form action="{{ route('admin.order.store') }}" method="POST">
                            @csrf
                            @method('POST')
                            <div class="row">

                                <div class="col-12 mb-3">
                                    <label class="form-label fw-semibold">Order Type <span class="text-danger">*</span></label>
                                    <div class="d-flex gap-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="type" id="type_sell" value="sell" {{ old('type', 'sell') === 'sell' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="type_sell">
                                                <span class="badge" style="background:#d1fae5; color:#065f46; font-size:13px;">Sell</span>
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="type" id="type_purchase" value="purchase" {{ old('type') === 'purchase' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="type_purchase">
                                                <span class="badge" style="background:#dbeafe; color:#1e40af; font-size:13px;">Purchase</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="customer" class="form-label">{{ @trans('portal.customer') }} <span class="text-danger">*</span></label>
                                    <select name="customer" id="customer" class="form-control form-select @error('customer') is-invalid @enderror">
                                        <option value="">-- {{ @trans('portal.customer') }} --</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}" {{ $customer->id == old('customer') ? 'selected' : '' }}>
                                                {{ $customer->shop_name ?: $customer->customer_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('customer')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="product" class="form-label">{{ @trans('portal.product') }} <span class="text-danger">*</span></label>
                                    <select name="product" id="product" class="form-control form-select @error('product') is-invalid @enderror">
                                        <option value="">-- {{ @trans('portal.product') }} --</option>
                                    </select>
                                    @error('product')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="order_quantity" class="form-label">{{ @trans('portal.order_quantity') }} (<span id="qty-unit-label">kg</span>) <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="number" step="0.01" min="0.01"
                                            class="form-control @error('order_quantity') is-invalid @enderror"
                                            id="order_quantity" name="order_quantity"
                                            value="{{ old('order_quantity') }}" placeholder="e.g. 2.5">
                                        <span class="input-group-text" id="qty-unit-badge">kg</span>
                                        @error('order_quantity')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Live Total --}}
                                    <div class="mt-3" id="total-summary" style="display:none;">
                                        <div class="d-flex flex-wrap gap-3 align-items-center px-3 py-2 rounded-3" style="background:#FFF7EE; border:1.5px solid #ffe0b2;">
                                            <div style="font-size:0.83rem; color:#64748b;">
                                                Rate: <strong id="lbl-rate" style="color:#e07a1a;">—</strong>
                                            </div>
                                            <div style="font-size:0.83rem; color:#64748b;">
                                                Qty: <strong id="lbl-qty" style="color:#e07a1a;">—</strong>
                                            </div>
                                            <div class="ms-auto" style="font-size:1rem; font-weight:700; color:#FF9933;">
                                                Total: <span id="lbl-total">₹ 0.00</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="order_date" class="form-label">{{ @trans('portal.date') }} <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('order_date') is-invalid @enderror"
                                        id="order_date" name="order_date"
                                        value="{{ old('order_date', date('Y-m-d', strtotime('+1 day'))) }}">
                                    @error('order_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 d-flex flex-wrap gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-save"></i> {{ @trans('portal.save') }}
                                    </button>
                                    <a href="{{ route('admin.order.index') }}" class="btn btn-secondary">
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script>
        function updateTotal() {
            var price = parseFloat($('#product').find('option:selected').data('price')) || 0;
            var qty   = parseFloat($('#order_quantity').val()) || 0;
            var unit  = $('#product').find('option:selected').data('unit') || 'kg';

            if (price > 0 && qty > 0) {
                var total = price * qty;
                $('#lbl-rate').text('₹' + price.toLocaleString('en-IN', {minimumFractionDigits: 2}));
                $('#lbl-qty').text(qty + ' ' + unit);
                $('#lbl-total').text('₹ ' + total.toLocaleString('en-IN', {minimumFractionDigits: 2}));
                $('#total-summary').show();
            } else {
                $('#total-summary').hide();
            }
        }

        $(document).ready(function() {
            $('#customer').change(function() {
                var customerId = $(this).val();
                var productSelect = $('#product');
                productSelect.html('<option value="">-- {{ @trans("portal.product") }} --</option>');
                $('#total-summary').hide();

                if (customerId) {
                    $.ajax({
                        url: "{{ route('admin.order.products-by-customer') }}",
                        type: "GET",
                        data: { customer_id: customerId },
                        success: function(data) {
                            $.each(data, function(index, product) {
                                productSelect.append(
                                    '<option value="' + product.id + '"' +
                                    ' data-unit="' + (product.unit || 'kg') + '"' +
                                    ' data-price="' + product.product_base_price + '">' +
                                    product.product_name + ' (₹' + product.product_base_price + ')' +
                                    '</option>'
                                );
                            });
                        }
                    });
                }
            });

            if ($('#customer').val()) {
                $('#customer').trigger('change');
            }

            $('#product').on('change', function () {
                var unit = $(this).find('option:selected').data('unit') || 'kg';
                $('#qty-unit-label').text(unit);
                $('#qty-unit-badge').text(unit);
                updateTotal();
            });

            $('#order_quantity').on('input', function () {
                updateTotal();
            });
        });
    </script>
@endsection
