<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'location',
        'ordinary_member_price',
        'trainee_member_price',
        'associate_member_price',
        'description',
        'date',
        'category',
        'image',
        'is_published',
        'unique_id',
        'slug'
    ];

    public function attendance(){
        return $this->hasMany(Attendance::class, 'event_id');
    }

    public function userAttendance()
    {
        return $this->hasOne(Attendance::class, 'event_id')->latest('created_at');
    }

    public function accommodations()
    {
        return $this->hasMany(Accommodation::class, 'event_id', 'id');
    }

    public function getUserAccommodations($userId)
    {
        return $this->accommodations->where('user_id', $userId);
    }

    public function userAccommodation()
    {
        return $this->hasOne(Accommodation::class, 'event_id', 'id')
            ->where('user_id', auth()->id())
            ->latest('created_at')
            ->limit(1);
    }

}
