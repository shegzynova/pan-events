<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public $table = 'transactions';

    public $fillable = [
        'event_id',
        'user_id',
        'amount',
        'status',
        'transaction_reference',
        'payment_method'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'status' => 'string',
        'transaction_reference' => 'string'
    ];

    public static array $rules = [
        'event_id' => 'required',
        'user_id' => 'required',
        'amount' => 'required|numeric',
        'status' => 'required|string|max:255',
        'transaction_reference' => 'required|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'payment_method' => 'nullable'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function eventUser()
    {
        return $this->belongsTo(EventUser::class, 'user_id', 'user_id')
            ->where('event_id', $this->event_id);
    }

    public function reservation()
    {
        return $this->belongsTo(Accommodation::class, 'user_id', 'user_id')
            ->where('event_id', $this->event_id);
    }

    public function attendance()
    {
        return $this->belongsTo(Attendance::class, 'user_id', 'user_id')
            ->where('event_id', $this->event_id);
    }
}
