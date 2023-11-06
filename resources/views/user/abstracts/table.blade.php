<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="abstracts-table">
            <thead>
            <tr>
                <th>Full Name</th>
                <th>Contact Phone Number</th>
                <th>Email</th>
                <th>No Of Pages</th>
                <th>Abstract Title</th>
                <th>Duration</th>
                <th>Status</th>
                <th colspan="3">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($abstracts as $abstract)
                <tr>
                    <td>{{ $abstract->full_name }}</td>
                    <td>{{ $abstract->contact_phone_number }}</td>
                    <td>{{ $abstract->email }}</td>
                    <td>{{ $abstract->no_of_pages }}</td>
                    <td>{{ $abstract->abstract_title }}</td>
                    <td>{{ $abstract->duration }}</td>
                    <td>
                        @if($abstract->status == 'p')
                            <button class="btn btn-rounded btn-pending-soft w-24 mr-1 mb-2">Pending</button>
                        @elseif($abstract->status == 'a')
                            <button class="btn btn-rounded btn-success-soft w-24 mr-1 mb-2">Approved</button>
                        @else
                            <button class="btn btn-rounded btn-danger-soft w-24 mr-1 mb-2">Declined</button>
                        @endif
                    </td>
                    <td  style="width: 120px">
                        <div class='btn-group flex'>
                            <a href="{{ route('user.abstracts.show', [$abstract->id]) }}"
                               class='btn btn-default btn-xs mr-2'>
                                SHOW
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="card-footer clearfix">
        <div class="float-right">
            @include('adminlte-templates::common.paginate', ['records' => $abstracts])
        </div>
    </div>
</div>
