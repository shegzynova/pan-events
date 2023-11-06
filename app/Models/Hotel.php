<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    public $table = 'hotels';

    public $fillable = [
        'name',
        'address',
        'phone_contact',
        'price',
        'no_rooms_available',
        'event_id'
    ];

    protected $casts = [
        'name' => 'string',
        'address' => 'string',
        'phone_contact' => 'string',
        'price' => 'double',
        'no_rooms_available' => 'double'
    ];

    public static array $rules = [
        'name' => 'required',
        'address' => 'required',
        'phone_contact' => 'required',
        'price' => 'required',
        'no_rooms_available' => 'required',
        'event_id' => 'required'
    ];


    public function accommodations() {
        return $this->hasMany(Accommodation::class);
    }

    public function event() {
        return $this->belongsTo(Event::class);
    }


}
