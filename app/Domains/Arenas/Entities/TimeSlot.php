<?php
namespace App\Domains\Arenas\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Domains\Arenas\Entities\Arena;
use App\Domains\Bookings\Entities\Booking;

class TimeSlot extends Model {
    
    protected $fillable = ['arena_id', 'start_time', 'end_time', 'is_booked'];

    public function arena() {
        return $this->belongsTo(Arena::class);
    }
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}

