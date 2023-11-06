<!-- Type Field -->
<div class="mb-3">
    {!! Form::label('type', 'Type:') !!}
    {!! Form::text('type', null, ['class' => 'form-control mt-3', 'required']) !!}
</div>

<!-- Is Active Field -->
<div class="mb-3">
    <div class="form-check">
        {!! Form::hidden('is_active', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('is_active', '1', null, ['class' => 'form-check-input', 'id' => 'is_active']) !!}
        {!! Form::label('is_active', 'Active', ['class' => 'form-check-label']) !!}
    </div>
</div>