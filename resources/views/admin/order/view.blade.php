<table class="table table-bordered border-bottom w-100 table-checkable no-footer " id="logs-table">
    <thead>
        <tr role="row">
            <th class="text-uppercase fw-bold">#</th>
            <th class="text-uppercase fw-bold">{{ @trans('portal.customer_name') }}</th>
            <th class="text-uppercase fw-bold">{{ @trans('portal.product_name') }}</th>
            <th class="text-uppercase fw-bold">{{ @trans('portal.order_quantity') }}</th>
            <th class="text-uppercase fw-bold">{{ @trans('portal.amount') }}</th>
            <th class="text-uppercase fw-bold">{{ @trans('portal.date') }}</th>
            <th class="text-center text-uppercase fw-bold">{{ @trans('portal.action') }}</th>
        </tr>
    </thead>
    <tbody>
        @if ($orders->isEmpty())
            <tr>
                <td colspan="6" class="text-center text-danger">{{ @trans('messages.no_content') }}</td>
            </tr>
        @else
            @forelse($orders as $index => $order)
                <tr>
                    <td>{{ $orders->firstItem() + $index }}</td>
                    <td>{{ $order->customer_name }}</td>
                    <td>{{ $order->product_name }}</td>
                    <td>{{ $order->order_quantity }} KG</td>
                    <td>₹{{ number_format($order->order_quantity * $order->order_price, 2) }}</td>
                    <td style="white-space: nowrap;">{{ date('d-m-Y', strtotime($order->created_at)) }}</td>
                    <td class="text-center">
                        <div class="btn-group">
                            <a class="secondary edit-technician-btn me-2"
                                href="{{ route('admin.order.edit', $order->id) }}"><i class="fa fa-edit"></i></a>
                            <a class="primary order-delete-btn" data-bs-toggle="modal" data-bs-target="#order-delete"
                                data-order-id="{{ $order->id }}">
                                <i class="fa fa-trash-o"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
            <tr class=" fw-bold">
                <td colspan="3" class="text-end">Total:</td>
                <td>{{ $orders->sum('order_quantity') }} KG</td>
                <td>₹{{ number_format($orders->sum(function ($order) {return $order->order_quantity * $order->order_price;}),2) }}
                </td>
                <td colspan="2"></td>
            </tr>
        @endif
    </tbody>
</table>

<div class="d-md-flex justify-content-center">
    {{ $orders->links('admin.parts.pagination') }}
</div>
