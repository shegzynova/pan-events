@extends('admin.layouts.app')

@section('content')

    <div class="content">
        <!-- BEGIN: Top Bar -->
        @include('admin.layouts.topbar', ['title' => 'Conferences/Events'])
        <!-- END: Top Bar -->
        <h2 class="intro-y text-lg font-medium mt-10">
            All Conferences/Events
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
                <a href="{{ route('admin.events.create') }}" class="btn btn-primary shadow-md mr-2">Add New Event</a>
                <div class="dropdown">
                    <button class="dropdown-toggle btn px-2 box" aria-expanded="false" data-tw-toggle="dropdown">
                        <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4"
                                                                                   data-lucide="plus"></i> </span>
                    </button>
                    @include('admin.layouts.export', ['type' => 'events'])
                </div>
            </div>
            <!-- BEGIN: Data List -->
            <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                <table class="table table-report -mt-2">
                    <thead>
                    <tr>
                        <th class="whitespace-nowrap">S/N</th>
                        <th class="whitespace-nowrap">Category</th>
                        <th class="whitespace-nowrap">Title</th>
                        <th class="whitespace-nowrap">Published</th>
                        <th class="whitespace-nowrap">Date</th>
                        <th class="whitespace-nowrap">Actions</th>
                    </tr>
                    </thead>
                    <tbody>

                    @forelse($events as $index => $event)
                        <tr>
                            <td> {{ $index + 1 }} </td>
                            <td> {{ $event->category == 'c' ? 'Conference' : 'Webinar' }} </td>
                            <td> {{ $event->title }} </td>
                            <td>
                                <div class="form-check form-switch flex flex-col items-start mt-4">
                                    <input name="is_published" id="post-form-5" class="form-check-input" type="checkbox"
                                           {{ $event->is_published ? 'checked' : '' }}>
                                </div>
                            </td>
                            <td> {{ date('d M, Y', strtotime($event->date)) }} </td>
                            <td>
                                <a href="{{ route('admin.events.edit', $event->id) }}" class="btn btn-info shadow-md mr-2">Edit</a>
                                <a href="{{ route('admin.events.destroy', $event->id) }}"
                                   class="btn btn-danger shadow-md mr-2"
                                   onclick="event.preventDefault(); if (confirm('Are you sure you want to delete this event?')) { document.getElementById('delete-form').submit(); }"
                                >
                                    Delete
                                </a>
                                <form id="delete-form" action="{{ route('admin.events.destroy', $event->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>

                        </tr>
                    @empty
                        <tr>No Events Yet!!</tr>
                    @endforelse

                    </tbody>
                </table>
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