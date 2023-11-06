<!-- Event Id Field -->
<div class="mb-6">
    {!! Form::label('event_id', 'Event:') !!}
    {!! Form::select('event_id', $events, null, ['class' => 'tom-select w-full', 'required', 'data-placeholder' => "Select an event"]) !!}
</div>

<!-- User Id Field -->
<div class="mb-6">
    {!! Form::label('user_id', 'User:') !!}
    <select data-placeholder="Select User" class="tom-select w-full" name="user_id"
            onchange="loadTransactions(this.value)">
        <option value="" {{ old('user_id') == '' ? 'selected' : '' }}>Select User</option>
        @foreach($users as $index => $user)
            @if(isset($eventUser))
                <option value="{{ $index }}" {{ ($index == $eventUser->user_id) || ($index == old('user_id')) ? 'selected' : '' }}>
            @else
                <option value="{{ $index }}" {{ ($index == old('user_id')) ? 'selected' : '' }}>
            @endif
                    {{ $user }}
                </option>
        @endforeach
    </select>

</div>

<div class="mb-3">
    {!! Form::label('title', 'Title:') !!}
    {!! Form::select('title', $titles, null, ['class' => 'tom-select w-full', 'required', 'data-placeholder' => 'Select Title']) !!}
</div>

<!-- Surname Field -->
<div class="mb-3">
    {!! Form::label('surname', 'Surname:') !!}
    {!! Form::text('surname', null, ['class' => 'form-control mb-3', 'required', 'maxlength' => 255, 'maxlength' => 255]) !!}
</div>

<!-- Gender Field -->
<div class="mb-3">
    {!! Form::label('gender', 'Gender:') !!}
    {!! Form::select('gender', $genders, null, ['class' => 'tom-select w-full', 'required', 'data-placeholder' => "Select Gender"]) !!}
</div>

<!-- Nature Practice Field -->
<div class="mb-3">
    {!! Form::label('nature_practice', 'Nature Practice:') !!}
    <select required class="tom-select w-full" name="nature_practice" id="crud-form-2">
        <option value="public" {{ old('nature_practice', isset($eventUser->nature_practice) ? $eventUser->nature_practice : '') === 'public' ? 'selected' : '' }}>Public</option>
        <option value="private" {{ old('nature_practice', isset($eventUser->nature_practice) ? $eventUser->nature_practice : '') === 'private' ? 'selected' : '' }}>Private</option>
    </select>
</div>

<!-- Institution Field -->
<div class="mb-3">
    {!! Form::label('institution', 'Institution:') !!}
    {!! Form::text('institution', null, ['class' => 'form-control mb-3', 'required', 'maxlength' => 255, 'maxlength' => 255]) !!}
</div>

<!-- City Field -->
<div class="mb-3">
    {!! Form::label('city', 'City:') !!}
    {!! Form::text('city', null, ['class' => 'form-control mb-3', 'required', 'maxlength' => 255, 'maxlength' => 255]) !!}
</div>

<!-- State Field -->
@php
    $states = App\Models\State::pluck('name', 'id');
@endphp
<div class="mb-3">
    {!! Form::label('state', 'State:') !!}
    {!! Form::select('state', $states, null, ['class' => 'tom-select w-full', 'required', 'data-placeholder' => "Select State"]) !!}
</div>

<!-- Nationality Field -->
@php
    $countries = App\Models\Country::pluck('name', 'id');
@endphp
<div class="mb-3">
    {!! Form::label('nationality', 'Nationality:') !!}
    {!! Form::select('nationality', $countries, null, ['class' => 'tom-select w-full', 'required', 'data-placeholder' => "Select Country"]) !!}
</div>

<!-- Paid Field -->
<div class="mb-3">
    <div class="form-check">
        {!! Form::checkbox('paid', '1', null, ['class' => 'form-check-input', 'id' => 'paid']) !!}
        {{--        {!! Form::hidden('paid', 0, ['class' => 'form-check-input']) !!}--}}
        {!! Form::label('paid', 'Paid', ['class' => 'form-check-label', 'for' => 'paid']) !!}
    </div>
</div>

<!-- Payment Ref Field -->
<div class="mb-3">
    {!! Form::label('transaction', 'Transaction:') !!}
    @if(empty($transactions))
        <select data-placeholder="Select Transaction" id='payment_ref' class="" name="payment_ref"></select>
    @else
        <select data-placeholder="Select Transaction" id='payment_ref' class="" name="payment_ref">
            @foreach($transactions AS $transaction)
                <option {{ ($transaction->transaction_reference == $eventUser->payment_ref) || ($transaction->transaction_reference == old('payment_ref')) ? 'selected' : '' }} value="{{ $transaction->transaction_reference }}">
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
                var transactionsSelect = $('#payment_ref');
                transactionsSelect.empty();

                $.each(transaction, function (key, value) {
                    //console.log(transaction)
                    transactionsSelect.append($('<option>', {
                        value: value.transaction_reference,
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