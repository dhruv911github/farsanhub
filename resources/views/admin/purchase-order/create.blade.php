@extends('layouts.app')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Purchase Orders Add</h1>
        </div>
        <div class="ms-auto pageheader-btn d-none d-xl-flex d-lg-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.purchase-order.index') }}">Purchase Orders</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.purchase-order.store') }}" method="POST">
                            @csrf
                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label for="customer" class="form-label">Party / Supplier <span class="text-danger">*</span></label>
                                    <select name="customer" id="customer" class="form-control form-select @error('customer') is-invalid @enderror">
                                        <option value="">-- Select Party --</option>
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
                                    <label for="product" class="form-label">Product <span class="text-danger">*</span></label>
                                    <select name="product" id="product" class="form-control form-select @error('product') is-invalid @enderror">
                                        <option value="">-- Product --</option>
                                    </select>
                                    @error('product')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="order_quantity" class="form-label">Quantity (<span id="qty-unit-label">kg</span>) <span class="text-danger">*</span></label>
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
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="order_price" class="form-label">Purchase Rate (₹) <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" min="0"
                                        class="form-control @error('order_price') is-invalid @enderror"
                                        id="order_price" name="order_price"
                                        value="{{ old('order_price') }}" placeholder="e.g. 45.00">
                                    @error('order_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="order_date" class="form-label">Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('order_date') is-invalid @enderror"
                                        id="order_date" name="order_date"
                                        value="{{ old('order_date', date('Y-m-d')) }}">
                                    @error('order_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Live Total --}}
                                <div class="col-12 mb-3" id="total-summary" style="display:none;">
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

                                <div class="col-12 mb-3 d-flex flex-wrap gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-save"></i> Save
                                    </button>
                                    <a href="{{ route('admin.purchase-order.index') }}" class="btn btn-secondary">
                                        <i class="fa fa-arrow-left"></i> Cancel
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
            var price = parseFloat($('#order_price').val()) || 0;
            var qty   = parseFloat($('#order_quantity').val()) || 0;
            var unit  = $('#qty-unit-label').text() || 'kg';

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
                productSelect.html('<option value="">-- Product --</option>');
                $('#total-summary').hide();

                if (customerId) {
                    $.ajax({
                        url: "{{ route('admin.purchase-order.products-by-customer') }}",
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
                var opt  = $(this).find('option:selected');
                var unit = opt.data('unit') || 'kg';
                var price = opt.data('price') || '';
                $('#qty-unit-label').text(unit);
                $('#qty-unit-badge').text(unit);
                if (price) $('#order_price').val(price);
                updateTotal();
            });

            $('#order_quantity, #order_price').on('input', updateTotal);
        });
    </script>
@endsection
