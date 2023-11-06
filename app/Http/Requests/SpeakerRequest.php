<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SpeakerRequest extends FormRequest
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
    public static function rules(): array
    {
        return [
            'full_name' => 'required',
            'contact_phone_number' => 'required|numeric',
            'email' => 'required|email',
            'address' => 'required',
            'no_of_pages' => 'required',
            'abstract_title' => 'required',
            'duration' => 'required',
            'additional_information' => 'nullable',
            'file' => 'required|file|mimes:pdf,doc,docs,docx',
        ];
    }
}
