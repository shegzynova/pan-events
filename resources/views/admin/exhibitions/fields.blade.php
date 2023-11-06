<!-- Category Field -->
<div class="mb-3">
    {!! Form::label('category', 'Category:') !!}
    {!! Form::text('category', null, ['class' => 'form-control mt-2', 'required']) !!}
</div>

<!-- Amount Field -->
<div class="mb-3">
    {!! Form::label('amount', 'Amount:') !!}
    {!! Form::number('amount', null, ['class' => 'form-control mt-2', 'required']) !!}
</div>

<!-- Description Field -->
<div class="mb-3">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control mt-2', 'required']) !!}
</div>

<!-- Exhibition Type Id Field -->
<div class="mb-3">
    {!! Form::label('exhibition_type_id', 'Exhibition Type:') !!}
    {!! Form::select('exhibition_type_id', $exhibition_types, null, ['class' => 'form-control mt-2', 'required']) !!}
</div>