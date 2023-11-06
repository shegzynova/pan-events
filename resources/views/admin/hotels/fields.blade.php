<!-- Name Field -->
<div class="mb-3">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Address Field -->
<div class="mb-3">
    {!! Form::label('address', 'Address:', ['class' => 'form-label']) !!}
    {!! Form::text('address', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Phone Contact Field -->
<div class="mb-3">
    {!! Form::label('phone_contact', 'Phone Contact:') !!}
    {!! Form::text('phone_contact', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Price Field -->
<div class="mb-3">
    {!! Form::label('price', 'Price:') !!}
    {!! Form::number('price', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- No Rooms Available Field -->
<div class="mb-3">
    {!! Form::label('no_rooms_available', 'No Rooms Available:') !!}
    {!! Form::number('no_rooms_available', null, ['class' => 'form-control', 'required']) !!}
</div>

<div class="mb-6">
    {!! Form::label('event_id', 'Event') !!}
    {!! Form::select('event_id', $events, null, ['class' => 'tom-select w-full', 'required', 'data-placeholder' => "Select an event"]) !!}
</div>