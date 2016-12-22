<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\RoomPhoto
 *
 * @property int $id
 * @property int $room_id
 * @property string $filename
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Room $room
 * @method static \Illuminate\Database\Query\Builder|\App\RoomPhoto whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RoomPhoto whereRoomId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RoomPhoto whereFilename($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RoomPhoto whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RoomPhoto whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class RoomPhoto extends Model
{
    /**
     * Database table used for the model.
     *
     * @var string
     */
    protected $table = 'room_gallery';

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
