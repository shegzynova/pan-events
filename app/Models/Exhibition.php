<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exhibition extends Model
{
    public $table = 'exhibitions';

    public $fillable = [
        'category',
        'amount',
        'description',
        'exhibition_type_id'
    ];

    protected $casts = [
        'category' => 'string',
        'amount' => 'double',
        'description' => 'string',
        'exhibition_type_id' => 'integer'
    ];

    public static array $rules = [
        'category' => 'required',
        'amount' => 'required',
        'description' => 'required',
        'exhibition_type_id' => 'required'
    ];


    public function type()
    {
        return $this->belongsTo(ExhibitionType::class, 'exhibition_type_id');
    }
    
}
