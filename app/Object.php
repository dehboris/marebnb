<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Object
 *
 * @property int $id
 * @property string $label
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Room[] $rooms
 * @method static \Illuminate\Database\Query\Builder|\App\Object whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Object whereLabel($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Object whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Object whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Object extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['label'];

    /**
     * The attributes that are hidden from the public.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Object has many rooms.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}
