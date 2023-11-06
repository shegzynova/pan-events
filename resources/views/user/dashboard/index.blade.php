@extends('user.layouts.app')

@section('content')

    <div class="content">
        <!-- BEGIN: Top Bar -->
        @include('user.layouts.topbar', ['title' => 'Dashboard'])
        <!-- END: Top Bar -->
        <div class="intro-x mt-8">
            @if( !is_null( $errors->all() ) )
                @foreach($errors->all() as $error)
                    <div class="alert alert-danger show flex items-center mb-2" role="alert"><i
                                data-lucide="alert-triangle"
                                class="w-6 h-6 mr-2"></i>
                        {{ $error }} </div>
                @endforeach
            @endif
        </div>

        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-12 xl:col-span-12 2xl:col-span-12 z-10">

                <div class="mt-6 -mb-6 intro-y">
                    <div class="alert alert-dismissible show box bg-primary text-white flex items-center mb-6"
                         role="alert">
                                    <span>
                                        Welcome <strong>{{ sprintf("%s %s", auth()->user()->first_name, auth()->user()->last_name)  }}</strong>, click here to view all Conferences/Events <a
                                                href="{{ route('user.events.index') }}"
                                                class="underline"><button
                                                    class="rounded-md bg-white bg-opacity-20 dark:bg-darkmode-300 hover:bg-opacity-30 py-0.5 px-2 -my-3 ml-2">View Conferences/Events</button></a>
                                    </span>
                        <button type="button" class="btn-close text-white" data-tw-dismiss="alert" aria-label="Close"><i
                                    data-lucide="x" class="w-4 h-4"></i></button>
                    </div>
                </div>

                @if (session('status') == 'verification-link-sent')
                    <div class="intro-y mt-8">
                        <div class="alert alert-dismissible show box bg-success text-white flex items-center mb-6"
                             role="alert">
                             <span class="flex items-center">
                                 <i data-lucide="alert-circle" class="w-6 h-6 mr-2"></i> {{ __('A new verification link has been sent to your email, Please check your email and click the verification link.') }}</span>
                        </div>
                    </div>
                @else
                    @unless(auth()->user()->hasVerifiedEmail())
                        <div class="intro-y mt-8">
                            <div class="alert alert-dismissible show box bg-warning flex items-center mb-6"
                                 role="alert">
                                <form method="POST" action="{{ route('verification.send') }}">
                                    @csrf
                                    <span class="flex items-center"><i data-lucide="alert-triangle"></i>
                        Your email address is not verified. Please check your email and click the verification link.
                        <button class="underline ml-2">RESEND EMAIL VERIFICATION LINK</button>
                    </span>
                                </form>
                                <button type="button" class="btn-close text-primary" data-tw-dismiss="alert"
                                        aria-label="Close">
                                    <i data-lucide="x" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </div>
                    @endunless
                @endif
            </div>
        </div>
        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-12 2xl:col-span-12">
                <div class="grid grid-cols-12 gap-6">
                    <!-- BEGIN: General Report -->
                    <div class="col-span-12 mt-8">
                        <div class="intro-y flex items-center h-10">
                            <h2 class="text-lg font-medium truncate mr-5">
                                General Report
                            </h2>
                            <a href="" class="ml-auto flex items-center text-primary"> <i data-lucide="refresh-ccw"
                                                                                          class="w-4 h-4 mr-3"></i>
                                Reload Data </a>
                        </div>
                        <div class="grid grid-cols-12 gap-6 mt-5">
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-lucide="shopping-cart" class="report-box__icon text-primary"></i>
                                            <div class="ml-auto">
                                                {{--                                                <div class="report-box__indicator bg-success tooltip cursor-pointer" title="33% Higher than last month"> 33% <i data-lucide="chevron-up" class="w-4 h-4 ml-0.5"></i> </div>--}}
                                            </div>
                                        </div>
                                        <div class="text-3xl font-medium leading-8 mt-6">
                                            ₦{{ number_format($data['total_payable']) }}</div>
                                        <div class="text-base text-slate-500 mt-1">Total Payable</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-lucide="credit-card" class="report-box__icon text-pending"></i>
                                            <div class="ml-auto">
                                                {{--                                                <div class="report-box__indicator bg-danger tooltip cursor-pointer" title="2% Lower than last month"> 2% <i data-lucide="chevron-down" class="w-4 h-4 ml-0.5"></i> </div>--}}
                                            </div>
                                        </div>
                                        <div class="text-3xl font-medium leading-8 mt-6">
                                            ₦{{ number_format($data['total_event_payable']) }}</div>
                                        <div class="text-base text-slate-500 mt-1">Total Event Payable</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-lucide="monitor" class="report-box__icon text-warning"></i>
                                            <div class="ml-auto">
                                                {{--                                                <div class="report-box__indicator bg-success tooltip cursor-pointer" title="12% Higher than last month"> 12% <i data-lucide="chevron-up" class="w-4 h-4 ml-0.5"></i> </div>--}}
                                            </div>
                                        </div>
                                        <div class="text-3xl font-medium leading-8 mt-6">
                                            ₦{{ number_format($data['total_hotel_payable']) }}</div>
                                        <div class="text-base text-slate-500 mt-1">Total Hotel Payable</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-lucide="user" class="report-box__icon text-success"></i>
                                            <div class="ml-auto">
                                                {{--                                                <div class="report-box__indicator bg-success tooltip cursor-pointer" title="22% Higher than last month"> 22% <i data-lucide="chevron-up" class="w-4 h-4 ml-0.5"></i> </div>--}}
                                            </div>
                                        </div>
                                        <div class="text-3xl font-medium leading-8 mt-6">
                                            ₦{{ number_format($data['total_paid']) }}</div>
                                        <div class="text-base text-slate-500 mt-1">Total Paid</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-lucide="user" class="report-box__icon text-success"></i>
                                            <div class="ml-auto">
                                                {{--                                                <div class="report-box__indicator bg-success tooltip cursor-pointer" title="22% Higher than last month"> 22% <i data-lucide="chevron-up" class="w-4 h-4 ml-0.5"></i> </div>--}}
                                            </div>
                                        </div>
                                        <div class="text-3xl font-medium leading-8 mt-6">
                                            ₦{{ number_format($data['total_event_paid']) }}</div>
                                        <div class="text-base text-slate-500 mt-1">Total Event Paid</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-lucide="user" class="report-box__icon text-success"></i>
                                            <div class="ml-auto">
                                                {{--                                                <div class="report-box__indicator bg-success tooltip cursor-pointer" title="22% Higher than last month"> 22% <i data-lucide="chevron-up" class="w-4 h-4 ml-0.5"></i> </div>--}}
                                            </div>
                                        </div>
                                        <div class="text-3xl font-medium leading-8 mt-6">
                                            ₦{{ number_format($data['total_hotel_paid']) }}</div>
                                        <div class="text-base text-slate-500 mt-1">Total Hotel Paid</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END: General Report -->
                </div>
            </div>
        </div>
    </div>

@endsection