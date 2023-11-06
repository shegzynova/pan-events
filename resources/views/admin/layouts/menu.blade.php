<li>
    <a href="{{ route('admin.dashboard') }}" class="side-menu{{ Request::is('admin/dashboard') ? ' side-menu--active' : '' }}">
        <div class="side-menu__icon"> <i data-lucide="home"></i> </div>
        <div class="side-menu__title"> Dashboard </div>
    </a>
</li>

<li>
    <a href="{{ route('admin.events.index') }}" class="side-menu{{ Request::is('admin/events*') ? ' side-menu--active' : '' }}">
        <div class="side-menu__icon"> <i data-lucide="calendar"></i> </div>
        <div class="side-menu__title"> Conferences/Events </div>
    </a>

</li>

<li class="nav-item">
    <a href="{{ route('admin.hotels.index') }}" class="side-menu {{ Request::is('admin/hotels*') ? ' side-menu--active' : '' }}">
        <div class="side-menu__icon"> <i data-lucide="home"></i> </div>
        <div class="side-menu__title"> Hotels </div>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('admin.transactions.index') }}" class="side-menu {{ Request::is('admin/transactions*') ? ' side-menu--active' : '' }}">
        <div class="side-menu__icon"> <i data-lucide="shopping-bag"></i> </div>
        <div class="side-menu__title"> Transactions </div>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('admin.users.index') }}" class="side-menu {{ Request::is('admin/users*') ? ' side-menu--active' : '' }}">
            <div class="side-menu__icon"> <i data-lucide="users"></i> </div>
            <div class="side-menu__title"> Users </div>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('admin.eventUsers.index') }}" class="side-menu {{ Request::is('admin/event-users*') ? ' side-menu--active' : '' }}">
            <div class="side-menu__icon"> <i data-lucide="inbox"></i> </div>
            <div class="side-menu__title"> Event Users </div>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('admin.reservations.index') }}" class="side-menu {{ Request::is('admin/reservations*') ? ' side-menu--active' : '' }}">
            <div class="side-menu__icon"> <i data-lucide="aperture"></i> </div>
            <div class="side-menu__title"> Reservations </div>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('admin.exhibitionTypes.index') }}" class="side-menu {{ Request::is('admin/exhibition-types*') ? ' side-menu--active' : '' }}">
            <div class="side-menu__icon"> <i data-lucide="inbox"></i> </div>
            <div class="side-menu__title"> Exhibition Types </div>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('admin.exhibitions.index') }}" class="side-menu {{ Request::is('admin/exhibitions*') ? ' side-menu--active' : '' }}">
            <div class="side-menu__icon"> <i data-lucide="inbox"></i> </div>
            <div class="side-menu__title"> Exhibitions </div>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('admin.exhibitionPurchases.index') }}" class="side-menu {{ Request::is('admin/exhibition-purchases*') ? ' side-menu--active' : '' }}">
            <div class="side-menu__icon"> <i data-lucide="inbox"></i> </div>
            <div class="side-menu__title"> Exhibition Purchases </div>
    </a>
</li>

{{--<li class="nav-item">--}}
{{--    <a href="{{ route('admin.messages') }}" class="side-menu {{ Request::is('admin/messages*') ? ' side-menu--active' : '' }}">--}}
{{--            <div class="side-menu__icon"> <i data-lucide="book"></i> </div>--}}
{{--            <div class="side-menu__title"> Messages </div>--}}
{{--    </a>--}}
{{--</li>--}}

<li class="nav-item">
    <a href="{{ route('admin.abstracts.index') }}" class="side-menu {{ Request::is('admin/abstracts*') ? ' side-menu--active' : '' }}">
        <div class="side-menu__icon"> <i data-lucide="book"></i> </div>
        <div class="side-menu__title"> Abstracts/Papers </div>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('admin.notifications.index') }}" class="side-menu {{ Request::is('admin/notifications*') ? ' side-menu--active' : '' }}">
        <div class="side-menu__icon"> <i data-lucide="bell"></i> </div>
        <div class="side-menu__title"> Notifications </div>
    </a>
</li>

<li>
    <a href="javascript:;" class="side-menu {{ Request::is('admin/settings*') ? ' side-menu--active' : '' }}">
        <div class="side-menu__icon"> <i data-lucide="settings"></i> </div>
        <div class="side-menu__title">
            Settings
            <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
        </div>
    </a>
    <ul class="">
        <li>
            <a href="{{ route('admin.settings.index') }}" class="side-menu {{ Request::is('admin/settings*') ? ' side-menu--active' : '' }}">
                <div class="side-menu__icon"> <i data-lucide="settings"></i> </div>
                <div class="side-menu__title"> Settings </div>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.settings.roles') }}" class="side-menu {{ Request::is('admin/settings/roles*') ? ' side-menu--active' : '' }}">
                <div class="side-menu__icon"> <i data-lucide="shield"></i> </div>
                <div class="side-menu__title"> Roles </div>
            </a>
        </li>
    </ul>
</li>

<li class="nav-item">
    <a href="{{ route('logout') }}" class="side-menu">
        <div class="side-menu__icon"> <i data-lucide="toggle-right"></i> </div>
        <div class="side-menu__title"> Logout </div>
    </a>

</li>