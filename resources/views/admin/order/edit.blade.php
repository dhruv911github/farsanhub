@extends('layouts.app')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">
                {{ @trans('portal.orders') . ' ' . @trans('portal.edit') }}
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
                        <form action="{{ route('admin.order.update', $order) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{ @trans('portal.customer_name') }}</label>
                                    @php
                                        $cust = $customers->where('id', $order->customer_id)->first();
                                    @endphp
                                    <input type="text" class="form-control" value="{{ $cust ? ($cust->shop_name ?: $cust->customer_name) : '' }}" readonly>
                                </div>

                                <div class="col-md-6 mb-3 d-flex align-items-end">
                                    <div>
                                        <label class="form-label fw-semibold d-block">Order Type <span class="text-danger">*</span></label>
                                        <div class="d-flex gap-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="type" id="type_sell" value="sell" {{ old('type', $order->type ?? 'sell') === 'sell' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="type_sell">
                                                    <span class="badge" style="background:#d1fae5; color:#065f46; font-size:13px;">Sell</span>
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="type" id="type_purchase" value="purchase" {{ old('type', $order->type) === 'purchase' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="type_purchase">
                                                    <span class="badge" style="background:#dbeafe; color:#1e40af; font-size:13px;">Purchase</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="product" class="form-label">{{ @trans('portal.product') }} <span class="text-danger">*</span></label>
                                    <select name="product" id="product" class="form-control form-select @error('product') is-invalid @enderror">
                                        <option value="">-- {{ @trans('portal.product') }} --</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}"
                                                data-unit="{{ $product->unit ?? 'kg' }}"
                                                data-price="{{ $product->effective_price }}"
                                                {{ $product->id == $order->product_id ? 'selected' : '' }}>
                                                {{ $product->product_name }} (₹{{ $product->effective_price }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('product')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    @php $currentUnit = $products->where('id', $order->product_id)->first()?->unit ?? 'kg'; @endphp
                                    <label for="order_quantity" class="form-label">{{ @trans('portal.order_quantity') }} (<span id="qty-unit-label">{{ $currentUnit }}</span>) <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="number" step="0.01" min="0.01"
                                            class="form-control @error('order_quantity') is-invalid @enderror"
                                            id="order_quantity" name="order_quantity"
                                            value="{{ old('order_quantity', $order->order_quantity) }}" placeholder="e.g. 2.5">
                                        <span class="input-group-text" id="qty-unit-badge">{{ $currentUnit }}</span>
                                        @error('order_quantity')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                </div>
                                    {{-- Live Total --}}
                                    <div class="mt-3" id="total-summary">
                                    <div class="d-flex flex-wrap gap-3 align-items-center px-3 py-2 rounded-3" style="background:#FFF7EE; border:1.5px solid #ffe0b2;">
                                        <div style="font-size:0.83rem; color:#64748b;">
                                            Rate: <strong id="lbl-rate" style="color:#e07a1a;">₹{{ $order->order_price }}</strong>
                                        </div>
                                        <div style="font-size:0.83rem; color:#64748b;">
                                            Qty: <strong id="lbl-qty" style="color:#e07a1a;">{{ $order->order_quantity }} {{ $currentUnit }}</strong>
                                        </div>
                                        <div class="ms-auto" style="font-size:1rem; font-weight:700; color:#FF9933;">
                                            Total: <span id="lbl-total">₹ {{ number_format($order->order_quantity * $order->order_price, 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                                </div> 

                                <div class="col-md-6 mb-3">
                                    <label for="order_date" class="form-label">{{ @trans('portal.date') }}</label>
                                    <input type="date" class="form-control" id="order_date" name="order_date"
                                        value="{{ old('order_date', $order->order_date ?: ($order->created_at ? $order->created_at->format('Y-m-d') : '')) }}">
                                </div>

                                <div class="mb-3 d-flex flex-wrap gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-save"></i> {{ @trans('portal.update') }}
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
<script>
function updateTotal() {
    var sel   = document.getElementById('product');
    var opt   = sel.options[sel.selectedIndex];
    var price = parseFloat(opt ? opt.dataset.price : 0) || 0;
    var qty   = parseFloat(document.getElementById('order_quantity').value) || 0;
    var unit  = opt ? (opt.dataset.unit || 'kg') : 'kg';

    if (price > 0 && qty > 0) {
        var total = price * qty;
        document.getElementById('lbl-rate').textContent = '₹' + price.toLocaleString('en-IN', {minimumFractionDigits: 2});
        document.getElementById('lbl-qty').textContent  = qty + ' ' + unit;
        document.getElementById('lbl-total').textContent = '₹ ' + total.toLocaleString('en-IN', {minimumFractionDigits: 2});
    }
}

document.getElementById('product').addEventListener('change', function () {
    var unit = this.options[this.selectedIndex].dataset.unit || 'kg';
    document.getElementById('qty-unit-label').textContent = unit;
    document.getElementById('qty-unit-badge').textContent  = unit;
    updateTotal();
});

document.getElementById('order_quantity').addEventListener('input', updateTotal);
</script>
@endsection
