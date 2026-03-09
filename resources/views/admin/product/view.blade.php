@if ($products->isEmpty())
    <div class="col-12 text-center text-danger py-4">
        {{ @trans('messages.no_product') }}
    </div>
@else
    <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="text-center" style="width:60px;">#</th>
                    <th>{{ @trans('portal.product_image') }}</th>
                    <th>{{ @trans('portal.product_name') }}</th>
                    <th>{{ @trans('portal.product_base_price') }}</th>
                    {{-- <th class="text-center">{{ @trans('portal.status') }}</th> --}}
                    <th class="text-center text-nowrap">{{ @trans('portal.created_at') }}</th>
                    <th class="text-center" style="width:100px;">{{ @trans('portal.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $index => $product)
                    <tr>
                        <td class="text-center text-muted small">
                            {{ ($products->currentPage() - 1) * $products->perPage() + $loop->iteration }}
                        </td>
                        <td class="text-center">
                            @if ($product->product_image && file_exists(public_path('storage/' . $product->product_image)))
                                <img src="{{ asset('storage/' . $product->product_image) }}" alt="img"
                                    class="rounded clickable-image" width="44" height="44" style="object-fit:cover; cursor:pointer;"
                                    data-bs-toggle="modal" data-bs-target="#imageModal"
                                    data-image="{{ asset('storage/' . $product->product_image) }}">
                            @else
                                <img src="{{ asset('images/logo.png') }}" alt="img" class="rounded" width="44" height="44" style="object-fit:cover;">
                            @endif
                        </td>
                        <td class="fw-semibold">{{ ucfirst($product->product_name ?? '-') }}</td>
                        <td class="text-nowrap">
                            <i class="fa fa-rupee text-danger"></i>
                            <span class="fw-bold">{{ $product->effective_price ?? $product->product_base_price }}</span>
                            <span class="text-muted small">/ {{ $product->unit ?? 'kg' }}</span>
                            @if(isset($product->specific_price) && $product->specific_price)
                                <span class="badge bg-danger ms-1" style="font-size:0.68rem;">Specific</span>
                            @elseif(request()->has('customer_id') && request()->customer_id)
                                <span class="badge bg-secondary ms-1" style="font-size:0.68rem;">Base</span>
                            @endif
                        </td>
                        {{-- <td class="text-center">
                            <span class="badge {{ $product->status == 'Active' ? 'bg-success' : 'bg-danger' }}">
                                {{ $product->status ?? '-' }}
                            </span>
                        </td> --}}
                        <td class="text-center text-nowrap small text-muted">
                            {{ $product->created_at ? date('d-m-Y', strtotime($product->created_at)) : '-' }}
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                <a class="secondary" href="{{ route('admin.product.edit', $product->id) }}" title="Edit">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a class="primary user-delete-btn" data-bs-toggle="modal"
                                    data-bs-target="#user-delete" data-product-id="{{ $product->id }}" title="Delete">
                                    <i class="fa fa-trash-o"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif

<div class="d-flex justify-content-center mt-3">
    {{ $products->links('admin.parts.pagination') }}
</div>
