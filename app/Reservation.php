<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Reservation
 *
 * @property int $id
 * @property int $room_id
 * @property int $user_id
 * @property int $adults
 * @property int $children
 * @property bool $need_parking
 * @property bool $need_wifi
 * @property bool $need_tv
 * @property \Carbon\Carbon $date_start
 * @property \Carbon\Carbon $date_end
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $approved_at
 * @property-read \App\Room $room
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Query\Builder|\App\Reservation whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Reservation whereRoomId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Reservation whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Reservation whereAdults($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Reservation whereChildren($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Reservation whereNeedParking($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Reservation whereNeedWifi($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Reservation whereNeedTv($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Reservation whereDateStart($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Reservation whereDateEnd($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Reservation whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Reservation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Reservation whereApprovedAt($value)
 * @mixin \Eloquent
 */
class Reservation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['room_id', 'user_id', 'adults', 'children', 'need_parking', 'need_wifi', 'need_tv', 'date_start', 'date_end', 'approved_at'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['date_start', 'date_end', 'approved_at'];

    /**
     * A reservation belongs to a room.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * A reservation is created by the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
