<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Session extends Model
{
    use HasFactory;

    /**
     * Disable mass assignment exception.
     * 
     * @var array
     */
    protected $guarded = [];

    /**
     * Creates a session for the given user.
     * 
     * @param  User $user
     * @return Session
     */
    static function for(User $user)
    {
        if ($user->hasTwoFactorAuthentication()) {
            return self::create([
                'user_id' => $user->id,
                'status' => 'waiting_confirmation_code',
                'confirmation_code' => Str::random(5)
            ]);
        } else {
            return self::create([
                'user_id' => $user->id,
                'status' => 'active'
            ]);
        }
    }

    /**
     * Checks if the session is active.
     * 
     * @return boolean
     */
    function isActive()
    {
        return $this->status == 'active';
    }
}
