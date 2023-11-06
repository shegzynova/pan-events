<!-- Event Id Field -->
<div class="mb-6">
    {!! Form::label('event_id', 'Event') !!}
    {!! Form::select('event_id', $events, null, ['class' => 'tom-select w-full', 'required', 'data-placeholder' => "Select an event"]) !!}
</div>

<!-- User Id Field -->
<div class="mb-6">
    {!! Form::label('user_id', 'User') !!}
    {!! Form::select('user_id', $users, null, ['class' => 'tom-select w-full', 'required', 'data-placeholder' => "Select a user"]) !!}
</div>

<!-- Amount Field -->
<div class="mb-6">
    {!! Form::label('amount', 'Amount:') !!}
    {!! Form::number('amount', null, ['class' => 'form-control mt-3', 'required']) !!}
</div>

<!-- Status Field -->
<div class="mb-6">
    {!! Form::label('status', 'Status:') !!}
    {!! Form::select('status', $status, null, ['class' => 'tom-select w-full', 'required', 'data-placeholder' => "Select Status"]) !!}
</div>

<div class="mb-6">
    {!! Form::label('payment_method', 'Payment Method:') !!}
    {!! Form::select('payment_method', ['card' => 'Card Payment', 'bank' => 'Bank Transfer'], null, ['class' => 'tom-select w-full', 'required', 'data-placeholder' => "Select Payment method"]) !!}
</div>

<!-- Transaction Reference Field -->
<div class="mb-6">
    {!! Form::label('transaction_reference', 'Transaction Reference:') !!}
    {!! Form::text('transaction_reference', null, ['id' => 'transaction_reference', 'class' => 'form-control w-72 mr-4 mt-3', 'required', 'maxlength' => 255]) !!}
    <button class="btn btn-secondary-soft w-32" onclick="generateRef()">Generate Ref</button>

    <script>
        function generateRef() {
            event.preventDefault();
            $.ajax({
                url: '{{ route("admin.generate.reference") }}',
                type: 'GET',
                dataType: 'text',
                success: function(reference) {
                    if (reference) {
                        $('#transaction_reference').val(reference);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
    </script>

</div>
