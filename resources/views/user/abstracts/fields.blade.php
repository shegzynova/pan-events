<!-- Full Name Field -->
<div class="mb-3">
    {!! Form::label('full_name', 'Full Name:') !!}
    {!! Form::text('full_name', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Contact Phone Number Field -->
<div class="mb-3">
    {!! Form::label('contact_phone_number', 'Contact Phone Number:') !!}
    {!! Form::text('contact_phone_number', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Email Field -->
<div class="mb-3">
    {!! Form::label('email', 'Email:') !!}
    {!! Form::email('email', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Address Field -->
<div class="mb-3">
    {!! Form::label('address', 'Address:') !!}
    {!! Form::textarea('address', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- No Of Pages Field -->
<div class="mb-3">
    {!! Form::label('no_of_pages', 'No Of Pages:') !!}
    {!! Form::number('no_of_pages', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Abstract Title Field -->
<div class="mb-3">
    {!! Form::label('abstract_title', 'Abstract Title:') !!}
    {!! Form::text('abstract_title', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Duration Field -->
<div class="mb-3">
    {!! Form::label('duration', 'Duration:') !!}
    {!! Form::number('duration', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Additional Information Field -->
<div class="mb-3">
    {!! Form::label('additional_information', 'Additional Information:') !!}
    {!! Form::textarea('additional_information', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- File Field -->
<div class="mb-3">
    {!! Form::label('file', 'File:') !!}
    <div class="input-group">
        <div class="custom-file">
            {!! Form::file('file', ['class' => 'custom-file-input']) !!}
            {!! Form::label('file', 'Choose file', ['class' => 'custom-file-label']) !!}
        </div>
    </div>
</div>
<div class="clearfix"></div>