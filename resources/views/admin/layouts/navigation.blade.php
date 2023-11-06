<nav class="side-nav">
    <a href="/" class="intro-x flex items-center pl-5 pt-4 mt-3">
        <img alt="{{config('pan.site_name')}}" class="w-6" src="{{ asset(config('pan.site_logo')) }}">
        <span class="hidden xl:block text-white text-lg ml-3"> {{config('pan.site_name')}} </span>
    </a>
    <div class="side-nav__devider my-6"></div>
    <ul>
        @include('admin.layouts.menu')
    </ul>
</nav>
