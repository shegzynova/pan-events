<!DOCTYPE html>
<html lang="en" class="light">
<!-- BEGIN: Head -->
<head>
    <meta charset="utf-8">
    <link href="{{ asset('dist/images/logo.svg') }}" rel="shortcut icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Pan Events Description">
    <meta name="keywords" content="WOW">
    <meta name="author" content="">
    <title>{{ config('app.name', 'Pan Events') }}</title>
    <!-- BEGIN: CSS Assets-->
    <link rel="stylesheet" href="{{ asset('dist/css/app.css') }}" />
    <style>
        /* Media query for small devices */
        @media screen and (max-width: 767px) {
            .scrollable-on-mobile {
                overflow-y: scroll;
                max-height: 100%;
            }
        }
    </style>
    <!-- END: CSS Assets-->
</head>
<!-- END: Head -->
<body class="login scrollable-on-mobile">

<div class="container sm:px-10">
    <div class="block xl:grid grid-cols-2 gap-4">
        <!-- BEGIN: Login Info -->
        <div class="hidden xl:flex flex-col min-h-screen">
            <a href="" class="-intro-x flex items-center pt-5">
                <img alt="Logo" class="w-6" src="{{ asset(config('pan.site_logo')) }}">
                <span class="text-white text-lg ml-3"> {{config('pan.site_name')}} </span>
            </a>
            <div class="my-auto">
                <img alt="{{ config('pan.site_name') }}" class="-intro-x w-1/2 -mt-16" src="dist/images/illustration.svg">
                @php
                    $mostRecentEvent = App\Models\Event::where('is_published', true)
                        ->orderByDesc('date')
                        ->first();
                @endphp
                @if(isset($mostRecentEvent))
                    <div class="-intro-x text-white font-medium text-3xl leading-tight mt-10">
                        {{ $mostRecentEvent->title }}
                        <br>
                        <span class="alert-warning p-1 mt-2 mb-2">{{ $mostRecentEvent->location }}</span>
                        <br>
                        @if ($mostRecentEvent->date)
                            <span>{{ \Carbon\Carbon::parse($mostRecentEvent->date)->format('jS F, Y') }}</span>
                        @endif
                    </div>
                @else
                    <div class="-intro-x text-white font-medium text-4xl leading-tight mt-10">
                        A few more clicks to
                        <br>
                        sign in to your account.
                    </div>
                @endif

                <div class="-intro-x mt-5 text-lg text-white text-opacity-70 dark:text-slate-400">Manage all your event accounts in one place</div>
            </div>
        </div>
        <!-- END: Login Info -->
        <!-- BEGIN: Login Form -->
        <div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0">
            <div class="my-auto mx-auto xl:ml-20 bg-white dark:bg-darkmode-600 xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
                <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">
                    {{ ucwords($type ?? '') }}
                </h2>

                @yield('content')

            </div>
        </div>
        <!-- END: Login Form -->
    </div>
</div>

<!-- BEGIN: JS Assets-->
<script src="{{ asset('dist/js/app.js') }}"></script>
<!-- END: JS Assets-->
</body>
</html>