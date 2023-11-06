@extends('admin.layouts.app')

@section('content')

    <div class="content">
        <!-- BEGIN: Top Bar -->
        @include('admin.layouts.topbar', ['title' => 'Update Settings'])
        <!-- END: Top Bar -->
        <div class="intro-y flex items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">
                Update Settings
            </h2>
        </div>
        <div class="content px-3">

            @include('adminlte-templates::common.errors')

            {!! Form::model($settings, ['route' => ['admin.settings.index'], 'method' => 'post', 'enctype' => "multipart/form-data"]) !!}
            <div class="grid grid-cols-12 gap-6 mt-5">
                <div class="intro-y col-span-12 lg:col-span-12">
                    <!-- BEGIN: Form Layout -->
                    <div class="intro-y box p-5">
                        <div class="intro-y box p-5">

                            @include('admin.settings.fields')

                            <div class="text-right mt-5">
                                {!! Form::submit('Save', ['class' => 'btn btn-primary w-24']) !!}
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

