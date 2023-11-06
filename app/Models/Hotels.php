<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotels extends Model
{
    use HasFactory;

    protected $fillable =[
        'name',
        'address',
        'phone_contact',
        'price',
        'no_rooms_available'
    ];

}
