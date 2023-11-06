<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="exhibition-purchases-table">
            <thead>
            <tr>
                <th>Exhibition</th>
                <th>Attendee</th>
                <th>Amount</th>
                <th>Paid</th>
                <th colspan="3">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($exhibitionPurchases as $exhibitionPurchase)
                <tr>
                    <td>{{ optional($exhibitionPurchase->exhibition)->description }} - {{ optional($exhibitionPurchase->exhibition)->category }} ({{ optional(optional($exhibitionPurchase->exhibition)->type)->type }})</td>
                    <td>{{ $exhibitionPurchase->attendance->first_name }} {{ $exhibitionPurchase->attendance->surname }}</td>
                    <td>
                        @if($exhibitionPurchase->total_amount)
                            ₦{{ number_format($exhibitionPurchase->total_amount, 2) }}
                        @endif
                    </td>
                    <td>
                        @if($exhibitionPurchase->paid == 'paid')
                            <button class="btn btn-rounded btn-success-soft w-24 mr-1 mb-2">Paid</button>
                        @else
                            <button class="btn btn-rounded btn-pending-soft w-24 mr-1 mb-2">Not Paid</button>
                        @endif
                    </td>
                    <td  style="width: 120px">
                        {!! Form::open(['route' => ['admin.exhibitionPurchases.destroy', $exhibitionPurchase->id], 'method' => 'delete']) !!}
                        <div class='btn-group flex'>
                            <a href="{{ route('admin.exhibitionPurchases.edit', [$exhibitionPurchase->id]) }}"
                               class='btn btn-default btn-xs mr-3'>
                                <i data-lucide="edit-2"></i>
                            </a>
                            {!! Form::button('<i data-lucide="trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
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
            @include('adminlte-templates::common.paginate', ['records' => $exhibitionPurchases])
        </div>
    </div>
</div>
