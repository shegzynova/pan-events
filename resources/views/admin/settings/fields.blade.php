<div class="mb-3">
    {!! Form::label('site_name', 'Site Name:') !!}
    {!! Form::text('site_name', optional($settings)['site_name'], ['class' => 'form-control mt-3', 'maxlength' => 255]) !!}
</div>

<div class="mb-3">
    {!! Form::label('site_slogan', 'Site Slogan/Tagline:') !!}
    {!! Form::text('site_slogan', optional($settings)['site_slogan'], ['class' => 'form-control mt-3', 'maxlength' => 255]) !!}
</div>

<div class="mb-3">
    {!! Form::label('site_logo', 'Site Logo/Favicon:') !!}
    {!! Form::file('site_logo', ['class' => 'form-control mt-3', 'accept' => 'image/*']) !!}
</div>

<div class="mb-3">
    {!! Form::label('phone_number', 'Phone Number:') !!}
    {!! Form::tel('phone_number', optional($settings)['phone_number'], ['class' => 'form-control mt-3', 'maxlength' => 20]) !!}
</div>

<div class="mb-3">
    {!! Form::label('email', 'Email:') !!}
    {!! Form::email('email', optional($settings)['email'], ['class' => 'form-control mt-3', 'maxlength' => 255]) !!}
</div>

<div class="mb-3">
    {!! Form::label('facebook', 'Facebook:') !!}
    {!! Form::url('facebook', optional($settings)['facebook'], ['class' => 'form-control mt-3', 'maxlength' => 255]) !!}
</div>

<div class="mb-3">
    {!! Form::label('twitter', 'Twitter:') !!}
    {!! Form::url('twitter', optional($settings)['twitter'], ['class' => 'form-control mt-3', 'maxlength' => 255]) !!}
</div>

<div class="mb-3">
    {!! Form::label('instagram', 'Instagram:') !!}
    {!! Form::url('instagram', optional($settings)['instagram'], ['class' => 'form-control mt-3', 'maxlength' => 255]) !!}
</div>

<div class="mb-3">
    {!! Form::label('youtube', 'Youtube:') !!}
    {!! Form::url('youtube', optional($settings)['youtube'], ['class' => 'form-control mt-3', 'maxlength' => 255]) !!}
</div>

<div class="mb-3">
    {!! Form::label('smtp_username', 'SMTP Username:') !!}
    {!! Form::text('smtp_username', optional($settings)['smtp_username'], ['class' => 'form-control mt-3', 'maxlength' => 255]) !!}
</div>

<div class="mb-3">
    {!! Form::label('smtp_password', 'SMTP Password:') !!}
    {!! Form::text('smtp_password', optional($settings)['smtp_password'], ['class' => 'form-control mt-3',]) !!}
</div>

<div class="mb-3">
    {!! Form::label('smtp_host', 'SMTP Host:') !!}
    {!! Form::text('smtp_host', optional($settings)['smtp_host'], ['class' => 'form-control mt-3', 'maxlength' => 255]) !!}
</div>

<div class="mb-3">
    {!! Form::label('smtp_from_address', 'SMTP From Address:') !!}
    {!! Form::email('smtp_from_address', optional($settings)['smtp_from_address'], ['class' => 'form-control mt-3', 'maxlength' => 255]) !!}
</div>

<div class="mb-3">
    {!! Form::label('smtp_from_name', 'SMTP From Name:') !!}
    {!! Form::text('smtp_from_name', optional($settings)['smtp_from_name'], ['class' => 'form-control mt-3', 'maxlength' => 255]) !!}
</div>

<div class="mb-3">
    {!! Form::label('smtp_mail_port', 'SMTP Mail Port:') !!}
    {!! Form::number('smtp_mail_port', optional($settings)['smtp_mail_port'], ['class' => 'form-control mt-3',]) !!}
</div>

<div class="mb-3">
    {!! Form::label('sms_sender', 'SMS Sender:') !!}
    {!! Form::text('sms_sender', optional($settings)['sms_sender'], ['class' => 'form-control mt-3', 'maxlength' => 255]) !!}
</div>

<div class="mb-3">
    {!! Form::label('sms_username', 'SMS Username:') !!}
    {!! Form::text('sms_username', optional($settings)['sms_username'], ['class' => 'form-control mt-3', 'maxlength' => 255]) !!}
</div>

<div class="mb-3">
    {!! Form::label('sms_password', 'SMS Password:') !!}
    {!! Form::text('sms_password', optional($settings)['sms_password'], ['class' => 'form-control mt-3', 'maxlength' => 255]) !!}
</div>

<div class="mb-3">
    {!! Form::label('paystack_key', 'Paystack Key:') !!}
    {!! Form::text('paystack_key', optional($settings)['paystack_key'], ['class' => 'form-control mt-3', 'maxlength' => 255]) !!}
</div>

<div class="mb-3">
    {!! Form::label('extra_charge', 'Extra Charge:') !!}
    {!! Form::number('extra_charge', optional($settings)['extra_charge'], ['class' => 'form-control mt-3', 'step' => '0.01']) !!}
</div>

<div class="mb-3">
    {!! Form::label('bank_name', 'Bank Name:') !!}
    {!! Form::text('bank_name', optional($settings)['bank_name'], ['class' => 'form-control mt-3', 'maxlength' => 255]) !!}
</div>

<div class="mb-3">
    {!! Form::label('account_name', 'Account Name:') !!}
    {!! Form::text('account_name', optional($settings)['account_name'], ['class' => 'form-control mt-3', 'maxlength' => 255]) !!}
</div>

<div class="mb-3">
    {!! Form::label('account_number', 'Account Number:') !!}
    {!! Form::number('account_number', optional($settings)['account_number'], ['class' => 'form-control mt-3', 'step' => '0.01']) !!}
</div>

<div class="mb-3">
    {!! Form::label('meta_title', 'Meta Title:') !!}
    {!! Form::text('meta_title', optional($settings)['meta_title'], ['class' => 'form-control mt-3', 'maxlength' => 255]) !!}
</div>

<div class="mb-3">
    {!! Form::label('meta_description', 'Meta Description:') !!}
    {!! Form::textarea('meta_description', optional($settings)['meta_description'], ['class' => 'form-control mt-3', 'maxlength' => 255]) !!}
</div>

<div class="mb-3">
    {!! Form::label('meta_keywords', 'Meta Keywords:') !!}
    {!! Form::text('meta_keywords', optional($settings)['meta_keywords'], ['class' => 'form-control mt-3', 'maxlength' => 255]) !!}
</div>

<div class="mb-3">
    {!! Form::label('payment_split_code', 'Payment Split Code:') !!}
    {!! Form::text('payment_split_code', optional($settings)['payment_split_code'], ['class' => 'form-control mt-3', 'maxlength' => 255]) !!}
</div>

<div class="mb-3">
    <a href="{{route('admin.config.cache')}}" class="btn btn-danger">Clear Cache</a>
</div>
