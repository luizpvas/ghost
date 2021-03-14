<?php

namespace App\Models\User;

trait TwoFactorAuthentication
{
    /**
     * Checks if the user has 2fa enabled.
     * 
     * @return boolean
     */
    function hasTwoFactorAuthentication()
    {
        return $this->two_factor_authentication != 'disabled';
    }
}
