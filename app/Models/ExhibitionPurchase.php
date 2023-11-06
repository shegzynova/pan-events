<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExhibitionPurchase extends Model
{
    public $table = 'exhibition_purchases';

    public $fillable = [
        'exhibition_id',
        'attendance_id',
        'total_amount',
        'paid'
    ];

    protected $casts = [
        'exhibition_id' => 'integer',
        'attendance_id' => 'integer',
        'paid' => 'string'
    ];

    public static array $rules = [
        'exhibition' => 'required',
        'attendance_id' => 'required',
        'paid' => 'nullable'
    ];

    public function exhibition()
    {
        return $this->belongsTo(Exhibition::class);
    }

    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }
    
}
