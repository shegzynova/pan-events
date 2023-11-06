<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="hotels-table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Address</th>
                <th>Phone Contact</th>
                <th>Price</th>
                <th>Event</th>
                <th>No Rooms Available</th>
                <th colspan="3">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($hotels as $hotel)
                <tr>
                    <td>{{ $hotel->name }}</td>
                    <td>{{ $hotel->address }}</td>
                    <td>{{ $hotel->phone_contact }}</td>
                    <td>{{ $hotel->price }}</td>
                    <td>{{ optional(optional($hotel)->event)->title }}</td>
                    <td>{{ $hotel->no_rooms_available }}</td>
                    <td  style="width: 120px">
                        {!! Form::open(['route' => ['admin.hotels.destroy', $hotel->id], 'method' => 'delete']) !!}
                        <div class='flex'>
{{--                            <a href="{{ route('admin.hotels.edit', [$hotel->id]) }}"--}}
{{--                               class='btn btn-default btn-xs mr-2'>--}}
{{--                                <i data-lucide="eye"></i>--}}
{{--                            </a>--}}
                            {!! Form::button('<i data-lucide="trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                        </div>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="card-footer clearfix">
        <div class="float-right">
            @include('adminlte-templates::common.paginate', ['records' => $hotels])
        </div>
    </div>
</div>
