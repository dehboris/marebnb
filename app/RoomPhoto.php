<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomPhoto extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['room_id', 'filename'];

    /**
     * Photo belongs to the room.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
