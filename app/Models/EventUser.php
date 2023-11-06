<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventUser extends Model
{
    public $table = 'events_users';

    public $fillable = [
        'user_id',
        'event_id',
        'title',
        'first_name',
        'surname',
        'phone_number',
        'email',
        'gender',
        'nature_practice',
        'institution',
        'city',
        'state',
        'nationality',
        'paid',
        'payment_ref',
        'payment_type',
        'total_amount'
    ];

    protected $casts = [
        'title' => 'string',
        'first_name' => 'string',
        'surname' => 'string',
        'phone_number' => 'string',
        'email' => 'string',
        'gender' => 'string',
        'nature_practice' => 'string',
        'institution' => 'string',
        'city' => 'string',
        'state' => 'string',
        'nationality' => 'string',
        'paid' => 'boolean',
        'payment_ref' => 'string',
        'payment_type' => 'string'
    ];

    public static array $rules = [
        'user_id' => 'nullable',
        'event_id' => 'nullable',
        'surname' => 'required|string|max:255',
        'gender' => 'required|string|max:255',
        'nature_practice' => 'required|string|max:255',
        'institution' => 'required|string|max:255',
        'city' => 'required|string|max:255',
        'state' => 'nullable|string|max:255',
        'nationality' => 'required|string|max:255',
        'paid' => 'nullable|boolean',
        'payment_ref' => 'nullable|string|max:255',
        'payment_type' => 'nullable|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function event(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Event::class, 'event_id');
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function state_name(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\State::class, 'state', 'id');
    }

    public function country(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Country::class, 'nationality', 'id');
    }

    public function transaction(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Transaction::class, 'payment_ref', 'transaction_reference');
    }
}
