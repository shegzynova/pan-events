<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbstractModel extends Model
{
    public $table = 'abstracts';

    public $fillable = [
        'full_name',
        'contact_phone_number',
        'email',
        'address',
        'no_of_pages',
        'abstract_title',
        'duration',
        'additional_information',
        'file',
        'attendance_id'
    ];

    protected $casts = [
        'full_name' => 'string',
        'contact_phone_number' => 'string',
        'email' => 'string',
        'address' => 'string',
        'no_of_pages' => 'double',
        'abstract_title' => 'string',
        'duration' => 'double',
        'additional_information' => 'string',
        'file' => 'string'
    ];

    public static array $rules = [
        'full_name' => 'required',
        'contact_phone_number' => 'required',
        'email' => 'required',
        'address' => 'required',
        'no_of_pages' => 'required|numeric',
        'abstract_title' => 'required',
        'duration' => 'required',
        'additional_information' => 'nullable',
        'file' => 'required'
    ];

    
}
