<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Booking extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function vendors()
    {
        return $this->belongsToMany(User::class, 'booking_vendors');
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function getDateAttribute( $value ) {
        return (new Carbon($value))->format('d-m-Y H:i A');
    }
}
