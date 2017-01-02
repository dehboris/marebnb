<?php

namespace App\Events\Users;

use App\User;
use Illuminate\Queue\SerializesModels;

class UserWasRegistered
{
    use SerializesModels;

    /**
     * Registered user model instance.
     *
     * @var User
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
