<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="event-users-table">
            <thead>
            <tr>
                <th>#</th>
                <th>User</th>
                <th>Event</th>
                <th>Paid</th>
                <th>Payment Ref</th>
                <th>Event Amount</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($eventUsers as $eventUser)
                <tr>
                    <td>
                        {!! Form::checkbox('selectedEventUsers[]', $eventUser->id, false, ['class' => 'event-user-checkbox']) !!}
                    </td>
                    <td>{{ optional(optional($eventUser)->user)->full_name }}</td>
                    <td>{{ optional(optional($eventUser)->event)->title }}</td>
                    <td>
                        @if($eventUser->paid)
                            <button class="btn btn-rounded btn-success-soft w-24 mr-1 mb-2">Paid</button>
                        @else
                            <button class="btn btn-rounded btn-pending-soft w-24 mr-1 mb-2">Not Paid</button>
                        @endif
                    </td>
                    <td>
                        @if ($eventUser->payment_ref)
                            <a href="{{ route('admin.transactions.index', ['query' => $eventUser->payment_ref]) }}" target="_blank" class="underline decoration-dotted whitespace-nowrap">{{ $eventUser->payment_ref }}</a>
                        @else
                            {{ $eventUser->payment_ref }}
                        @endif
                    </td>
                    <td>₦{{ number_format($eventUser->total_amount, 2) }}</td>
                    <td>
                        {!! Form::open(['route' => ['admin.eventUsers.destroy', $eventUser->id], 'method' => 'delete']) !!}
                        <div class='flex'>
                            <a href="{{ route('admin.eventUsers.edit', [$eventUser->id]) }}"
                               class='btn btn-default btn-xs mr-2'>
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
            @include('adminlte-templates::common.paginate', ['records' => $eventUsers])
        </div>
    </div>
</div>
