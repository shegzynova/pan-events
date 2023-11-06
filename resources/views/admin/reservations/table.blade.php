<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="reservations-table">
            <thead>
            <tr>
                <th>Event</th>
                <th width="20%">Hotel</th>
                <th>No. of Nights/Cost</th>
                <th>Total Amount</th>
                <th>User</th>
                <th>Status</th>
                <th>Payment Ref</th>
                <th colspan="3">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($reservations as $reservation)
                <tr>
                    <td>{{ optional($reservation->event)->title }}</td>
                    <td>{{ optional(optional($reservation)->hotel)->name }}</td>
                    <td>
                        @if($reservation->total_amount)
                            {{ $reservation->quantity }} Night(s)<br>
                            <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">{{ number_format(($reservation->total_amount)/($reservation->quantity), 2) }} / Night</div>
                        @else
                            {{ $reservation->quantity }}
                        @endif
                    </td>
                    <td>
                       @if($reservation->total_amount)
                            ₦{{ number_format($reservation->total_amount, 2) }}
                       @endif
                    </td>
                    <td>{{ $reservation->user->first_name }} {{ $reservation->user->last_name }}</td>
                    <td>
                        @if($reservation->isPaid)
                            <button class="btn btn-rounded btn-success-soft w-24 mr-1 mb-2">Paid</button>
                        @else
                            <button class="btn btn-rounded btn-pending-soft w-24 mr-1 mb-2">Reserved</button>
                        @endif
                    </td>
                    <td>
                        @if($reservation->isPaid && $reservation->transaction_reference)
                            <a href="{{ route('admin.transactions.index', ['query' => $reservation->transaction_reference]) }}" target="_blank" class="underline decoration-dotted whitespace-nowrap">{{ $reservation->transaction_reference }}</a>
                        @elseif($reservation->isPaid && $reservation->payment_ref)
                            {{ $reservation->payment_ref }}
                            <div class="flex items-center text-slate-500">
                                <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="lightbulb" data-lucide="lightbulb" class="lucide lucide-lightbulb w-5 h-5 text-warning"><line x1="9" y1="18" x2="15" y2="18"></line><line x1="10" y1="22" x2="14" y2="22"></line><path d="M15.09 14c.18-.98.65-1.74 1.41-2.5A4.65 4.65 0 0018 8 6 6 0 006 8c0 1 .23 2.23 1.5 3.5A4.61 4.61 0 018.91 14"></path></svg></span>
                                <div class="ml-2"><a class="text-primary font-medium">Booked Separately</a> </div>
                            </div>
                        @else
                            N/A
                        @endif
                    </td>
                    <td  style="width: 220px">
                        {!! Form::open(['route' => ['admin.reservations.destroy', $reservation->id], 'method' => 'delete']) !!}
                        <div class='flex'>
                            <a href="{{ route('admin.reservations.edit', [$reservation->id]) }}"
                               class='btn btn-default btn-xs'>
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
            @include('adminlte-templates::common.paginate', ['records' => $reservations])
        </div>
    </div>
</div>
