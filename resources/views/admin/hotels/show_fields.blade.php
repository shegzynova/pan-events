<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $hotel->name }}</p>
</div>

<!-- Address Field -->
<div class="col-sm-12">
    {!! Form::label('address', 'Address:') !!}
    <p>{{ $hotel->address }}</p>
</div>

<!-- Phone Contact Field -->
<div class="col-sm-12">
    {!! Form::label('phone_contact', 'Phone Contact:') !!}
    <p>{{ $hotel->phone_contact }}</p>
</div>

<!-- Price Field -->
<div class="col-sm-12">
    {!! Form::label('price', 'Price:') !!}
    <p>{{ $hotel->price }}</p>
</div>

<!-- No Rooms Available Field -->
<div class="col-sm-12">
    {!! Form::label('no_rooms_available', 'No Rooms Available:') !!}
    <p>{{ $hotel->no_rooms_available }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $hotel->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $hotel->updated_at }}</p>
</div>

