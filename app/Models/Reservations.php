<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservations extends Model
{
    public $table = 'accommodations';

    public $fillable = [
        'hotel_id',
        'user_id',
        'event_id',
        'transaction_id',
        'quantity',
        'total_amount',
        'isPaid',
        'payment_ref'
    ];

    protected $casts = [
        'isPaid' => 'boolean'
    ];

    public static array $rules = [
        'hotel_id' => 'required|exists:hotels,id',
        'quantity' => 'required',
        'isPaid' => 'nullable|boolean',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function eventUser()
    {
        return $this->belongsTo(EventUser::class, 'user_id', 'user_id')
            ->where('event_id', $this->event_id);
    }
}
