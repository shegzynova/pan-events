<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventHotel extends Model
{
    use HasFactory;
    protected $fillable = [
        'hotel_id', 'event_id'
    ];

    public function hotel()
    {
        return $this->hasOne(Hotel::class, 'id', 'hotel_id');
    }
    public function event()
    {
        return $this->hasMany(Event::class, 'id', 'event_id');
    }
}
