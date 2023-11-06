<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
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
            'ordinary_member_price' => 'nullable|numeric',
            'trainee_member_price' => 'nullable|numeric',
            'associate_member_price' => 'nullable|numeric',
            'description' => 'required|string',
            'date' => 'required',
            'category' => 'required|string',
            'image' => 'nullable',
            'is_published' => 'sometimes',
        ];
    }
}
