<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StepOneRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'first_name' => 'required|string',
            'surname' => 'required|string',
            'phone_number' => 'required',
            'gender' => 'required',
            'nature_practice' => 'required|string',
            'city' => 'required',
            'institution' => 'required|string',
            'state' => 'sometimes',
            'country' => 'required|string',
        ];
    }
}
