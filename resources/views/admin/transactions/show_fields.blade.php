<!-- Event Id Field -->
<div class="col-sm-12">
    {!! Form::label('event_id', 'Event Id:') !!}
    <p>{{ $transaction->event_id }}</p>
</div>

<!-- User Id Field -->
<div class="col-sm-12">
    {!! Form::label('user_id', 'User Id:') !!}
    <p>{{ $transaction->user_id }}</p>
</div>

<!-- Amount Field -->
<div class="col-sm-12">
    {!! Form::label('amount', 'Amount:') !!}
    <p>{{ $transaction->amount }}</p>
</div>

<!-- Status Field -->
<div class="col-sm-12">
    {!! Form::label('status', 'Status:') !!}
    <p>{{ $transaction->status }}</p>
</div>

<!-- Transaction Reference Field -->
<div class="col-sm-12">
    {!! Form::label('transaction_reference', 'Transaction Reference:') !!}
    <p>{{ $transaction->transaction_reference }}</p>
</div>


<div class="col-sm-12">
    {!! Form::label('payment_method', 'Payment Method:') !!}
    <p>{{ $transaction->payment_method == 'card' ? 'Card Payment' : 'Bank Transfer/Online Payment' }}</p>
</div>

