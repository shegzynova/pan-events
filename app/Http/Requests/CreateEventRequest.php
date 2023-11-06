<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateEventRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string',
            'location' => 'required|string',
            'regular_price' => 'nullable|numeric',
            'exhibition_price' => 'nullable|numeric',
            'speaker_price' => 'nullable|numeric',
            'description' => 'required|string',
            'date' => 'required',
            'category' => 'required|string',
            'image' => 'nullable',
            'is_published' => 'sometimes',
        ];
    }
}
