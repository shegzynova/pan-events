<!-- Exhibition Id Field -->
<div class="flex-1 mt-3">
    <label for="title" class="form-label">Select Exhibitions</label>
    <select data-placeholder="Select Exhibition(s)" class="tom-select w-full" name="exhibition[]"
            multiple>
        @foreach($exhibition_types AS $type)
            <optgroup label="{{ $type->type }}">
                @foreach($type->exhibitions AS $exhibition)
                    <option value="{{ $exhibition->id }}">{{ $exhibition->category }} - {{ $exhibition->description }} - ₦{{ number_format($exhibition->amount) }}</option>
                @endforeach
            </optgroup>

        @endforeach
            @if(isset($exhibitionPurchase))
                @foreach($exhibition_types AS $type)
                    <optgroup label="{{ $type->type }}">
                        @foreach($type->exhibitions AS $exhibition)
                            <option {{ ($exhibition->id == $exhibitionPurchase->exhibition_id) ? 'selected' : '' }} value="{{ $exhibition->id }}">{{ $exhibition->category }} - {{ $exhibition->description }} - ₦{{ number_format($exhibition->amount) }}</option>
                        @endforeach
                    </optgroup>
                @endforeach
            @endif

    </select>
</div>

<!-- Attendance Id Field -->
<div class="mb-4">
    {!! Form::label('attendance_id', 'Attendance:') !!}
    {!! Form::select('attendance_id', $attendances, null, ['class' => 'form-control mt-2', 'required']) !!}
</div>



<!-- Paid Field -->
<div class="mb-3">
    <div class="form-check">
        <input type="checkbox" class="form-check-input" id="paid" name="paid" {{ isset($exhibitionPurchase) ? $exhibitionPurchase->paid == 'paid' ? 'checked' : '' : '' }}>
        <label class="form-check-label" for="paid">Paid</label><br>
    </div>
</div>