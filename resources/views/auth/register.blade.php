@extends('layouts.auth', ['type' => 'sign up'])

@section('content')
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="intro-y mt-8">
            @if(!is_null($errors->all()))
                @foreach($errors->all() as $error)
                    <div class="alert alert-danger show flex items-center mb-2" role="alert">
                        <i data-lucide="alert-triangle" class="w-6 h-6 mr-2"></i>
                        {{ $error }}
                    </div>
                @endforeach
            @endif
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 sm:col-span-6">
                    <input name="first_name" value="{{ old('first_name') }}" type="text"
                           class="intro-x  form-control py-3 px-4 block" placeholder="First Name">
                </div>
                <div class="col-span-12 sm:col-span-6">
                    <input name="last_name" value="{{ old('last_name') }}" type="text"
                           class="intro-x  form-control py-3 px-4 block" placeholder="Last Name">
                </div>
                <div class="col-span-12 sm:col-span-6">
                    <input name="username" value="{{ old('username') }}" type="text"
                           class="intro-x  form-control py-3 px-4 block" placeholder="Username">
                </div>
                <div class="col-span-12 sm:col-span-6">
                    <select class="w-full py-3 px-4 block" name="user_type" id="reg_type" required>
                        <option disabled selected>Select Account Type</option>
                        <option value="ordinary_member" {{ old('register_as') === 'ordinary_member' ? 'selected' : '' }}>
                            Ordinary Member
                        </option>
                        <option value="trainee_member" {{ old('register_as') === 'trainee_member' ? 'selected' : '' }}>
                            Trainee Member
                        </option>
                        <option value="associate_member" {{ old('register_as') === 'associate_member' ? 'selected' : '' }}>
                            Associate Member
                        </option>
                    </select>
                </div>
                <div class="col-span-12 sm:col-span-6">
                    <input name="phone" value="{{ old('phone') }}" type="text"
                           class="intro-x  form-control py-3 px-4 block" placeholder="Phone">
                </div>
                <div class="col-span-12 sm:col-span-6">
                    <input name="email" value="{{ old('email') }}" type="text"
                           class="intro-x  form-control py-3 px-4 block" placeholder="Email">
                </div>
                <div class="col-span-12 sm:col-span-6">
                    <input name="password" type="password" class="intro-x  form-control py-3 px-4 block"
                           placeholder="Password">
                </div>
                <div class="col-span-12 sm:col-span-6">
                    <input name="password_confirmation" type="password"
                           class="intro-x  form-control py-3 px-4 block"
                           placeholder="Password Confirmation">
                </div>
            </div>
        </div>

        <div class="intro-x flex items-center text-slate-600 dark:text-slate-500 mt-4 text-xs sm:text-sm">
            <input name="agree" id="remember-me" type="checkbox" class="form-check-input border mr-2">
            <label class="cursor-pointer select-none" for="remember-me">I agree to the Pan Events</label>
            <a class="text-primary dark:text-slate-200 ml-1" href="#">Privacy Policy</a>.
        </div>
        <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
            <button class="btn btn-primary py-3 px-4 w-full xl:w-32 xl:mr-3 align-top">Register</button>
            <a href="{{ route('login') }}"
               class="btn btn-outline-secondary py-3 px-4 w-full xl:w-32 mt-3 xl:mt-0 align-top">Sign in</a>
        </div>

        <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
            <a href="{{route('m-login')}}" class="btn btn-danger-soft py-3 px-4 w-full xl:mr-3 align-top">Click here to login using your PAN Membership Account (portal.pan-ng.org)</a>
        </div>
    </form>
@endsection