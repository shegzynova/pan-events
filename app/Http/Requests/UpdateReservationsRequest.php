<?php

namespace App\Http\Requests;

use App\Models\Reservations;
use Illuminate\Foundation\Http\FormRequest;

class UpdateReservationsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = Reservations::$rules;
        
        return $rules;
    }
}
