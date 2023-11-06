@extends('admin.layouts.app')

@section('content')

    <div class="content px-3">
        <!-- BEGIN: Top Bar -->
        @include('user.layouts.topbar', ['title' => 'Create Abstracts'])
        <!-- END: Top Bar -->
        <div class="intro-y flex items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">
                Create Abstract
            </h2>
        </div>
        <div class="content px-3">

            @include('adminlte-templates::common.errors')

            {!! Form::open(['route' => 'admin.abstracts.store']) !!}

            <div class="grid grid-cols-12 gap-6 mt-5">
                <div class="intro-y col-span-12 lg:col-span-12">
                    <!-- BEGIN: Form Layout -->
                    <div class="intro-y box p-5">
                        <div class="intro-y box p-5">

                            @include('admin.abstracts.fields')

                            <div class="text-right mt-5">
                                <a href="{{ route('admin.abstracts.index') }}" class="btn btn-outline-secondary w-24 mr-1"> Cancel </a>
                                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                            </div>
                        </div>
                    </div>
                    <!-- END: Form Layout -->
                </div>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection