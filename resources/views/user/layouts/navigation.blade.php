<nav class="side-nav">
    <a href="" class="intro-x flex items-center pl-5 pt-4 mt-3">
        <img alt="Midone - HTML Admin Template" class="w-6" src="{{ asset('dist/images/logo.svg') }}">
        <span class="hidden xl:block text-white text-lg ml-3"> Pan Events </span>
    </a>
    <div class="side-nav__devider my-6"></div>
    <ul>
        <li>
            <a href="{{ route('user.dashboard') }}" class="side-menu{{ Request::is('user/dashboard') ? ' side-menu--active' : '' }}">
                <div class="side-menu__icon"> <i data-lucide="home"></i> </div>
                <div class="side-menu__title"> Dashboard </div>
            </a>
        </li>

        <li>
            <a href="{{ route('user.events.index') }}" class="side-menu{{ Request::is('user/events*') ? ' side-menu--active' : '' }}">
                <div class="side-menu__icon"> <i data-lucide="calendar"></i> </div>
                <div class="side-menu__title"> Conferences/Events </div>
            </a>

        </li>

{{--        <li>--}}
{{--            <a href="{{ route('send.message') }}" class="side-menu{{ Request::is('user/messages*') ? ' side-menu--active' : '' }}">--}}
{{--                <div class="side-menu__icon"> <i data-lucide="inbox"></i> </div>--}}
{{--                <div class="side-menu__title"> Messages </div>--}}
{{--            </a>--}}

{{--        </li>--}}

        <li>
            <a href="{{ route('user.transactions') }}" class="side-menu{{ Request::is('user/transactions*') ? ' side-menu--active' : '' }}">
                <div class="side-menu__icon"> <i data-lucide="shopping-bag"></i> </div>
                <div class="side-menu__title"> Transactions </div>
            </a>

        </li>

        {{--<li>
            <a href="{{ route('user.abstracts') }}" class="side-menu{{ Request::is('user/abstracts*') ? ' side-menu--active' : '' }}">
                <div class="side-menu__icon"> <i data-lucide="book"></i> </div>
                <div class="side-menu__title"> My Abstracts </div>
            </a>

        </li>--}}

        <li>
            <a href="{{ route('logout') }}" class="side-menu">
                <div class="side-menu__icon"> <i data-lucide="toggle-right"></i> </div>
                <div class="side-menu__title"> Logout </div>
            </a>

        </li>
    </ul>
</nav>