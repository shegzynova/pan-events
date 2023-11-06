<li>
    <a href="{{ route('user.dashboard') }}" class="menu{{ Request::is('user/dashboard') ? ' menu--active' : '' }}">
        <div class="menu__icon"> <i data-lucide="inbox"></i> </div>
        <div class="menu__title"> Dashboard </div>
    </a>
</li>

<li>
    <a href="{{ route('user.events.index') }}" class="menu{{ Request::is('user/events*') ? ' menu--active' : '' }}">
        <div class="menu__icon"> <i data-lucide="calendar"></i> </div>
        <div class="menu__title"> Conferences/Events </div>
    </a>

</li>

{{--<li>--}}
{{--    <a href="{{ route('send.message') }}" class="menu{{ Request::is('user/messages*') ? ' menu--active' : '' }}">--}}
{{--        <div class="menu__icon"> <i data-lucide="inbox"></i> </div>--}}
{{--        <div class="menu__title"> Messages </div>--}}
{{--    </a>--}}

{{--</li>--}}

<li>
    <a href="{{ route('user.transactions') }}" class="menu{{ Request::is('user/transactions*') ? ' menu--active' : '' }}">
        <div class="menu__icon"> <i data-lucide="shopping-bag"></i> </div>
        <div class="menu__title"> Transactions </div>
    </a>

</li>

<li>
    <a href="{{ route('logout') }}" class="menu">
        <div class="menu__icon"> <i data-lucide="toggle-right"></i> </div>
        <div class="menu__title"> Logout </div>
    </a>

</li>