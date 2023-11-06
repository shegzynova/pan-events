<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="exhibitions-table">
            <thead>
            <tr>
                <th>Category</th>
                <th>Amount</th>
                <th>Description</th>
                <th>Exhibition Type</th>
                <th colspan="3">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($exhibitions as $exhibition)
                <tr>
                    <td>{{ $exhibition->category }}</td>
                    <td>{{ $exhibition->amount }}</td>
                    <td>{{ $exhibition->description }}</td>
                    <td>{{ optional(optional($exhibition)->type)->type }}</td>
                    <td  style="width: 120px">
                        {!! Form::open(['route' => ['admin.exhibitions.destroy', $exhibition->id], 'method' => 'delete']) !!}
                        <div class='btn-group flex'>
                            <a href="{{ route('admin.exhibitions.edit', [$exhibition->id]) }}"
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
            @include('adminlte-templates::common.paginate', ['records' => $exhibitions])
        </div>
    </div>
</div>
