<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * Owner role
     */
    const OWNER = 2;

    /**
     * Admin role
     */
    const ADMIN = 1;

    /**
     * User role
     */
    const USER = 0;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['first_name', 'last_name', 'email', 'password', 'street', 'country', 'city', 'phone', 'zip', 'user_type', 'api_token'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'last_activity'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Automatically hash the password before persisting to the database.
     *
     * @param $value
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     * Returns API token for the user with email.
     *
     * @param string $email Email address
     * @return string
     */
    public static function getTokenFor(string $email)
    {
        return static::where('email', $email)->first()->api_token;
    }

    /**
     * Is owner or not?
     *
     * @return bool
     */
    public function isOwner()
    {
        return $this->user_type == static::OWNER;
    }

    /**
     * Get user's full name.
     *
     * @return string
     */
    public function fullName()
    {
        return $this->first_name . " " . $this->last_name;
    }

    /**
     * Show user role as a string.
     *
     * @return string
     */
    public function role()
    {
        if ($this->user_type == static::OWNER) {
            return "<span class=\"label label-danger\">Vlasnik</span>";
        } else if ($this->user_type == static::ADMIN) {
            return "<span class=\"label label-primary\">Administrator</span>";
        } else {
            return "<span class=\"label label-default\">Korisnik</span>";
        }
    }

    /**
     * Get number of administrators.
     *
     * @return mixed
     */
    public static function numberOfAdmins()
    {
        return static::where('user_type', static::ADMIN)->count();
    }

    /**
     * Check if owner account exists.
     *
     * @return bool
     */
    public static function ownerExists()
    {
        return static::where('user_type', static::OWNER)->count() == 1;
    }

    /**
     * Create new admin account.
     *
     * @param array $attributes Attributes
     * @return static
     */
    public static function createAdmin(array $attributes)
    {
        $attributes['user_type'] = static::ADMIN;
        $attributes['api_token'] = generate_token();

        return static::create($attributes);
    }

    /**
     * Create new user account.
     *
     * @param array $attributes Attributes
     * @return static
     */
    public static function createUser(array $attributes)
    {
        $attributes['user_type'] = static::USER;
        $attributes['api_token'] = generate_token();

        return static::create($attributes);
    }

    /**
     * Create the owner account.
     *
     * @param array $attributes Attributes
     * @return static
     */
    public static function createOwner(array $attributes)
    {
        if (static::ownerExists()) {
            return null;
        }

        $attributes['user_type'] = static::OWNER;
        $attributes['api_token'] = generate_token();

        return static::create($attributes);
    }
}
