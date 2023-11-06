@extends('layouts.auth', ['type' => 'verify email'])

@section('content')
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif
    <div class="intro-x mt-8">
        @if( !is_null( $errors->all() ) )
            @foreach($errors->all() as $error)
                <div class="alert alert-danger show flex items-center mb-2" role="alert"><i data-lucide="alert-triangle"
                                                                                            class="w-6 h-6 mr-2"></i>
                    {{ $error }} </div>
            @endforeach
        @endif
    </div>

    <div class="intro-x mt-5 xl:mt-8 text-center xl:text- flex">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button class="btn btn-primary py-3 px-4 w-full xl:mr-3 xl:w-auto align-top">Resend Verification Email
            </button>
        </form>

        <form method="GET" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-danger-soft py-3 px-4 xl:w-auto w-full xl:mr-3 align-top">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
@endsection