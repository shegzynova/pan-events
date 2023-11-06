<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accommodation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function successful_transaction()
    {
        return $this->belongsTo(Transaction::class)->where('status','=', 'successful')->sum('amount');
    }

    public function transactions()
    {
        return $this->belongsTo(Transaction::class)->where('status','=', 'successful')->sum('amount');
    }

}
