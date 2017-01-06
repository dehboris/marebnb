<?php

namespace App;

use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

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

    /**
     * The 'room is reserved in this term' condition.
     *
     * @param string $dateStart Start date in a d/m/Y format
     * @param string $dateEnd   End date in a d/m/Y format
     * @return bool
     */
    public function isReserved($dateStart, $dateEnd)
    {
        if (!$dateStart instanceof Carbon) {
            $dateStart = Carbon::createFromFormat('d/m/Y', $dateStart);
        }

        if (!$dateEnd instanceof Carbon) {
            $dateEnd = Carbon::createFromFormat('d/m/Y', $dateEnd);
        }

        return ($dateStart->gte($this->date_start) && $dateStart->lte($this->date_end)) || ($dateEnd->gte($this->date_start) && $dateEnd->lte($this->date_end)) || ($dateStart->lte($this->date_start) && $dateEnd->gte($this->date_end));
    }

    /**
     * Check if reservation dates are not out of range (all rooms are available 1.5 - 30.9).
     *
     * @param string $dateStart Start date in a d/m/Y format
     * @param string $dateEnd   End date in a d/m/Y format
     * @return bool
     */
    public static function isOutOfRange($dateStart, $dateEnd)
    {
        if (!$dateStart instanceof Carbon) {
            $dateStart = Carbon::createFromFormat('d/m/Y', $dateStart);
        }

        if (!$dateEnd instanceof Carbon) {
            $dateEnd = Carbon::createFromFormat('d/m/Y', $dateEnd);
        }

        return $dateStart->lt(Carbon::create($dateStart->year, 5, 1)) || $dateEnd->gt(Carbon::create($dateStart->year, 9, 30));
    }

    /**
     * Create new reservation. Accepts Request object which then parses to create new instance of the class and
     * persists it to the database.
     *
     * @param Request $request Input attributes
     * @return static
     */
    public static function createFromRequest(Request $request)
    {
        $attributes = $request->all();
        $attributes['user_id'] = Auth::guard('api')->user()->id;
        $attributes['approved_at'] = null;
        $attributes['date_start'] = Carbon::createFromFormat('d/m/Y', $request->get('date_start'));
        $attributes['date_end'] = Carbon::createFromFormat('d/m/Y', $request->get('date_end'));

        return static::create($attributes);
    }

    /**
     * approved() scope. Finds all columns whose 'approved_at' value not null.
     *
     * @param mixed $q Query
     * @return mixed
     */
    public static function scopeApproved($q)
    {
        return $q->whereNotNull('approved_at');
    }

    /**
     * Find all approved reservations for a room.
     *
     * @param int $id Room ID
     * @return mixed
     */
    public static function allApproved($id)
    {
        return static::approved()->where('room_id', $id)->get();
    }

    /**
     * Check if reservation is approved or not (approved_at != null).
     *
     * @return bool
     */
    public function isApproved()
    {
        return !is_null($this->approved_at);
    }

    /**
     * Handle the reservation. Accept it or deny it. Also check if room is reserved in this date range.
     *
     * @param bool $accepted Accept it or not?
     * @return bool
     */
    public function handle(bool $accepted)
    {
        if ($this->isApproved()) {
            return false;
        }

        if ($accepted) {
            if (static::alreadyReservedInDates($this->date_start, $this->date_end, $this->room_id, $this->id)) {
                return false;
            }

            $this->update([
                'approved_at' => Carbon::now()
            ]);

            return true;
        } else {
            $this->delete();

            return true;
        }
    }

    /**
     * Check if room is reserved in selected days.
     *
     * @param $dateStart
     * @param $dateEnd
     * @param $roomID
     * @param null $id
     * @return bool
     */
    public static function alreadyReservedInDates($dateStart, $dateEnd, $roomID, $id = null)
    {
        if (!$dateStart instanceof Carbon) {
            $dateStart = Carbon::createFromFormat('d/m/Y', $dateStart);
        }

        if (!$dateEnd instanceof Carbon) {
            $dateEnd = Carbon::createFromFormat('d/m/Y', $dateEnd);
        }

        $reservations = Reservation::allApproved($roomID);

        foreach ($reservations as $reservation) {
            if ($reservation->id == $id) continue;

            // Room is already reserved?
            if ($reservation->isReserved($dateStart, $dateEnd)) {
                return true;
            }
        }

        return false;
    }
}
