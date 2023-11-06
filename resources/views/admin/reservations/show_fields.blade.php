<!-- Hotel Id Field -->
<div class="col-sm-12">
    {!! Form::label('hotel_id', 'Hotel Id:') !!}
    <p>{{ $reservations->hotel_id }}</p>
</div>

<!-- Quantity Field -->
<div class="col-sm-12">
    {!! Form::label('quantity', 'Number of Nights:') !!}
    <p>{{ $reservations->quantity }}</p>
</div>

<!-- Ispaid Field -->
<div class="col-sm-12">
    {!! Form::label('isPaid', 'Ispaid:') !!}
    <p>{{ $reservations->isPaid }}</p>
</div>

