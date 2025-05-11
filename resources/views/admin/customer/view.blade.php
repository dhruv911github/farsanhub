<div class="row">
    @if ($customers->isEmpty())
        <div class="col-12 text-center text-danger">
            {{ @trans('portal.no_customer') }}
        </div>
    @else
        @foreach ($customers as $customer)
            <div class="col-md-6 col-lg-4 col-xl-3 mb-4">
                <div class="card customer-card shadow-md h-100 border-0 mb-0">
                    <div class="card-body text-center pb-0">
                        @if ($customer->customer_image && file_exists(public_path('storage/' . $customer->customer_image)))
                            <img src="{{ asset('storage/' . $customer->customer_image) }}" alt="Profile"
                                class="rounded-circle clickable-image shadow" width="100" height="100"
                                data-bs-toggle="modal" data-bs-target="#imageModal"
                                data-image="{{ asset('storage/' . $customer->customer_image) }}">
                        @else
                            <img src="{{ asset('images/not_found.jpg') }}" alt="Profile" class="rounded-circle shadow"
                                width="100" height="100">
                        @endif


                        <h5 class="mt-3 text-danger">{{ ucfirst($customer->customer_name ?? '-') }}</h5>
                        <ul class="list-unstyled small text-start mt-3 text-secondary">
                            <li class="mb-2 d-flex justify-content-start">
                                <i
                                    class="fa fa-map-marker me-2 text-danger d-flex justify-content-center align-items-center"></i>
                                <span class="fw-bolder">{{ $customer->shop_address ?? '-' }}</span>
                            </li>
                            <li class="mb-2">
                                <i class="fa fa-phone me-2 text-success"></i>
                                <span class="fw-bolder">{{ $customer->customer_number ?? '-' }}</span>
                            </li>
                            <li class="mb-2 d-flex justify-content-start">
                                <i
                                    class="fa fa-envelope me-2 text-primary d-flex justify-content-center align-items-center"></i>
                                <span class="fw-bolder">{{ $customer->customer_email ?? '-' }}</span>
                            </li>
                            <li class="mb-2 pb-1">
                                <i class="fa fa-info-circle me-2 text-warning"></i>
                                <span class="badge {{ $customer->status == 'Active' ? 'bg-success' : 'bg-danger' }}">
                                    {{ $customer->status ?? '-' }}
                                </span>
                            </li>
                            <li class="mb-2">
                                <i class="fa fa-home me-2 text-success"></i>
                                <span class="fw-bolder">{{ $customer->city ?? '-' }}</span>
                            </li>
                            <li class="mb-2">
                                <i class="fa fa-calendar me-2 text-muted"></i>
                                <span
                                    class="fw-bolder">{{ $customer->created_at ? date('d-m-Y', strtotime($customer->created_at)) : '-' }}</span>
                            </li>
                        </ul>

                        <div class="mt-3 d-flex justify-content-center gap-2">
                            <a class="btn btn-secondary" href="{{ route('admin.customer.edit', $customer->id) }}">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a class="btn btn-primary"
                                href="{{ route('admin.order.index', ['customer_id' => $customer->id]) }}">
                                <i class="fa fa-shopping-cart"></i>
                            </a>
                            <a class="btn btn-secondary user-delete-btn" data-bs-toggle="modal"
                                data-bs-target="#user-delete" data-customer-id="{{ $customer->id }}">
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
    {{ $customers->links('admin.parts.pagination') }}
</div>
