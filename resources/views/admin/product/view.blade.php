<div class="row">
    @if ($products->isEmpty())
        <div class="col-12 text-center text-danger">
            {{ @trans('messages.no_product') }}
        </div>
    @else
        @foreach ($products as $product)
            <div class="col-md-6 col-lg-4 col-xl-3 mb-4">
                <div class="card product-card shadow-md h-100 border-0 mb-0">
                    <div class="card-body text-center pb-0">
                        @if ($product->product_image && file_exists(public_path('storage/' . $product->product_image)))
                            <img src="{{ asset('storage/' . $product->product_image) }}" alt="Profile"
                                class="rounded-circle clickable-image shadow" width="100" height="100"
                                data-bs-toggle="modal" data-bs-target="#imageModal"
                                data-image="{{ asset('storage/' . $product->product_image) }}">
                        @else
                            <img src="{{ asset('images/not_found.jpg') }}" alt="Profile" class="rounded-circle shadow"
                                width="100" height="100">
                        @endif


                        <h5 class="mt-3 text-danger">{{ ucfirst($product->product_name ?? '-') }}</h5>
                        <ul class="list-unstyled small text-start mt-3 text-secondary">
                            <li class="mb-2 d-flex justify-content-start">
                                <i
                                    class="fa fa-rupee me-2 text-danger d-flex justify-content-center align-items-center"></i>
                                <span class="fw-bolder">{{ $product->product_base_price ?? '-' }} / kg</span>
                            </li>
                            <li class="mb-2 pb-1">
                                <i class="fa fa-info-circle me-2 text-warning"></i>
                                <span class="badge {{ $product->status == 'Active' ? 'bg-success' : 'bg-danger' }}">
                                    {{ $product->status ?? '-' }}
                                </span>
                            </li>
                            <li class="mb-2">
                                <i class="fa fa-calendar me-2 text-muted"></i>
                                <span
                                    class="fw-bolder">{{ $product->created_at ? date('d-m-Y', strtotime($product->created_at)) : '-' }}</span>
                            </li>
                        </ul>

                        <div class="mt-3 d-flex justify-content-center gap-2">
                            <a class="btn btn-secondary" href="{{ route('admin.product.edit', $product->id) }}">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a class="btn btn-primary user-delete-btn" data-bs-toggle="modal"
                                data-bs-target="#user-delete" data-product-id="{{ $product->id }}">
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
    {{ $products->links('admin.parts.pagination') }}
</div>
