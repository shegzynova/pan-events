@extends('admin.layouts.app')

@section('content')

    <div class="content">
        <!-- BEGIN: Top Bar -->
        @include('admin.layouts.topbar', ['title' => 'Hotels'])
        <!-- END: Top Bar -->
        <h2 class="intro-y text-lg font-medium mt-10">
            All Hotels
        </h2>
        @if( !is_null( $errors->all() ) )
            @foreach($errors->all() as $error)
                <div class="alert alert-danger show flex items-center mb-2" role="alert"><i data-lucide="alert-triangle"
                                                                                            class="w-6 h-6 mr-2"></i>
                    {{ $error }}
                </div>
            @endforeach
        @endif
        @if(session('success'))
            <div class="alert alert-success alert-dismissible show flex items-center mb-2" role="alert"><i
                        data-lucide="alert-triangle" class="w-6 h-6 mr-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-tw-dismiss="alert" aria-label="Close"><i data-lucide="x"
                                                                                                      class="w-4 h-4"></i>
                </button>
            </div>
        @endif

        <div class="grid grid-cols-12 gap-6 mt-5">
            <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
                <a href="{{ route('admin.hotels.create') }}" class="btn btn-primary shadow-md mr-2">Add New Hotel</a>
                <div class="dropdown">
                    <button class="dropdown-toggle btn px-2 box" aria-expanded="false" data-tw-toggle="dropdown">
                        <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4"
                                                                                   data-lucide="plus"></i> </span>
                    </button>
                    @include('admin.layouts.export', ['type' => 'hotels'])
                </div>
                {{--                <div class="hidden md:block mx-auto text-slate-500">Showing 1 to 10 of 150 entries</div>--}}
                {{--                <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">--}}
                {{--                    <div class="w-56 relative text-slate-500">--}}
                {{--                        <input type="text" class="form-control w-56 box pr-10" placeholder="Search...">--}}
                {{--                        <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-lucide="search"></i>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
            </div>
            <!-- BEGIN: Data List -->
            <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                @include('flash::message')

                <div class="clearfix"></div>

                <div class="card">
                    @include('admin.hotels.table')
                </div>
            </div>
            <!-- END: Data List -->
            <!-- BEGIN: Pagination -->
            {{--            <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center">--}}
            {{--                <nav class="w-full sm:w-auto sm:mr-auto">--}}
            {{--                    <ul class="pagination">--}}
            {{--                        <li class="page-item">--}}
            {{--                            <a class="page-link" href="#"> <i class="w-4 h-4" data-lucide="chevrons-left"></i> </a>--}}
            {{--                        </li>--}}
            {{--                        <li class="page-item">--}}
            {{--                            <a class="page-link" href="#"> <i class="w-4 h-4" data-lucide="chevron-left"></i> </a>--}}
            {{--                        </li>--}}
            {{--                        <li class="page-item"><a class="page-link" href="#">...</a></li>--}}
            {{--                        <li class="page-item"><a class="page-link" href="#">1</a></li>--}}
            {{--                        <li class="page-item active"><a class="page-link" href="#">2</a></li>--}}
            {{--                        <li class="page-item"><a class="page-link" href="#">3</a></li>--}}
            {{--                        <li class="page-item"><a class="page-link" href="#">...</a></li>--}}
            {{--                        <li class="page-item">--}}
            {{--                            <a class="page-link" href="#"> <i class="w-4 h-4" data-lucide="chevron-right"></i> </a>--}}
            {{--                        </li>--}}
            {{--                        <li class="page-item">--}}
            {{--                            <a class="page-link" href="#"> <i class="w-4 h-4" data-lucide="chevrons-right"></i> </a>--}}
            {{--                        </li>--}}
            {{--                    </ul>--}}
            {{--                </nav>--}}
            {{--                <select class="w-20 form-select box mt-3 sm:mt-0">--}}
            {{--                    <option>10</option>--}}
            {{--                    <option>25</option>--}}
            {{--                    <option>35</option>--}}
            {{--                    <option>50</option>--}}
            {{--                </select>--}}
            {{--            </div>--}}
            <!-- END: Pagination -->
        </div>
        <!-- BEGIN: Delete Confirmation Modal -->
        <div id="delete-confirmation-modal" class="modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="p-5 text-center">
                            <i data-lucide="x-circle" class="w-16 h-16 text-danger mx-auto mt-3"></i>
                            <div class="text-3xl mt-5">Are you sure?</div>
                            <div class="text-slate-500 mt-2">
                                Do you really want to delete these records?
                                <br>
                                This process cannot be undone.
                            </div>
                        </div>
                        <div class="px-5 pb-8 text-center">
                            <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">
                                Cancel
                            </button>
                            <button type="button" class="btn btn-danger w-24">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Delete Confirmation Modal -->
    </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#post-form-5').on('change', function() {
                if ($(this).prop('checked')) {
                    console.log('Checkbox is checked');
                } else {
                    console.log('Checkbox is not checked');
                }
            });
        });



        {{--function updateEventStatus() {--}}
        {{--        var isPublished = $('#post-form-5').prop('checked');--}}
        {{--        console.log(isPublished)--}}
        {{--        var eventId = {{ $event->id }};--}}

        {{--        $.ajax({--}}
        {{--            url: '/events/' + eventId + '/publish',--}}
        {{--            type: 'PUT',--}}
        {{--            data: {--}}
        {{--                is_published: isPublished--}}
        {{--            },--}}
        {{--            success: function(response) {--}}
        {{--                Swal.Toast.fire({--}}
        {{--                    icon: 'success',--}}
        {{--                    title: 'Success'--}}
        {{--                })--}}
        {{--            },--}}
        {{--            error: function(xhr, status, error) {--}}
        {{--                Toast.fire({--}}
        {{--                    icon: 'error',--}}
        {{--                    title: 'Error'--}}
        {{--                })--}}
        {{--            }--}}
        {{--        });--}}
        {{--    }--}}
    </script>
@endsection