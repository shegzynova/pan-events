@extends('admin.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>
                        Edit Hotel
                    </h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content">
        <!-- BEGIN: Top Bar -->
        @include('admin.layouts.topbar', ['title' => 'Edit Hotel'])
        <!-- END: Top Bar -->
        <div class="intro-y flex items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">
                Edit Hotel
            </h2>
        </div>
        @if( !is_null( $errors->all() ) )
            @foreach($errors->all() as $error)
                <div class="alert alert-danger show flex items-center mb-2" role="alert"> <i data-lucide="alert-triangle" class="w-6 h-6 mr-2"></i>
                    {{ $error }} </div>
            @endforeach
        @endif
        <div class="content px-3">

            @include('adminlte-templates::common.errors')

            {!! Form::model($hotel, ['route' => ['admin.hotels.update', $hotel->id], 'method' => 'patch']) !!}
                @csrf
                @method('PUT')
                <div class="grid grid-cols-12 gap-6 mt-5">
                    <div class="intro-y col-span-12 lg:col-span-12">
                        <!-- BEGIN: Form Layout -->
                        <div class="intro-y box p-5">
                            <div class="intro-y box p-5">
                                @include('admin.hotels.fields')
                                <div class="text-right mt-5">
                                    <button type="button" class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                                    <button class="btn btn-primary w-24">Save</button>
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


