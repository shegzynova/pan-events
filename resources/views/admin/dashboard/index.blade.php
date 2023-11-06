@extends('admin.layouts.app')

@section('content')

    <div class="content">
        <!-- BEGIN: Top Bar -->
        @include('admin.layouts.topbar', ['title' => 'Dashboard'])
        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-12 xl:col-span-12 2xl:col-span-12 z-10">
                <div class="mt-6 -mb-6 intro-y">
                    <div class="alert alert-dismissible show box bg-primary text-white flex items-center mb-6"
                         role="alert">
                                    <span>
                                        Welcome <strong>{{ sprintf("%s %s", auth()->user()->first_name, auth()->user()->last_name)  }}</strong>, click here to view all Conferences/Events <a
                                                href="{{ route('admin.events.index') }}"
                                                class="underline"><button class="rounded-md bg-white bg-opacity-20 dark:bg-darkmode-300 hover:bg-opacity-30 py-0.5 px-2 -my-3 ml-2">View Conferences/Events</button></a>
                                    </span>
                        <button type="button" class="btn-close text-white" data-tw-dismiss="alert" aria-label="Close"><i
                                    data-lucide="x" class="w-4 h-4"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Top Bar -->
        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-12 2xl:col-span-12">
                <div class="grid grid-cols-12 gap-6">
                    <!-- BEGIN: Registration Summary -->
                    <div class="col-span-12 mt-8">
                        <div class="intro-y flex items-center h-10">
                            <h2 class="text-lg font-medium truncate mr-5">
                                REGISTRATION SUMMARY
                            </h2>
                            <a href="" class="ml-auto flex items-center text-primary"> <i data-lucide="refresh-ccw" class="w-4 h-4 mr-3"></i> Reload Data </a>
                        </div>
                        <div class="grid grid-cols-12 gap-6 mt-5">
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-lucide="shopping-cart" class="report-box__icon text-primary"></i>
                                        </div>
                                        <div class="text-3xl font-medium leading-8 mt-6 text-2xl">{{ $data['registration']['all_registrants'] }}</div>
                                        <div class="text-base text-slate-500 mt-1" style="font-size: 14px !important; ">ALL REGISTRANTS</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-lucide="credit-card" class="report-box__icon text-pending"></i>
                                        </div>
                                        <div class="text-3xl font-medium leading-8 mt-6 text-2xl">{{ $data['registration']['naija_registrants'] }}</div>
                                        <div class="text-base text-slate-500 mt-1">NIGERIAN REGISTRANTS</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-lucide="monitor" class="report-box__icon text-warning"></i>
                                        </div>
                                        <div class="text-3xl font-medium leading-8 mt-6 text-2xl">{{ $data['registration']['foreign_registrant'] }}</div>
                                        <div class="text-base text-slate-500 mt-1">FOREIGN REGISTRANTS</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-lucide="user" class="report-box__icon text-success"></i>
                                        </div>
                                        <div class="text-3xl font-medium leading-8 mt-6 text-2xl">{{ $data['registration']['total_paid'] }}</div>
                                        <div class="text-base text-slate-500 mt-1">TOTAL PAID</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-12 gap-6 mt-10">
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-lucide="user" class="report-box__icon text-success"></i>
                                        </div>
                                        <div class="text-3xl font-medium leading-8 mt-6 text-2xl">{{ $data['registration']['total_unpaid'] }}</div>
                                        <div class="text-base text-slate-500 mt-1">TOTAL UN-PAID</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-lucide="user" class="report-box__icon text-success"></i>
                                        </div>
                                        <div class="text-3xl font-medium leading-8 mt-6 text-2xl">{{ $data['registration']['total_checked_in'] }}</div>
                                        <div class="text-base text-slate-500 mt-1">TOTAL CHECKED-IN</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-lucide="user" class="report-box__icon text-success"></i>
                                        </div>
                                        <div class="text-3xl font-medium leading-8 mt-6 text-2xl">{{ $data['registration']['paid_online'] }}</div>
                                        <div class="text-base text-slate-500 mt-1">PAID ONLINE</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-lucide="user" class="report-box__icon text-success"></i>
                                        </div>
                                        <div class="text-3xl font-medium leading-8 mt-6 text-2xl">{{ $data['registration']['paid_in_bank'] }}</div>
                                        <div class="text-base text-slate-500 mt-1">PAID IN BANK</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END: Registration Summary -->
                    {{-- BEGIN: Financial Summary --}}
                    <div class="col-span-12 mt-8">
                        <div class="intro-y flex items-center h-10">
                            <h2 class="text-lg font-medium truncate mr-5">
                                FINANCIAL SUMMARY
                            </h2>
                            <a href="/" class="ml-auto flex items-center text-primary"> <i data-lucide="refresh-ccw" class="w-4 h-4 mr-3"></i> Reload Data </a>
                        </div>
                        <div class="grid grid-cols-12 gap-6 mt-5">
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-lucide="shopping-cart" class="report-box__icon text-primary"></i>
                                        </div>
                                        <div class="text-3xl font-medium leading-8 mt-6 text-2xl">₦{{ number_format($data['financial']['total_payable']) }}</div>
                                        <div class="text-base text-slate-500 mt-1">TOTAL PAYABLE</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-lucide="credit-card" class="report-box__icon text-pending"></i>
                                        </div>
                                        <div class="text-3xl font-medium leading-8 mt-6 text-2xl">₦{{ number_format($data['financial']['total_reg_fee_payable']) }}</div>
                                        <div class="text-base text-slate-500 mt-1">TOTAL REG FEE PAYABLE</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-lucide="monitor" class="report-box__icon text-warning"></i>
                                        </div>
                                        <div class="text-3xl font-medium leading-8 mt-6 text-2xl">₦{{ number_format($data['financial']['total_hotel_fee_payable']) }}</div>
                                        <div class="text-base text-slate-500 mt-1">TOTAL HOTEL BILLS PAYABLE</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-lucide="user" class="report-box__icon text-success"></i>
                                        </div>
                                        <div class="text-3xl font-medium leading-8 mt-6 text-2xl">₦{{ number_format($data['financial']['total_paid']) }}</div>
                                        <div class="text-base text-slate-500 mt-1">TOTAL PAID</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-12 gap-6 mt-10">
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-lucide="user" class="report-box__icon text-success"></i>
                                        </div>
                                        <div class="text-3xl font-medium leading-8 mt-6 text-2xl">₦{{ number_format($data['financial']['total_paid_for_reg']) }}</div>
                                        <div class="text-base text-slate-500 mt-1">TOTAL PAID FOR REG</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-lucide="user" class="report-box__icon text-success"></i>
                                        </div>
                                        <div class="text-3xl font-medium leading-8 mt-6 text-2xl">₦{{ number_format($data['financial']['total_paid_for_hotel']) }}</div>
                                        <div class="text-base text-slate-500 mt-1">TOTAL PAID FOR HOTEL</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-lucide="user" class="report-box__icon text-success"></i>
                                        </div>
                                        <div class="text-3xl font-medium leading-8 mt-6 text-2xl">₦{{ number_format($data['financial']['total_paid_online']) }}</div>
                                        <div class="text-base text-slate-500 mt-1">TOTAL PAID ONLINE</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-lucide="user" class="report-box__icon text-success"></i>
                                        </div>
                                        <div class="text-3xl font-medium leading-8 mt-6 text-2xl">₦{{ number_format($data['financial']['total_paid_in_bank']) }}</div>
                                        <div class="text-base text-slate-500 mt-1">TOTAL PAID IN BANK</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- END: Financial Summary --}}
                    {{-- BEGIN: Hotel Bookings --}}
                    <div class="col-span-12 mt-8">
                        <div class="intro-y flex items-center h-10">
                            <h2 class="text-lg font-medium truncate mr-5">
                                HOTEL BOOKINGS
                            </h2>
                            <a href="" class="ml-auto flex items-center text-primary"> <i data-lucide="refresh-ccw" class="w-4 h-4 mr-3"></i> Reload Data </a>
                        </div>
                        <div class="grid grid-cols-12 gap-6 mt-5">
                            @foreach( $hotelData AS $hotel )

                                <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                    <div class="report-box zoom-in">
                                        <div class="box p-5">
                                            <div class="text-base text-slate-500 mb-5" style="">{{ $hotel['name'] }}<br>₦{{ number_format($hotel['price']) }}</div>
                                            <div class="flex">
                                                <i data-lucide="shopping-cart" class="report-box__icon text-primary"></i>
                                            </div>
                                            <div class="text-3xl font-medium leading-8 mt-6 text-2xl">Due: ₦{{number_format($hotel['total_unpaid'])}}<br>Paid:₦{{number_format($hotel['total_paid'])}}</div>
                                        </div>
                                    </div>
                                </div>

                            @endforeach
                        </div>
                        </div>
            </div>
        </div>
    </div>

@endsection