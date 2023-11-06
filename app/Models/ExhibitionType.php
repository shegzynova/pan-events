<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExhibitionType extends Model
{
    public $table = 'exhibition_types';

    public $fillable = [
        'type',
        'is_active'
    ];

    protected $casts = [
        'type' => 'string',
        'is_active' => 'boolean'
    ];

    public static array $rules = [
        'type' => 'required',
        'is_active' => 'required'
    ];

    public function exhibitions()
    {
        return $this->hasMany(Exhibition::class);
    }
    
}
