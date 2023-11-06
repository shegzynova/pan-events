<!-- Hotel Id Field -->
<div class="mb-6">
    {!! Form::label('hotel_id', 'Hotel:') !!}
    {!! Form::select('hotel_id', $hotels, null, ['class' => 'tom-select w-full', 'required', 'data-placeholder' => "Select Hotel"]) !!}
</div>

<div class="mb-6">
    {!! Form::label('user_id', 'User:') !!}
    {!! Form::select('user_id', $users, null, ['class' => 'tom-select w-full', 'required', 'data-placeholder' => "Select User", 'onchange' => 'loadTransactions(this.value)']) !!}
</div>



<div class="mb-6">
    {!! Form::label('event_id', 'Event:') !!}
    {!! Form::select('event_id', $events, null, ['class' => 'tom-select w-full', 'required', 'data-placeholder' => "Select Event"]) !!}
</div>

<!-- Quantity Field -->
<div class="mb-3">
    {!! Form::label('quantity', 'Number of Nights:') !!}
    {!! Form::number('quantity', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Ispaid Field -->
<div class="mb-3">
    <div class="form-check">
        {!! Form::hidden('isPaid', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('isPaid', '1', null, ['class' => 'form-check-input', 'id' => 'isPaid']) !!}
        {!! Form::label('isPaid', 'Ispaid', ['class' => 'form-check-label']) !!}
    </div>
</div>

<div class="mb-3">
    {!! Form::label('transaction', 'Transaction:') !!}
    @if(empty($transactions))
        <select data-placeholder="Select Transaction" id='transaction_id' class="" name="transaction_id"></select>
    @else
        <select data-placeholder="Select Transaction" id='transaction_id' class="" name="transaction_id">
            @foreach($transactions AS $transaction)
                <option {{ ($transaction->transaction_reference == optional($reservations->transaction)->transaction_reference) || ($transaction->transaction_reference == old('transaction_id')) ? 'selected' : '' }} value="{{ $transaction->id }}">
                    {{$transaction->event->title . ' for ₦'.  $transaction->amount . ' [' . $transaction->status . ']' }}</option>
            @endforeach
        </select>
    @endif
</div>


<script>
    function loadTransactions(userId) {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: '{{ route("admin.get_user_transactions") }}',
            type: 'POST',
            data: {user_id: userId},
            dataType: 'json',
            success: function (transaction) {
                var transactionsSelect = $('#transaction_id');
                transactionsSelect.empty();

                $.each(transaction, function (key, value) {
                    //console.log(transaction)
                    transactionsSelect.append($('<option>', {
                        value: value.id,
                        text: value.event.title + ' for ₦' + value.amount + ' [' + value.status + ']'
                    }));
                });

                //console.log(transactionsSelect)
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    }
</script>