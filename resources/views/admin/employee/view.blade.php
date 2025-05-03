<div class="row">
    @if ($employees->isEmpty())
        <div class="col-12 text-center text-danger">
            {{ @trans('messages.no_employee') }}
        </div>
    @else
        @foreach ($employees as $employee)
            <div class="col-md-6 col-lg-4 col-xl-3 mb-4">
                <div class="card employee-card shadow-md h-100 border-0 mb-0">
                    <div class="card-body text-center pb-0">
                        @if ($employee->image)
                            <img src="{{ asset('storage/' . $employee->image) }}" alt="Profile"
                                class="rounded-circle clickable-image shadow" width="100" height="100"
                                data-bs-toggle="modal" data-bs-target="#imageModal"
                                data-image="{{ asset('storage/' . $employee->image) }}">
                        @else
                            <img src="{{ asset('images/not_found.jpg') }}" alt="Profile" class="rounded-circle shadow"
                                width="100" height="100">
                        @endif


                        <h5 class="mt-3 text-danger">{{ ucfirst($employee->name ?? '-') }}</h5>
                        <ul class="list-unstyled small text-start mt-3 text-secondary">
                            <li class="mb-2 d-flex justify-content-start">
                                <i
                                    class="fa fa-map-marker me-2 text-danger d-flex justify-content-center align-items-center"></i>
                                <span class="fw-bolder">{{ $employee->address ?? '-' }}</span>
                            </li>
                            <li class="mb-2">
                                <i class="fa fa-phone me-2 text-success"></i>
                                <span class="fw-bolder">{{ $employee->mobile_number ?? '-' }}</span>
                            </li>
                            <li class="mb-2">
                                <i class="fa fa-id-card me-2 text-success"></i>
                                <span class="fw-bolder">{{ formatByGroups($employee->adhar_number, 4) ?? '-' }}</span>
                            </li>
                            <li class="mb-2 d-flex justify-content-start">
                                <i
                                    class="fa fa-envelope me-2 text-primary d-flex justify-content-center align-items-center"></i>
                                <span class="fw-bolder">{{ $employee->email ?? '-' }}</span>
                            </li>
                            <li class="mb-2 pb-1">
                                <i class="fa fa-info-circle me-2 text-warning"></i>
                                <span class="badge {{ $employee->status == 'Active' ? 'bg-success' : 'bg-danger' }}">
                                    {{ $employee->status ?? '-' }}
                                </span>
                            </li>
                            <li class="mb-2">
                                <i class="fa fa-inr me-2 text-success"></i>
                                <span class="fw-bolder">{{ $employee->salary ?? '-' }}</span>
                            </li>
                            <li class="mb-2">
                                <i class="fa fa-calendar me-2 text-muted"></i>
                                <span
                                    class="fw-bolder">{{ $employee->created_at ? date('d-m-Y', strtotime($employee->created_at)) : '-' }}</span>
                            </li>
                        </ul>

                        <div class="mt-3 d-flex justify-content-center gap-2">
                            <a class="btn btn-secondary" href="{{ route('admin.employee.edit', $employee->id) }}">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a class="btn btn-primary user-delete-btn" data-bs-toggle="modal"
                                data-bs-target="#user-delete" data-employee-id="{{ $employee->id }}">
                                <i class="fa fa-trash-o"></i>
                            </a>
                            <a class="btn btn-secondary"
                                href="{{ route('admin.employee.withdrawal', $employee->id) }}">
                                <i class="fa fa-inr"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>

<div class="d-md-flex justify-content-center">
    {{ $employees->links('admin.parts.pagination') }}
</div>
