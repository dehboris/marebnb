<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * The attributes that are hidden from the public.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at'];
}
