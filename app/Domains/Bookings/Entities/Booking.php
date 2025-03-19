<?php


namespace App\Domains\Bookings\Entities;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = ['arena_id', 'user_id', 'time_slot_id', 'status'];

    public function timeSlot()
    {
        return $this->belongsTo(TimeSlot::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
