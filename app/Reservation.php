<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['room_id', 'user_id', 'adults', 'children', 'need_parking', 'need_wifi', 'need_tv', 'date_start', 'date_end'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['date_start', 'date_end'];

    public function room() {
    	return $this->belongsTo(Room::class);
    }

    public function user() {
    	return $this->belongsTo(User::class);
    }
}
