<table class="table table-bordered border-bottom w-100 table-checkable no-footer " id="logs-table">
    <thead>
        <tr role="row">
            <th class="text-uppercase fw-bold">#</th>
            <th class="text-uppercase fw-bold">{{ @trans('portal.amount') }}</th>
            <th class="text-uppercase fw-bold">{{ @trans('portal.date') }}</th>
        </tr>
    </thead>
    <tbody>
        @if ($withdrawals->isEmpty())
            <tr>
                <td colspan="3" class="text-center text-danger">{{ @trans('messages.no_withdrawal') }}</td>
            </tr>
        @else
            @forelse($withdrawals as $index => $withdrawal)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    {{-- <td>{{ $withdrawal->name ? $withdrawal->name : '-' }}</td> --}}
                    <td>₹ {{ $withdrawal->withdrawal_amount ? number_format($withdrawal->withdrawal_amount, 2) : '-' }}
                    </td>
                    <td style="white-space: nowrap;">
                        {{ $withdrawal->withdrawal_date ? date('d-m-Y', strtotime($withdrawal->withdrawal_date)) : '-' }}
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
{{-- 
<div class="d-md-flex justify-content-center">
    {{ $withdrawals->links('admin.parts.pagination') }}
</div> --}}
