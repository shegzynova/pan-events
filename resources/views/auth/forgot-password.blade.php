@extends('layouts.auth', ['type' => 'forgot password'])

@section('content')
    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="intro-x mt-2 text-slate-400 xl:hidden text-center">A few more clicks to sign in to your account. Manage all your event accounts in one place</div>
        @if( !is_null( $errors->all() ) )
            @foreach($errors->all() as $error)
                <div class="alert alert-danger show flex items-center mb-2" role="alert"> <i data-lucide="alert-triangle" class="w-6 h-6 mr-2"></i>
                    {{ $error }} </div>
            @endforeach
        @endif

        @if( !is_null( session('status') ) )
            <div class="alert alert-success show flex items-center mb-2" role="alert"> <i data-lucide="alert-triangle" class="w-6 h-6 mr-2"></i>
                {{ session('status') }}
            </div>
        @endif
        <div class="intro-x mt-8">
            <input type="text" class="intro-x login__input form-control py-3 px-4 block" name="email" value="{{old('email')}}" placeholder="Email">
{{--            <input type="password" class="intro-x login__input form-control py-3 px-4 block mt-4" name="password" placeholder="Password">--}}
        </div>
        <div class="intro-x flex text-slate-600 dark:text-slate-500 text-xs sm:text-sm mt-4">
            <div class="flex items-center mr-auto">
{{--                <input id="remember-me" type="checkbox" name="remember" class="form-check-input border mr-2">--}}
{{--                <label class="cursor-pointer select-none" for="remember-me">Remember me</label>--}}
            </div>
            <a href="{{route('login')}}">Login to your account?</a>
        </div>
        <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
            <button class="btn btn-primary py-3 px-4 w-full xl:w-32 xl:mr-3 align-top">Continue</button>
{{--            <a href="{{ route('register') }}" class="btn btn-outline-secondary py-3 px-4 w-full xl:w-32 mt-3 xl:mt-0 align-top">Register</a>--}}
        </div>
        <div class="intro-x mt-10 xl:mt-24 text-slate-600 dark:text-slate-500 text-center xl:text-left"> By signing in, you agree to our <a class="text-primary dark:text-slate-200" href="">Terms and Conditions</a> & <a class="text-primary dark:text-slate-200" href="">Privacy Policy</a> </div>
    </form>
@endsection