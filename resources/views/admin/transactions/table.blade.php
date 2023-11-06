<style>
    .disabled{
        pointer-events: none;
        background-color: darkgrey;
        border: none;
    }
</style>
<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="transactions-table">
            <thead>
            <tr>
                <th>Receipt</th>
                <th>Event</th>
                <th>User</th>
                <th>Total Amount</th>
                <th>Status</th>
                <th>Transaction Reference</th>
                <th>Payment Method</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($transactions as $transaction)
                <tr>
                    <td>
                        <a title="Download Receipt" href="{{ route('admin.download-receipt', $transaction->id) }}" target="_blank"
                           class='btn btn-default btn-primary btn-xs mr-2 @if( $transaction->status !== 'successful' ) disabled @endif'><i data-lucide="download"></i>
                        </a>
                    </td>
                    <td>{{ optional(optional($transaction)->event)->title }}</td>
                    <td>{{ optional(optional($transaction)->user)->full_name }}</td>
                    <td>₦{{ number_format($transaction->amount, 2) }}</td>
                    <td>
                        @if($transaction->status == 'pending')
                            <button class="btn btn-rounded btn-pending-soft w-24 mr-1 mb-2">Pending</button>
                        @elseif($transaction->status == 'failed')
                            <button class="btn btn-rounded btn-danger-soft w-24 mr-1 mb-2">Failed</button>
                        @else
                            <button class="btn btn-rounded btn-success-soft w-24 mr-1 mb-2">Success</button>
                        @endif
                    </td>
                    <td>{{ $transaction->transaction_reference }}</td>
                    <td> {{ $transaction->payment_method == 'card' ? 'Card Payment' : 'Bank Transfer/Online Payment' }} </td>
                    <td>
                        {!! Form::open(['route' => ['admin.transactions.destroy', $transaction->id], 'method' => 'delete']) !!}
                        <div class='flex'>
                            <a href="{{ route('admin.transactions.edit', [$transaction->id]) }}"
                               class='btn btn-default btn-sm mr-2'>
                                <i data-lucide="edit-2"></i>
                            </a>
                            {!! Form::button('<i data-lucide="trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm', 'onclick' => "return confirm('Are you sure?')"]) !!}
                        </div>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="card-footer clearfix">
        <div class="float-right">
            @include('adminlte-templates::common.paginate', ['records' => $transactions])
        </div>
    </div>
</div>
