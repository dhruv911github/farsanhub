<style>
    /* Small image styling */
    .small-image {
        width: 40px;
        border-radius: 4px;
        padding-right: 2px;
        padding-bottom: 4px;
        cursor: pointer;
    }

    /* Eye icon styling */
    .eye-icon {
        cursor: pointer;
        font-size: 18px;
        margin-left: 10px;
    }
</style>

<table class="table table-bordered border-bottom w-100 table-checkable no-footer " id="logs-table">
    <thead>
        <tr role="row">
            <th class="text-uppercase fw-bold">#</th>
            <th class="text-uppercase fw-bold">{{ @trans('portal.purpose') }}</th>
            <th class="text-uppercase fw-bold">{{ @trans('portal.amount') }}</th>
            <th class="text-uppercase fw-bold">{{ @trans('portal.comment') }}</th>
            <th class="text-uppercase fw-bold">{{ @trans('portal.date') }}</th>
            <th class="text-center text-uppercase fw-bold">{{ @trans('portal.action') }}</th>
        </tr>
    </thead>
    <tbody>
        @if ($expenses->isEmpty())
        <tr>
            <td colspan="6" class="text-center text-danger">{{ @trans('messages.no_expense') }}</td>
        </tr>
        @else
        @forelse($expenses as $index => $expense)
        <tr>
            <td>{{ $expenses->firstItem() + $index }}</td>
            <td>{{ $expense->purpose ? trans('portal.'.$expense->purpose) : '-' }}</td>
            <td>₹ {{ $expense->amount ? $expense->amount : '-' }}</td>
            <td>{{ $expense->comment ? $expense->comment : '-' }}</td>
            <td style="white-space: nowrap;">{{ $expense->date ? date('d-m-Y', strtotime($expense->date)) : '-' }}</td>
            <td class="text-center">
                <div class="btn-group">
                    <a class="secondary edit-technician-btn me-2" href="{{ route('admin.expense.edit', $expense->id) }}"><i class="fa fa-edit"></i></a>
                    <a class="primary user-delete-btn" data-bs-toggle="modal" data-bs-target="#user-delete" data-expense-id="{{ $expense->id }}">
                        <i class="fa fa-trash-o"></i>
                    </a>
                </div>
            </td>
        </tr>
        @endforeach
        @endif
    </tbody>
</table>

<div class="d-md-flex justify-content-center">
    {{ $expenses->links('admin.parts.pagination') }}
</div>
