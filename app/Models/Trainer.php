<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trainer extends Model
{
    use HasFactory;
    protected $guarded = [] ;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function classes()
    {
        return $this->HasMany(ClassSchedule::class,'trainer_id');
    }
   
}
