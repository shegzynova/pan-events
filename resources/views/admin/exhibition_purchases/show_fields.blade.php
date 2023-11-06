<!-- Exhibition Id Field -->
<div class="col-sm-12">
    {!! Form::label('exhibition_id', 'Exhibition Id:') !!}
    <p>{{ $exhibitionPurchase->exhibition_id }}</p>
</div>

<!-- Attendance Id Field -->
<div class="col-sm-12">
    {!! Form::label('attendance_id', 'Attendance Id:') !!}
    <p>{{ $exhibitionPurchase->attendance_id }}</p>
</div>

<!-- Paid Field -->
<div class="col-sm-12">
    {!! Form::label('paid', 'Paid:') !!}
    <p>{{ $exhibitionPurchase->paid }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $exhibitionPurchase->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $exhibitionPurchase->updated_at }}</p>
</div>

