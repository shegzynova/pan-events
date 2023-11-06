<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nature_of_practice',
        'institution',
        'state',
        'country',
        'city',
        'title',
        'type',
        'status',
        'first_name',
        'surname',
        'gender',
        'event_id',
        'education_level',
        'employment_status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function exhibitionTotalPrice()
    {
        return $this->hasMany(ExhibitionPurchase::class, 'attendance_id')
            ->selectRaw('sum(total_amount) as total')
            ->groupBy('attendance_id');
    }

    public function exhibitionPurchases()
    {
        return $this->hasMany(ExhibitionPurchase::class, 'attendance_id');
    }

    public function relatedTransactions()
    {
        return $this->hasMany(Transaction::class, 'user_id', 'user_id')
            ->where('event_id', $this->event_id);
    }

    public function relatedSuccessfulTransactions()
    {
        return $this->hasMany(Transaction::class, 'user_id', 'user_id')
            ->where('event_id', $this->event_id)
            ->where('status', 'successful');
    }

    public function relatedLatestSuccessfulTransaction()
    {
        return $this->hasOne(Transaction::class, 'user_id', 'user_id')
            ->where('event_id', $this->event_id)
            ->where('status', 'successful')
            ->latest('created_at');
    }
}
