<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['object_id', 'category_id', 'label', 'price', 'max_people', 'min_people', 'seaside'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'last_reservation'];

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
}
