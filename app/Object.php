<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
