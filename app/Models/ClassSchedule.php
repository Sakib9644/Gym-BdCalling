<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassSchedule extends Model
{
    use HasFactory;
    protected $guarded = [] ;

    public function trainer()
{
    return $this->belongsTo(Trainer::class, 'trainer_id');
}
    public function bookings()
{
    return $this->HasMany(Booking::class, 'class_id');
}

}
