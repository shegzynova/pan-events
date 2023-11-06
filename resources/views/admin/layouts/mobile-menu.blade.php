<li>
    <a href="{{ route('admin.dashboard') }}" class="menu{{ Request::is('admin/dashboard') ? ' menu--active' : '' }}">
        <div class="menu__icon"> <i data-lucide="inbox"></i> </div>
        <div class="menu__title"> Dashboard </div>
    </a>
</li>

<li>
    <a href="{{ route('admin.events.index') }}" class="menu{{ Request::is('admin/events*') ? ' menu--active' : '' }}">
        <div class="menu__icon"> <i data-lucide="calendar"></i> </div>
        <div class="menu__title"> Conferences/Events </div>
    </a>

</li>

<li class="nav-item">
    <a href="{{ route('admin.hotels.index') }}" class="menu {{ Request::is('admin/hotels*') ? ' menu--active' : '' }}">
        <div class="menu__icon"> <i data-lucide="home"></i> </div>
        <div class="menu__title"> Hotels </div>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('admin.transactions.index') }}" class="menu {{ Request::is('admin/transactions*') ? ' menu--active' : '' }}">
        <div class="menu__icon"> <i data-lucide="shopping-bag"></i> </div>
        <div class="menu__title"> Transactions </div>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('admin.users.index') }}" class="menu {{ Request::is('admin/users*') ? ' menu--active' : '' }}">
            <div class="menu__icon"> <i data-lucide="users"></i> </div>
            <div class="menu__title"> Users </div>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('admin.eventUsers.index') }}" class="menu {{ Request::is('admin/event-users*') ? ' menu--active' : '' }}">
            <div class="menu__icon"> <i data-lucide="inbox"></i> </div>
            <div class="menu__title"> Event Users </div>
    </a>
</li>

{{--<li>--}}
{{--    <a href="{{ route('admin.messages') }}" class="menu{{ Request::is('user/messages*') ? ' menu--active' : '' }}">--}}
{{--        <div class="menu__icon"> <i data-lucide="inbox"></i> </div>--}}
{{--        <div class="menu__title"> Messages </div>--}}
{{--    </a>--}}

{{--</li>--}}

<li class="nav-item">
    <a href="{{ route('admin.reservations.index') }}" class="menu {{ Request::is('admin.reservations*') ? ' menu--active' : '' }}">
            <div class="menu__icon"> <i data-lucide="inbox"></i> </div>
            <div class="menu__title"> Reservations </div>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('admin.exhibitionTypes.index') }}" class="menu {{ Request::is('admin.exhibitionTypes*') ? ' menu--active' : '' }}">
            <div class="menu__icon"> <i data-lucide="inbox"></i> </div>
            <div class="menu__title"> Exhibition Types </div>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('admin.exhibitions.index') }}" class="menu {{ Request::is('admin.exhibitions*') ? ' menu--active' : '' }}">
            <div class="menu__icon"> <i data-lucide="inbox"></i> </div>
            <div class="menu__title"> Exhibitions </div>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('admin.exhibitionPurchases.index') }}" class="menu {{ Request::is('admin.exhibitionPurchases*') ? ' menu--active' : '' }}">
            <div class="menu__icon"> <i data-lucide="inbox"></i> </div>
            <div class="menu__title"> Exhibition Purchases </div>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('admin.abstracts.index') }}" class="menu {{ Request::is('admin.abstracts*') ? ' menu--active' : '' }}">
            <div class="menu__icon"> <i data-lucide="inbox"></i> </div>
            <div class="menu__title"> Abstracts/Papers </div>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('admin.settings.index') }}" class="menu {{ Request::is('admin/settings*') ? ' menu--active' : '' }}">
        <div class="menu__icon"> <i data-lucide="inbox"></i> </div>
        <div class="menu__title"> Settings </div>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('logout') }}" class="menu">
        <div class="menu__icon"> <i data-lucide="toggle-right"></i> </div>
        <div class="menu__title"> Logout </div>
    </a>

</li>