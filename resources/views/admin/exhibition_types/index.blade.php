@extends('admin.layouts.app')

@section('content')

    <div class="content">
        <!-- BEGIN: Top Bar -->
        @include('admin.layouts.topbar', ['title' => 'Exhibition Types' ])
        <!-- END: Top Bar -->
        <h2 class="intro-y text-lg font-medium mt-10">
            All Exhibition Types
        </h2>
        @if(session('success'))
            <div class="alert alert-success alert-dismissible show flex items-center mb-2" role="alert"><i
                        data-lucide="alert-triangle" class="w-6 h-6 mr-2"></i>
                <button type="button" class="btn-close" data-tw-dismiss="alert" aria-label="Close"><i data-lucide="x"
                                                                                                      class="w-4 h-4"></i>
                </button>
            </div>
        @endif

        <div class="grid grid-cols-12 gap-6 mt-5">
            <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
                <a href="{{ route('admin.exhibitionTypes.create') }}" class="btn btn-primary shadow-md mr-2">Add New
                    Exhibition Types</a>
{{--                <div class="dropdown">--}}
{{--                    <button class="dropdown-toggle btn px-2 box" aria-expanded="false" data-tw-toggle="dropdown">--}}
{{--                        <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4"--}}
{{--                                                                                   data-lucide="plus"></i> </span>--}}
{{--                    </button>--}}
{{--                    <div class="dropdown-menu w-40">--}}
{{--                        <ul class="dropdown-content">--}}
{{--                            <li>--}}
{{--                                <a href="" class="dropdown-item"> <i data-lucide="printer" class="w-4 h-4 mr-2"></i>--}}
{{--                                    Print </a>--}}
{{--                            </li>--}}
{{--                            <li>--}}
{{--                                <a href="" class="dropdown-item"> <i data-lucide="file-text" class="w-4 h-4 mr-2"></i>--}}
{{--                                    Export to Excel </a>--}}
{{--                            </li>--}}
{{--                            <li>--}}
{{--                                <a href="" class="dropdown-item"> <i data-lucide="file-text" class="w-4 h-4 mr-2"></i>--}}
{{--                                    Export to PDF </a>--}}
{{--                            </li>--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>
            <!-- BEGIN: Data List -->
            <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                @include('flash::message')

                <div class="clearfix"></div>

                <div class="card">
                    @include('admin.exhibition_types.table')
                </div>
            </div>
        </div>
        <!-- END: Delete Confirmation Modal -->
    </div>

@endsection
