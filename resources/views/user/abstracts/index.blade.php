@extends('user.layouts.app')

@section('content')

    <div class="content">
        <!-- BEGIN: Top Bar -->
        @include('user.layouts.topbar', ['title' => 'Abstracts' ])
        <!-- END: Top Bar -->
        <h2 class="intro-y text-lg font-medium mt-10">
            All Abstracts
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

            <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                @include('flash::message')

                <div class="clearfix"></div>

                <div class="card">
                    @include('user.abstracts.table')
                </div>
            </div>
        </div>
        <!-- END: Delete Confirmation Modal -->
    </div>

@endsection
