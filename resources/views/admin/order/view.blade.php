<div class="row">
    @if ($orders->isEmpty())
        <div class="col-12 text-center text-danger">
            {{ @trans('messages.no_order') }}
        </div>
    @else
        @foreach ($orders as $order)
            <div class="col-md-6 col-lg-4 col-xl-3 mb-4">
                <div class="card order-card shadow-md h-100 border-0 mb-0">
                    <div class="card-body text-center pb-0">
                        @if ($order->order_image && file_exists(public_path('storage/' . $order->order_image)))
                            <img src="{{ asset('storage/' . $order->order_image) }}" alt="Profile"
                                class="rounded-circle clickable-image shadow" width="100" height="100"
                                data-bs-toggle="modal" data-bs-target="#imageModal"
                                data-image="{{ asset('storage/' . $order->order_image) }}">
                        @else
                            <img src="{{ asset('images/not_found.jpg') }}" alt="Profile" class="rounded-circle shadow"
                                width="100" height="100">
                        @endif


                        <h5 class="mt-3 text-danger">{{ ucfirst($order->order_name ?? '-') }}</h5>
                        <ul class="list-unstyled small text-start mt-3 text-secondary">
                            <li class="mb-2 d-flex justify-content-start">
                                <i
                                    class="fa fa-rupee me-2 text-danger d-flex justify-content-center align-items-center"></i>
                                <span class="fw-bolder">{{ $order->order_base_price ?? '-' }} / kg</span>
                            </li>
                            <li class="mb-2 pb-1">
                                <i class="fa fa-info-circle me-2 text-warning"></i>
                                <span class="badge {{ $order->status == 'Active' ? 'bg-success' : 'bg-danger' }}">
                                    {{ $order->status ?? '-' }}
                                </span>
                            </li>
                            <li class="mb-2">
                                <i class="fa fa-calendar me-2 text-muted"></i>
                                <span
                                    class="fw-bolder">{{ $order->created_at ? date('d-m-Y', strtotime($order->created_at)) : '-' }}</span>
                            </li>
                        </ul>

                        <div class="mt-3 d-flex justify-content-center gap-2">
                            <a class="btn btn-secondary" href="{{ route('admin.order.edit', $order->id) }}">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a class="btn btn-primary user-delete-btn" data-bs-toggle="modal"
                                data-bs-target="#user-delete" data-order-id="{{ $order->id }}">
                                <i class="fa fa-trash-o"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>

<div class="d-md-flex justify-content-center">
    {{ $orders->links('admin.parts.pagination') }}
</div>
