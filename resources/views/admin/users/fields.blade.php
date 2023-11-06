<!-- First Name Field -->
<div class="mb-3">
    {!! Form::label('first_name', 'First Name:') !!}
    {!! Form::text('first_name', null, ['class' => 'form-control mt-3', 'required', 'maxlength' => 255, 'maxlength' => 255]) !!}
</div>

<!-- Last Name Field -->
<div class="mb-3">
    {!! Form::label('last_name', 'Last Name:') !!}
    {!! Form::text('last_name', null, ['class' => 'form-control mt-3', 'required', 'maxlength' => 255, 'maxlength' => 255]) !!}
</div>

<!-- Username Field -->
<div class="mb-3">
    {!! Form::label('username', 'Username:') !!}
    {!! Form::text('username', null, ['class' => 'form-control mt-3', 'required', 'maxlength' => 255, 'maxlength' => 255]) !!}
</div>

<!-- Phone Field -->
<div class="mb-3">
    {!! Form::label('phone', 'Phone:') !!}
    {!! Form::text('phone', null, ['class' => 'form-control mt-3', 'required', 'maxlength' => 255, 'maxlength' => 255]) !!}
</div>

<!-- Email Field -->
<div class="mb-3">
    {!! Form::label('email', 'Email:') !!}
    {!! Form::email('email', null, ['class' => 'form-control mt-3', 'required', 'maxlength' => 255, 'maxlength' => 255]) !!}
</div>

<div class="mb-6">
    {!! Form::label('role', 'Role:') !!}
    @if(isset($user))
    {!! Form::select('role', array_combine(array_keys($roles), array_map('ucfirst', $roles)), $user->roles->pluck('id'), ['class' => 'tom-select w-full', 'required', 'data-placeholder' => "Select Role"]) !!}
    @else
        {!! Form::select('role', array_combine(array_keys($roles), array_map('ucfirst', $roles)), null, ['class' => 'tom-select w-full', 'required', 'data-placeholder' => "Select Role"]) !!}
    @endif
</div>

<div class="mb-6">
    {!! Form::label('user_type', 'User Type:') !!}
    @if(isset($user))
        {!! Form::select('user_type', array_combine(array_keys($user_types), array_map('ucfirst', $user_types)), $user->user_type, ['class' => 'tom-select w-full', 'data-placeholder' => "Select User Type"]) !!}
    @else
        {!! Form::select('user_type', array_combine(array_keys($user_types), array_map('ucfirst', $user_types)), null, ['class' => 'tom-select w-full', 'data-placeholder' => "Select User Type"]) !!}
    @endif
</div>

<div class="mb-3">
    {!! Form::label('permission', 'Permission:') !!}
    {!! Form::select('permission[]', $permissions, $rolePermissions ?? null, ['class' => 'tom-select w-full', 'data-placeholder' => 'Select Permissions', 'multiple']) !!}
</div>
