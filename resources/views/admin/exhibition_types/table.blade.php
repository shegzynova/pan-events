<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="exhibition-types-table">
            <thead>
            <tr>
                <th>Type</th>
                <th>Status</th>
                <th colspan="3">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($exhibitionTypes as $exhibitionType)
                <tr>
                    <td>{{ $exhibitionType->type }}</td>
                    <td>
                        @if($exhibitionType->is_active)
                            <button class="btn btn-rounded btn-success-soft w-24 mr-1 mb-2">Active</button>
                        @else
                            <button class="btn btn-rounded btn-danger-soft w-24 mr-1 mb-2">Not Active</button>
                        @endif
                    </td>
                    <td  style="width: 220px">
                        {!! Form::open(['route' => ['admin.exhibitionTypes.destroy', $exhibitionType->id], 'method' => 'delete']) !!}
                        <div class='btn-group flex'>
                            <a href="{{ route('admin.exhibitionTypes.edit', [$exhibitionType->id]) }}"
                               class='btn btn-default btn-xs mr-2'>
                                <i data-lucide="edit-2"></i>
                            </a>
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
            @include('adminlte-templates::common.paginate', ['records' => $exhibitionTypes])
        </div>
    </div>
</div>
