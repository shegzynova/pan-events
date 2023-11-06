@extends('admin.layouts.app')

@section('content')

<div class="content">
    <!-- END: Top Bar -->
    @include('admin.layouts.topbar', ['title' => 'Messages' ])
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Chat
        </h2>
{{--        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">--}}
{{--            <button class="btn btn-primary shadow-md mr-2">Start New Chat</button>--}}
{{--            <div class="dropdown ml-auto sm:ml-0">--}}
{{--                <button class="dropdown-toggle btn px-2 box text-slate-500" aria-expanded="false" data-tw-toggle="dropdown">--}}
{{--                    <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-lucide="plus"></i> </span>--}}
{{--                </button>--}}
{{--                <div class="dropdown-menu w-40">--}}
{{--                    <ul class="dropdown-content">--}}
{{--                        <li>--}}
{{--                            <a href="" class="dropdown-item"> <i data-lucide="users" class="w-4 h-4 mr-2"></i> Create Group </a>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <a href="" class="dropdown-item"> <i data-lucide="settings" class="w-4 h-4 mr-2"></i> Settings </a>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>
    <div class="intro-y chat grid grid-cols-12 gap-5 mt-5">
        <!-- BEGIN: Chat Side Menu -->
        <div class="col-span-12 lg:col-span-4 2xl:col-span-3">
{{--            <div class="intro-y pr-1">--}}
{{--                <div class="box p-2">--}}
{{--                    <ul class="nav nav-pills" role="tablist">--}}
{{--                        <li id="chats-tab" class="nav-item flex-1" role="presentation">--}}
{{--                            <button class="nav-link w-full py-2 active" data-tw-toggle="pill" data-tw-target="#chats" type="button" role="tab" aria-controls="chats" aria-selected="true" > Chats </button>--}}
{{--                        </li>--}}
{{--                        <li id="friends-tab" class="nav-item flex-1" role="presentation">--}}
{{--                            <button class="nav-link w-full py-2" data-tw-toggle="pill" data-tw-target="#friends" type="button" role="tab" aria-controls="friends" aria-selected="false" > Friends </button>--}}
{{--                        </li>--}}
{{--                        <li id="profile-tab" class="nav-item flex-1" role="presentation">--}}
{{--                            <button class="nav-link w-full py-2" data-tw-toggle="pill" data-tw-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false" > Profile </button>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </div>--}}
            <div class="tab-content">
                <div id="chats" class="tab-pane active" role="tabpanel" aria-labelledby="chats-tab">
                    <div class="chat__chat-list overflow-y-auto scrollbar-hidden pr-1 pt-1 mt-4">
                        @foreach($messages as $message)
                            <div class="intro-x cursor-pointer box relative flex items-center p-5 mt-5">
                                <div class="w-12 h-12 flex-none image-fit mr-1">
                                    <img alt="Midone - HTML Admin Template" class="rounded-full" src="{{ asset('dist/images/profile-8.jpg') }}">
                                    <div class="w-3 h-3 bg-success absolute right-0 bottom-0 rounded-full border-2 border-white dark:border-darkmode-600"></div>
                                </div>
                                <div class="ml-2 overflow-hidden">
                                    <div class="flex items-center">
                                        <a href="javascript:;" class="font-medium">{{ $message->recipient->full_name }}</a>
                                        <div class="text-xs text-slate-400 ml-auto">01:10 PM</div>
                                    </div>
                                    <div class="w-full truncate text-slate-500 mt-0.5">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem </div>
                                </div>
                                <div class="w-5 h-5 flex items-center justify-center absolute top-0 right-0 text-xs text-white rounded-full bg-primary font-medium -mt-1 -mr-1">3</div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
        <!-- END: Chat Side Menu -->
        <!-- BEGIN: Chat Content -->
        <div class="intro-y col-span-12 lg:col-span-8 2xl:col-span-9">
            <div class="chat__box box">
                <div class="h-full flex items-center">
                    <div class="mx-auto text-center">
                        <div class="w-16 h-16 flex-none image-fit rounded-full overflow-hidden mx-auto">
                            <img alt="Midone - HTML Admin Template" src="{{asset('dist/images/logo.svg')}}">
                        </div>
                        <div class="mt-3">
                            <div class="font-medium">Hey, {{ auth()->user()->full_name }}</div>
                            <div class="text-slate-500 mt-1">Please select a chat to start messaging.</div>
                        </div>
                    </div>
                </div>
                <!-- END: Chat Default -->
            </div>
        </div>
        <!-- END: Chat Content -->
    </div>
</div>

@endsection

@section('scripts')

@endsection