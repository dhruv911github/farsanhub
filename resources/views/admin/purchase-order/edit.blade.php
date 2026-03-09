@extends('layouts.app')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Purchase Orders Edit</h1>
        </div>
        <div class="ms-auto pageheader-btn d-none d-xl-flex d-lg-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.purchase-order.index') }}">Purchase Orders</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.purchase-order.update', $purchaseOrder) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Party / Supplier</label>
                                    @php
                                        $cust = $customers->where('id', $purchaseOrder->customer_id)->first();
                                    @endphp
                                    <input type="text" class="form-control" value="{{ $cust ? ($cust->shop_name ?: $cust->customer_name) : '' }}" readonly>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="product" class="form-label">Product <span class="text-danger">*</span></label>
                                    <select name="product" id="product" class="form-control form-select @error('product') is-invalid @enderror">
                                        <option value="">-- Product --</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}"
                                                data-unit="{{ $product->unit ?? 'kg' }}"
                                                data-price="{{ $product->effective_price }}"
                                                {{ $product->id == $purchaseOrder->product_id ? 'selected' : '' }}>
                                                {{ $product->product_name }} (₹{{ $product->effective_price }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('product')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    @php $currentUnit = $products->where('id', $purchaseOrder->product_id)->first()?->unit ?? 'kg'; @endphp
                                    <label for="order_quantity" class="form-label">Quantity (<span id="qty-unit-label">{{ $currentUnit }}</span>) <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="number" step="0.01" min="0.01"
                                            class="form-control @error('order_quantity') is-invalid @enderror"
                                            id="order_quantity" name="order_quantity"
                                            value="{{ old('order_quantity', $purchaseOrder->order_quantity) }}" placeholder="e.g. 2.5">
                                        <span class="input-group-text" id="qty-unit-badge">{{ $currentUnit }}</span>
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
                                        value="{{ old('order_price', $purchaseOrder->order_price) }}" placeholder="e.g. 45.00">
                                    @error('order_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="order_date" class="form-label">Date</label>
                                    <input type="date" class="form-control" id="order_date" name="order_date"
                                        value="{{ old('order_date', $purchaseOrder->order_date ? $purchaseOrder->order_date->format('Y-m-d') : '') }}">
                                </div>

                                {{-- Live Total --}}
                                <div class="col-12 mb-3" id="total-summary">
                                    <div class="d-flex flex-wrap gap-3 align-items-center px-3 py-2 rounded-3" style="background:#FFF7EE; border:1.5px solid #ffe0b2;">
                                        <div style="font-size:0.83rem; color:#64748b;">
                                            Rate: <strong id="lbl-rate" style="color:#e07a1a;">₹{{ $purchaseOrder->order_price }}</strong>
                                        </div>
                                        <div style="font-size:0.83rem; color:#64748b;">
                                            Qty: <strong id="lbl-qty" style="color:#e07a1a;">{{ $purchaseOrder->order_quantity }} {{ $currentUnit }}</strong>
                                        </div>
                                        <div class="ms-auto" style="font-size:1rem; font-weight:700; color:#FF9933;">
                                            Total: <span id="lbl-total">₹ {{ number_format($purchaseOrder->order_quantity * $purchaseOrder->order_price, 2) }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mb-3 d-flex flex-wrap gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-save"></i> Update
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

<script>
function updateTotal() {
    var price = parseFloat(document.getElementById('order_price').value) || 0;
    var qty   = parseFloat(document.getElementById('order_quantity').value) || 0;
    var unit  = document.getElementById('qty-unit-label').textContent || 'kg';

    if (price > 0 && qty > 0) {
        var total = price * qty;
        document.getElementById('lbl-rate').textContent = '₹' + price.toLocaleString('en-IN', {minimumFractionDigits: 2});
        document.getElementById('lbl-qty').textContent  = qty + ' ' + unit;
        document.getElementById('lbl-total').textContent = '₹ ' + total.toLocaleString('en-IN', {minimumFractionDigits: 2});
    }
}

document.getElementById('product').addEventListener('change', function () {
    var opt  = this.options[this.selectedIndex];
    var unit = opt.dataset.unit || 'kg';
    document.getElementById('qty-unit-label').textContent = unit;
    document.getElementById('qty-unit-badge').textContent  = unit;
    if (opt.dataset.price) {
        document.getElementById('order_price').value = opt.dataset.price;
    }
    updateTotal();
});

document.getElementById('order_quantity').addEventListener('input', updateTotal);
document.getElementById('order_price').addEventListener('input', updateTotal);
</script>
@endsection
