<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Storage;

/**
 * App\Room
 *
 * @property int $id
 * @property int $object_id
 * @property int $category_id
 * @property string $label
 * @property float $price
 * @property int $max_people
 * @property int $min_people
 * @property bool $seaside
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property \Carbon\Carbon $reserved_at
 * @property \Carbon\Carbon $reserved_until
 * @property-read \App\Object $object
 * @property-read \App\Category $category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\RoomPhoto[] $photos
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Reservation[] $reservations
 * @method static \Illuminate\Database\Query\Builder|\App\Room whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Room whereObjectId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Room whereCategoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Room whereLabel($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Room wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Room whereMaxPeople($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Room whereMinPeople($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Room whereSeaside($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Room whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Room whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Room whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Room whereReservedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Room whereReservedUntil($value)
 * @mixin \Eloquent
 */
class Room extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['object_id', 'label', 'category_id', 'price', 'max_people', 'min_people', 'seaside'];

    /**
     * Attributes that should be cast to another types.
     *
     * @var array
     */
    protected $casts = ['seaside' => 'bool'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'reserved_at', 'reserved_until'];

    /**
     * Room belongs to an object.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function object()
    {
        return $this->belongsTo(Object::class);
    }

    /**
     * Room belongs to the category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Room has many photos.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function photos()
    {
        return $this->hasMany(RoomPhoto::class);
    }

    /**
     * A room has many reservations.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Get all rooms.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getAllRooms()
    {
        // Get only approved reservations
        $approvedReservations = function ($reservation) {
            return !is_null($reservation->approved_at);
        };

        // Only show start date and end date of the reservation
        $reservationsTransformer = function ($reservation) {
            return [
                'start' => $reservation->date_start->format('d/m/Y'),
                'end'   => $reservation->date_end->format('d/m/Y')
            ];
        };

        // Transform photos collection and only show photo URL
        $photoFilenameTransformer = function ($photo) {
            return ltrim(Storage::url('rooms/' . $photo->room_id . '/' . $photo->filename), '/');
        };

        // Transform room
        $roomTransformer = function ($room) use ($approvedReservations, $reservationsTransformer, $photoFilenameTransformer) {
            if ($room->isReserved()) {
                $daysFree = 0;
            } else {
                $daysFree = is_null($room->reserved_until) ?
                    Carbon::now()->diffInDays(Carbon::create(Carbon::now()->year, 5, 1)) :
                    abs($room->reserved_until->diffInDays(Carbon::now()));
            }

            return [
                'id'           => $room->id,
                'label'        => $room->label,
                'price'        => $room->price,
                'max_people'   => $room->max_people,
                'min_people'   => $room->min_people,
                'seaside'      => $room->seaside,
                'photos'       => $room->photos->transform($photoFilenameTransformer),
                'object'       => $room->object,
                'category'     => $room->category,
                'reservations' => $room->reservations->filter($approvedReservations)->transform($reservationsTransformer)->values(),
                'rating'       => rand(1, 5),
                'reserved'     => $room->isReserved(),
                'days_free'    => $daysFree
            ];
        };

        return static::all()
            ->transform($roomTransformer)
            ->sortByDesc('days_free')
            ->values();
    }

    /**
     * Return reserved_at column as a Carbon instance.
     *
     * @param $date
     * @return Carbon
     */
    public function getReservedAtAttribute($date)
    {
        return Carbon::parse($date);
    }

    /**
     * Return reserved_until column as a Carbon instance.
     *
     * @param $date
     * @return Carbon
     */
//    public function getReservedUntilAttribute($date)
//    {
//        return Carbon::parse($date);
//    }

    /**
     * Check if room is reserved right now.
     *
     * @return bool
     */
    public function isReserved()
    {
        $now = Carbon::now();

        return $this->reserved_at->lte($now) && $this->reserved_until->gte($now);
    }

    /**
     * Reserve a room.
     *
     * @param Carbon $date_start Starting date
     * @param Carbon $date_end   Ending date
     * @return bool
     */
    public function reserve(Carbon $date_start, Carbon $date_end)
    {
        return $this->update([
            'reserved_at'    => $date_start,
            'reserved_until' => $date_end,
        ]);
    }
}