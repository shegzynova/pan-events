@php
    $userId = auth()->id();

    $notifications_ = \App\Models\Notification::where(function($query) use ($userId) {
        $query->whereNull('for')
        ->orWhereJsonContains('for', (string) $userId);
    })->latest()->get();
@endphp

<style>
    .notification-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .notification-title {
        flex: 1;
        max-width: 75%; /* Adjust this value as needed */
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .notification-body {
        flex: 1;
        max-width: 100%; /* Adjust this value as needed */
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
<div class="top-bar -mx-4 px-4 md:mx-0 md:px-0">
    <!-- BEGIN: Breadcrumb -->
    <nav aria-label="breadcrumb" class="-intro-x mr-auto hidden sm:flex">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Application</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$title}}</li>
        </ol>
    </nav>
    <!-- END: Breadcrumb -->
    <!-- BEGIN: Search -->
    <div class="intro-x relative mr-3 sm:mr-6">
        <div class="search hidden sm:block">
            <input type="text" class="search__input form-control border-transparent" placeholder="Search...">
            <i data-lucide="search" class="search__icon dark:text-slate-500"></i>
        </div>
        <a class="notification sm:hidden" href=""> <i data-lucide="search" class="notification__icon dark:text-slate-500"></i> </a>
{{--        <div class="search-result">--}}
{{--            <div class="search-result__content">--}}
{{--                <div class="search-result__content__title">Pages</div>--}}
{{--                <div class="mb-5">--}}
{{--                    <a href="" class="flex items-center">--}}
{{--                        <div class="w-8 h-8 bg-success/20 dark:bg-success/10 text-success flex items-center justify-center rounded-full"> <i class="w-4 h-4" data-lucide="inbox"></i> </div>--}}
{{--                        <div class="ml-3">Mail Settings</div>--}}
{{--                    </a>--}}
{{--                    <a href="" class="flex items-center mt-2">--}}
{{--                        <div class="w-8 h-8 bg-pending/10 text-pending flex items-center justify-center rounded-full"> <i class="w-4 h-4" data-lucide="users"></i> </div>--}}
{{--                        <div class="ml-3">Users & Permissions</div>--}}
{{--                    </a>--}}
{{--                    <a href="" class="flex items-center mt-2">--}}
{{--                        <div class="w-8 h-8 bg-primary/10 dark:bg-primary/20 text-primary/80 flex items-center justify-center rounded-full"> <i class="w-4 h-4" data-lucide="credit-card"></i> </div>--}}
{{--                        <div class="ml-3">Transactions Report</div>--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--                <div class="search-result__content__title">Users</div>--}}
{{--                <div class="mb-5">--}}
{{--                    <a href="" class="flex items-center mt-2">--}}
{{--                        <div class="w-8 h-8 image-fit">--}}
{{--                            <img alt="Midone - HTML Admin Template" class="rounded-full" src="dist/images/profile-5.jpg">--}}
{{--                        </div>--}}
{{--                        <div class="ml-3">Johnny Depp</div>--}}
{{--                        <div class="ml-auto w-48 truncate text-slate-500 text-xs text-right">johnnydepp@left4code.com</div>--}}
{{--                    </a>--}}
{{--                    <a href="" class="flex items-center mt-2">--}}
{{--                        <div class="w-8 h-8 image-fit">--}}
{{--                            <img alt="Midone - HTML Admin Template" class="rounded-full" src="dist/images/profile-10.jpg">--}}
{{--                        </div>--}}
{{--                        <div class="ml-3">Keanu Reeves</div>--}}
{{--                        <div class="ml-auto w-48 truncate text-slate-500 text-xs text-right">keanureeves@left4code.com</div>--}}
{{--                    </a>--}}
{{--                    <a href="" class="flex items-center mt-2">--}}
{{--                        <div class="w-8 h-8 image-fit">--}}
{{--                            <img alt="Midone - HTML Admin Template" class="rounded-full" src="dist/images/profile-2.jpg">--}}
{{--                        </div>--}}
{{--                        <div class="ml-3">John Travolta</div>--}}
{{--                        <div class="ml-auto w-48 truncate text-slate-500 text-xs text-right">johntravolta@left4code.com</div>--}}
{{--                    </a>--}}
{{--                    <a href="" class="flex items-center mt-2">--}}
{{--                        <div class="w-8 h-8 image-fit">--}}
{{--                            <img alt="Midone - HTML Admin Template" class="rounded-full" src="dist/images/profile-11.jpg">--}}
{{--                        </div>--}}
{{--                        <div class="ml-3">Robert De Niro</div>--}}
{{--                        <div class="ml-auto w-48 truncate text-slate-500 text-xs text-right">robertdeniro@left4code.com</div>--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--                <div class="search-result__content__title">Products</div>--}}
{{--                <a href="" class="flex items-center mt-2">--}}
{{--                    <div class="w-8 h-8 image-fit">--}}
{{--                        <img alt="Midone - HTML Admin Template" class="rounded-full" src="dist/images/preview-5.jpg">--}}
{{--                    </div>--}}
{{--                    <div class="ml-3">Samsung Galaxy S20 Ultra</div>--}}
{{--                    <div class="ml-auto w-48 truncate text-slate-500 text-xs text-right">Smartphone &amp; Tablet</div>--}}
{{--                </a>--}}
{{--                <a href="" class="flex items-center mt-2">--}}
{{--                    <div class="w-8 h-8 image-fit">--}}
{{--                        <img alt="Midone - HTML Admin Template" class="rounded-full" src="dist/images/preview-1.jpg">--}}
{{--                    </div>--}}
{{--                    <div class="ml-3">Nike Air Max 270</div>--}}
{{--                    <div class="ml-auto w-48 truncate text-slate-500 text-xs text-right">Sport &amp; Outdoor</div>--}}
{{--                </a>--}}
{{--                <a href="" class="flex items-center mt-2">--}}
{{--                    <div class="w-8 h-8 image-fit">--}}
{{--                        <img alt="Midone - HTML Admin Template" class="rounded-full" src="dist/images/preview-7.jpg">--}}
{{--                    </div>--}}
{{--                    <div class="ml-3">Nike Tanjun</div>--}}
{{--                    <div class="ml-auto w-48 truncate text-slate-500 text-xs text-right">Sport &amp; Outdoor</div>--}}
{{--                </a>--}}
{{--                <a href="" class="flex items-center mt-2">--}}
{{--                    <div class="w-8 h-8 image-fit">--}}
{{--                        <img alt="Midone - HTML Admin Template" class="rounded-full" src="dist/images/preview-1.jpg">--}}
{{--                    </div>--}}
{{--                    <div class="ml-3">Samsung Galaxy S20 Ultra</div>--}}
{{--                    <div class="ml-auto w-48 truncate text-slate-500 text-xs text-right">Smartphone &amp; Tablet</div>--}}
{{--                </a>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>
    <!-- END: Search -->
    <!-- BEGIN: Notifications -->
    <div class="intro-x dropdown mr-auto sm:mr-6">
        <div class="dropdown-toggle notification notification--bullet cursor-pointer" role="button"
             aria-expanded="false" data-tw-toggle="dropdown"><i data-lucide="bell"
                                                                class="notification__icon dark:text-slate-500"></i>
        </div>
        <div class="notification-content pt-2 dropdown-menu">
            <div class="notification-content__box dropdown-content">
                <div class="notification-content__title">Notifications</div>

                @forelse($notifications_ AS $notification)
                    @php
                        $if_seen = false;
                        $seen = json_decode($notification->seen);
                        if(!is_null($seen)){
                            $if_seen = in_array(auth()->id(), $seen);
                        }
                    @endphp
                    <div @if($if_seen)style="opacity: 0.5"@endif class="cursor-pointer relative items-center mt-5" data-tw-toggle="modal" data-tw-target="#medium-modal-size-preview-{{$notification->id}}" onclick="logSeen({{ $notification->id }})">
                        <div class="ml-2 overflow-hidden">
                            <div class="notification-container">
                                <a class="font-medium truncate mr-5 notification-title">{{ $notification->title }}</a>
                                <div class="text-xs text-slate-400 ml-auto whitespace-nowrap ">{{ $notification->created_at->diffForHumans() }}</div>
                            </div>
                            <div class="w-full truncate text-slate-500 mt-0.5 notification-body">{!! $notification->body !!}</div>
                            <div></div>
                        </div>
                    </div>
                    <div id="medium-modal-size-preview-{{$notification->id}}" class="modal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content p-3">
                                <div class="flex items-center">
                                    <a class="font-medium mr-5">{{ $notification->title }}</a>
                                    <div class="text-xs text-slate-400 ml-auto whitespace-nowrap">{{ $notification->created_at->diffForHumans() }}</div>
                                </div>
                                <section class="mt-5">
                                    Message:
                                    <br>
                                    <div class="w-full text-slate-500" style="text-align: justify;">
                                        {!! $notification->body !!}
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                @empty
                    <i style="opacity: 0.7">No Notification Yet!!</i>
                @endforelse

                <!-- Modal -->
                <div id="myModal" class="modal">
                    <div class="modal-content">
                        <span class="close" id="closeModal">&times;</span>
                        <!-- Modal content goes here -->
                        <h2>Nicolas Cage</h2>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500.</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- BEGIN: Account Menu -->
    <div class="intro-x dropdown w-8 h-8">
        <div class="dropdown-toggle w-8 h-8 rounded-full overflow-hidden shadow-lg image-fit zoom-in" role="button" aria-expanded="false" data-tw-toggle="dropdown">
            <img alt="Avatar" src="{{asset('dist/images/logo.svg')}}">
        </div>
        <div class="dropdown-menu w-56">
            <ul class="dropdown-content bg-primary text-white">
                <li class="p-2">
                    <div class="font-medium">{{ auth()->user()->first_name . ' ' .auth()->user()->last_name  }}</div>
                    <div class="text-xs text-white/70 mt-0.5 dark:text-slate-500">User</div>
                </li>
                <li>
                    <hr class="dropdown-divider border-white/[0.08]">
                </li>
{{--                <li>--}}
{{--                    <a href="" class="dropdown-item hover:bg-white/5"> <i data-lucide="user" class="w-4 h-4 mr-2"></i> Profile </a>--}}
{{--                </li>--}}
{{--                <li>--}}
{{--                    <a href="" class="dropdown-item hover:bg-white/5"> <i data-lucide="lock" class="w-4 h-4 mr-2"></i> Reset Password </a>--}}
{{--                </li>--}}
                <li>
                    <hr class="dropdown-divider border-white/[0.08]">
                </li>
                <li>
                    <a href="{{ route('logout') }}" class="dropdown-item hover:bg-white/5"> <i data-lucide="toggle-right" class="w-4 h-4 mr-2"></i> Logout </a>
                </li>
            </ul>
        </div>
    </div>
    <!-- END: Account Menu -->
</div>