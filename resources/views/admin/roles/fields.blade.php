<div class="mb-3">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control mb-3', 'required', 'maxlength' => 255, 'maxlength' => 255]) !!}
</div>

<div class="mb-3">
    {!! Form::label('permission', 'Permission:') !!}
    {!! Form::select('permission[]', $permissions, $rolePermissions ?? null, ['class' => 'tom-select w-full', 'required', 'data-placeholder' => 'Select Permissions', 'multiple']) !!}
</div>

