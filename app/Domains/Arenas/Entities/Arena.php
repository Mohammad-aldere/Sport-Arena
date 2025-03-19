<?php
namespace App\Domains\Arenas\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Domains\Bookings\Entities\TimeSlot;
use App\Models\User;

class Arena extends Model {
    protected $fillable = ['name', 'description', 'owner_id', 'duration'];

    public function owner() {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function timeSlots() {
        return $this->hasMany(TimeSlot::class);
    }
}
