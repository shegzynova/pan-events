<!DOCTYPE html>
<html lang="en" id="mainHTML" class="">
<head>
    <meta charset="utf-8">
    <link href="{{ asset('dist/images/logo.svg') }}" rel="shortcut icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <title>{{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('dist/css/app.css') }}" />
    <link rel="stylesheet" href="{{ asset('dist/js/sweetalert2.min.css') }}" />
    <link rel="stylesheet" href="//cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
</head>
<body class="py-5 md:py-0 bg-black/[0.15] dark:bg-transparent">
@include('user.layouts.mobile-navigation')
<div class="flex mt-[4.7rem] md:mt-0 overflow-hidden">

    @include('user.layouts.navigation')

    @yield('content')

{{--    {{dd(session('theme'))}}--}}
    @if(request()->is('*dashboard'))
        <div onclick="switchMode()"
             class="dark-mode-switcher cursor-pointer shadow-md fixed bottom-0 right-0 box dark:bg-dark-2 border rounded-full w-40 h-12 flex items-center justify-center z-50 mb-10 mr-10">
            <div class="mr-4 text-gray-700 dark:text-gray-300">Dark Mode</div>
            <div id="switch" class="border"></div>
        </div>
    @endif

</div>

<script src="{{ asset('dist/js/app.js') }}"></script>
<script src="{{asset('dist/js/ckeditor-classic.js')}}"></script>
<script src="{{asset('dist/js/sweetalert2.all.min.js')}}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('dist/js/jquery.cookie.js') }}"></script>
<script src="//cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

<script>
    function switchMode() {
        var newMode = $.cookie('theme');

        console.log(newMode)
        if (newMode === 'light') {
            $('html').removeClass('light').addClass('dark');
            $('#switch').removeClass('dark-mode-switcher__toggle--active').addClass('dark-mode-switcher__toggle border');
            $.cookie('theme', 'dark', { expires: 365 });
        } else {
            $('html').removeClass('dark').addClass('light');
            $('#switch').addClass('dark-mode-switcher__toggle dark-mode-switcher__toggle--active');
            $.cookie('theme', 'light', { expires: 365 });
        }

        event.preventDefault();
    }
</script>
<script>
    $(document).ready(function() {
        var theme = $.cookie('theme');

        if (theme === 'dark') {
            $('html').addClass('dark');
            $('#switch').addClass('dark-mode-switcher__toggle dark-mode-switcher__toggle--active');
        }else{
            $('html').addClass('light');
            $('#switch').addClass('dark-mode-switcher__toggle');
        }
    });
</script>
<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-right',
        iconColor: 'white',
        customClass: {
            popup: 'colored-toast'
        },
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true
    })

    $('.table').DataTable({
        responsive: true,
        paging: false, // Disable pagination
        searching: false, // Disable search
    });
</script>
<script>
    function logSeen(id){
        $.ajax({
            url: '/update-notification/' + id, // Replace with your actual URL
            type: 'GET',
            success: function(response) {
                // Handle the success response here
                console.log('Notification updated:', response);
            },
            error: function(xhr, status, error) {
                // Handle any errors here
                console.error('Error:', status, error);
            }
        });
    }
</script>
@yield('scripts')

</body>
</html>