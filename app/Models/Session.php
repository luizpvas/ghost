<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Session extends ApplicationModel
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
            return self::createInPendingState($user);
        } else {
            return self::create([
                'user_id' => $user->id,
                'status' => 'active'
            ]);
        }
    }

    /**
     * Creates a session in pending state.
     * 
     * @param  User $user
     * @return self
     */
    static function createInPendingState(User $user)
    {
        return self::create([
            'user_id' => $user->id,
            'status' => 'waiting_confirmation_code',
            'confirmation_code' => Str::random(5)
        ]);
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

    /**
     * Updates the status to 'active'.
     * 
     * @return void
     */
    function activate()
    {
        return $this->update(['status' => 'active']);
    }

    /**
     * A session belongs to a user.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    function user()
    {
        return $this->belongsTo(User::class);
    }
}
