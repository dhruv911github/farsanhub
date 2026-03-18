<div class="table-responsive mb-2">
<table class="table table-hover align-middle mb-0" id="logs-table" style="min-width:600px;">
    <thead style="background:#FFF7EE;">
        <tr>
            <th class="text-uppercase fw-bold" style="font-size:12px; color:#92400e; white-space:nowrap;">#</th>
            <th class="text-uppercase fw-bold text-center" style="font-size:12px; color:#92400e; white-space:nowrap;">Type</th>
            <th class="text-uppercase fw-bold" style="font-size:12px; color:#92400e; white-space:nowrap;">{{ @trans('portal.shop_name') }}</th>
            <th class="text-uppercase fw-bold" style="font-size:12px; color:#92400e; white-space:nowrap;">{{ @trans('portal.product_name') }}</th>
            <th class="text-uppercase fw-bold text-center" style="font-size:12px; color:#92400e; white-space:nowrap;">{{ @trans('portal.order_quantity') }}</th>
            <th class="text-uppercase fw-bold text-end" style="font-size:12px; color:#92400e; white-space:nowrap;">{{ @trans('portal.amount') }}</th>
            <th class="text-uppercase fw-bold text-center" style="font-size:12px; color:#92400e; white-space:nowrap;">{{ @trans('portal.date') }}</th>
            <th class="text-uppercase fw-bold text-center" style="font-size:12px; color:#92400e; white-space:nowrap;">{{ @trans('portal.action') }}</th>
        </tr>
    </thead>
    <tbody>
        @if ($orders->isEmpty())
            <tr>
                <td colspan="8" class="text-center py-4" style="color:#a8a29e; font-size:0.9rem;">
                    <i class="fa fa-inbox me-1"></i> {{ @trans('messages.no_content') }}
                </td>
            </tr>
        @else
            @forelse($orders as $index => $order)
                <tr>
                    <td style="font-size:13px; color:#78716c; font-weight:600;">{{ $orders->firstItem() + $index }}</td>
                    <td class="text-center">
                        @if(($order->type ?? 'sell') === 'purchase')
                            <span class="badge" style="background:#dbeafe; color:#1e40af; font-size:11px;">Purchase</span>
                        @else
                            <span class="badge" style="background:#d1fae5; color:#065f46; font-size:11px;">Sell</span>
                        @endif
                    </td>
                    <td>
                        <span style="font-size:13px; font-weight:600; color:#1c1917;">{{ $order->shop_name }}</span>
                    </td>
                    <td style="font-size:13px; color:#292524;">{{ $order->product_name }}</td>
                    <td class="text-center">
                        <span class="badge rounded-pill" style="background:#FFF7EE; color:#d97706; font-size:12px; font-weight:600; border:1px solid #fde68a;">
                            {{ rtrim(rtrim(number_format($order->order_quantity, 4), '0'), '.') }} {{ $order->unit ?? 'kg' }}
                        </span>
                    </td>
                    <td class="text-end" style="font-size:13px; font-weight:700; color:#d97706; white-space:nowrap;">
                        ₹{{ number_format($order->order_quantity * $order->order_price, 2) }}
                    </td>
                    <td class="text-center" style="font-size:12px; color:#78716c; white-space:nowrap;">
                        {{ date('d-m-Y', strtotime($order->order_date ?: $order->created_at)) }}
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ route('admin.order.edit', $order->id) }}"
                               class="btn btn-sm" style="background:#FFF7EE; color:#d97706; border:1px solid #fde68a; padding:4px 10px;">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a class="btn btn-sm" style="background:#fff0f0; color:#ef4444; border:1px solid #fecaca; padding:4px 10px; cursor:pointer;"
                               data-bs-toggle="modal" data-bs-target="#order-delete"
                               data-order-id="{{ $order->id }}">
                                <i class="fa fa-trash-o"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
            <tr style="background:#FFF7EE; font-weight:700;">
                <td colspan="4" class="text-end" style="font-size:13px; color:#92400e;">Total:</td>
                <td class="text-center">
                    <span class="badge rounded-pill" style="background:#FF9933; color:#fff; font-size:12px; font-weight:700;">
                        {{ rtrim(rtrim(number_format($orders->sum('order_quantity'), 4), '0'), '.') }}
                    </span>
                </td>
                <td class="text-end" style="font-size:14px; color:#FF9933; white-space:nowrap;">
                    ₹{{ number_format($orders->sum(function ($order) { return $order->order_quantity * $order->order_price; }), 2) }}
                </td>
                <td colspan="2"></td>
            </tr>
        @endif
    </tbody>
</table>
</div>

<div class="d-flex justify-content-center mt-2">
    {{ $orders->links('admin.parts.pagination') }}
</div>
