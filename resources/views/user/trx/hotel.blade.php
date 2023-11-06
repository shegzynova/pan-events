@extends('user.layouts.app')

@section('content')

<div class="content">
    <!-- BEGIN: Top Bar -->
    @include('user.layouts.topbar', ['title' => 'Hotel Booking'])
    <!-- END: Top Bar -->
    <h2 class="intro-y text-lg font-medium mt-10">
        Hotel Booking
    </h2>
    @if( !is_null( $errors->all() ) )
    @foreach($errors->all() as $error)
    <div class="alert alert-danger show flex items-center mb-2" role="alert"><i data-lucide="alert-triangle" class="w-6 h-6 mr-2"></i>
        {{ $error }}
    </div>
    @endforeach
    @endif
    @if(session('success'))
    <div class="alert alert-success alert-dismissible show flex items-center mb-2" role="alert"><i data-lucide="alert-triangle" class="w-6 h-6 mr-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-tw-dismiss="alert" aria-label="Close"><i data-lucide="x" class="w-4 h-4"></i>
        </button>
    </div>
    @endif
    <form method="POST" action="" enctype="multipart/form-data" id="eventForm">
        @csrf
        @method('POST')
        <div class="hotel-booking">
        <div class="mt-5">
                <p class="mt-2">Hotels are availabe upon request for guest who wish to lodge during the confrence. The hotel bill will be added to the conference registration fee.</p>
                <div class="intro-y col-span-12 overflow-auto lg:overflow-visible mt-5">
                    @foreach ($hotels as $hotel)
                    <input type="radio" id="option5" name="option" value="{{$hotel->hotel->id}}">
                    <label for="option5">{{$hotel->hotel->name}} | {{$hotel->hotel->price}} | Rooms Remaining {{$hotel->hotel->no_rooms_available}}</label><br>
                    @endforeach
                </div>
            </div>
            <div class="date-range flex justify-between mt-8">
                <div class="date">
                    <input type="date" id="check-in" name="check-in" />
                </div>
                <div class="date ml-8">
                    <input type="date" id="check-out" name="check-out" />
                </div>
            </div>
            <div class="mt-8">
                <button class="btn btn-danger mr-8">Cancel</button>
                <button class="btn btn-primary  ml-8">Book Now</button>
            </div>
        </div>
    </form>
    <!-- END: Delete Confirmation Modal -->
</div>

@endsection