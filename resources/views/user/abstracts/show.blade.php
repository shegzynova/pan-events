@extends('user.layouts.app')

@section('content')

    <div class="content">
        <!-- BEGIN: Top Bar -->
        @include('user.layouts.topbar', ['title' => $abstract->abstract_title])
        <!-- END: Top Bar -->
        <h2 class="intro-y text-lg font-medium mt-10">
            {{ $abstract->abstract_title }}
            @if($abstract->status == 'p')
                <button class="btn btn-rounded btn-pending-soft btn-sm w-24 mr-1 mb-2">Pending</button>
            @elseif($abstract->status == 'a')
                <button class="btn btn-rounded btn-success-soft btn-sm w-24 mr-1 mb-2">Approved</button>
            @else
                <button class="btn btn-rounded btn-danger-soft btn-sm w-24 mr-1 mb-2">Declined</button>
            @endif
        </h2>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible show flex items-center mb-2" role="alert"><i
                        data-lucide="alert-triangle" class="w-6 h-6 mr-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-tw-dismiss="alert" aria-label="Close"><i data-lucide="x"
                                                                                                      class="w-4 h-4"></i>
                </button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible show flex items-center mb-2" role="alert"><i
                        data-lucide="alert-triangle" class="w-6 h-6 mr-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-tw-dismiss="alert" aria-label="Close"><i data-lucide="x"
                                                                                                      class="w-4 h-4"></i>
                </button>
            </div>
        @endif

        <div class="grid grid-cols-12 gap-6 mt-5">
            <div class="col-span-12 lg:col-span-12 mr-2">
                <div class="tab-content">
                    <div id="details" class="tab-pane active" role="tabpanel" aria-labelledby="details-tab">
                        <div class="box p-5 mt-5">
                            <div class="flex items-center border-b border-slate-200 dark:border-darkmode-400 pb-5">
                                <div>
                                    <div class="text-slate-500">Abstract Title</div>
                                    <div class="mt-1">{{ $abstract->abstract_title }}</div>
                                </div>
                                <i data-lucide="calendar" class="w-4 h-4 text-slate-500 ml-auto"></i>
                            </div>
                            <div class="flex items-center border-b border-slate-200 dark:border-darkmode-400 py-5">
                                <div>
                                    <div class="text-slate-500">No Of Pages</div>
                                    <div class="mt-1">{{ $abstract->no_of_pages }}</div>
                                </div>
                                <i data-lucide="user" class="w-4 h-4 text-slate-500 ml-auto"></i>
                            </div>
                            <div class="flex items-center border-b border-slate-200 dark:border-darkmode-400 py-5">
                                <div>
                                    <div class="text-slate-500">Duration</div>
                                    <div class="mt-1">{{ $abstract->duration }}</div>
                                </div>
                                <i data-lucide="map-pin" class="w-4 h-4 text-slate-500 ml-auto"></i>
                            </div>
                            <div class="flex items-center pt-5 border-b border-slate-200 dark:border-darkmode-400 py-5">
                                <div>
                                    <div class="text-slate-500">Additional Information</div>
                                    <div class="mt-1">{!! $abstract->additional_information !!}</div>
                                </div>
                                <i data-lucide="clock" class="w-4 h-4 text-slate-500 ml-auto"></i>
                            </div>
                            <div class="flex items-center pt-5">
                                <div>
                                    <div class="text-slate-500">Abstract File</div>
                                    <div class="flex mt-4">
                                        @if(!is_null($abstract->file))
                                        <div class="mr-3">
                                            <a href="{{ asset($abstract->file) }}" target="_blank" class="btn btn-secondary-soft shadow-md mr-2">VIEW FILE</a>
                                        </div>
                                        <div class="mr-3">
                                            <a href="{{ asset($abstract->file) }}" download class="btn btn-secondary-soft shadow-md mr-2">DOWNLOAD FILE</a>
                                        </div>
                                        @endif
                                        @if(!is_null($abstract->full_paper))
                                        <div class="mr-3">
                                            <a href="{{ asset('storage/'.$abstract->full_paper) }}" target="_blank" class="btn btn-secondary-soft shadow-md mr-2">FULL PAPER</a>
                                        </div>
                                        @endif
                                        @if(!is_null($abstract->presentation))
                                        <div>
                                            <a href="{{ asset('storage/'.$abstract->presentation) }}" download class="btn btn-secondary-soft shadow-md mr-2">DOWNLOAD PRESENTATION</a>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <i data-lucide="book-open" class="w-4 h-4 text-slate-500 ml-auto"></i>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        @if($abstract->status == 'a')
        {!! Form::open(['route' => ['user.abstract.full-paper', $abstract->id], 'enctype' => 'multipart/form-data']) !!}
        @if( !is_null( $errors->all() ) )
            @foreach($errors->all() as $error)
                <div class="alert alert-danger show flex items-center mb-2" role="alert"><i data-lucide="alert-triangle"
                                                                                            class="w-6 h-6 mr-2"></i>
                    {{ $error }}
                </div>
            @endforeach
        @endif
        <div class="grid grid-cols-12 gap-6 mt-5">
            <div class="col-span-12 lg:col-span-12 mr-2">
                <div class="tab-content">
                    <div id="details" class="tab-pane active" role="tabpanel" aria-labelledby="details-tab">
                        <div class="box p-5 mt-5">
                            <div class="mb-5 mt-4">
                                {!! Form::label('abstract', 'Abstract: ') !!}
                                @if($abstract->status == 'a')
                                    <button class="btn btn-success btn-sm">APPROVED</button>
                                @elseif($abstract->status == 'p')
                                    <button class="btn btn-secondary btn-sm">PENDING</button>
                                @else
                                    <button class="btn btn-danger btn-sm">DECLINED</button>
                                @endif
                                <div class="input-group mt-4">
                                    <div class="custom-file">
                                        {!! Form::file('abstract', ['class' => 'custom-file-input']) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="mb-5 mt-4">
                                {!! Form::label('full_paper', 'Full Paper: ') !!}
                                @if($abstract->full_paper_status == 'a')
                                    <button class="btn btn-success btn-sm">APPROVED</button>
                                @elseif($abstract->full_paper_status == 'p')
                                    <button class="btn btn-secondary btn-sm">PENDING</button>
                                @else
                                    <button class="btn btn-danger btn-sm">DECLINED</button>
                                @endif
                                <div class="input-group mt-4">
                                    <div class="custom-file">
                                        {!! Form::file('full_paper', ['class' => 'custom-file-input']) !!}
                                    </div>
                                </div>
                            </div>

                            @if($abstract->full_paper_status == 'a')
                            <!-- Contact Phone Number Field -->
                            <div class="mb-3 mt-5">
                                {!! Form::label('presentation', 'Presentation:') !!}
                                @if($abstract->presentation_status == 'a')
                                    <button class="btn btn-success btn-sm">APPROVED</button>
                                @elseif($abstract->presentation_status == 'p')
                                    <button class="btn btn-secondary btn-sm">PENDING</button>
                                @else
                                    <button class="btn btn-danger btn-sm">DECLINED</button>
                                @endif
                                <div class="input-group mt-4">
                                    <div class="custom-file">
                                        {!! Form::file('presentation', ['class' => 'custom-file-input']) !!}
                                    </div>
                                </div>
                            </div>
                            @endif

                            {!! Form::submit('Upload', ['class' => 'btn btn-primary mt-4']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
        @endif

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

    </script>
@endsection