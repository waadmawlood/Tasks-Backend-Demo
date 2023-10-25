<?php

namespace App\Helpers;

use Illuminate\Auth\AuthenticationException;

class Guard
{
    /**
     * Get of guard me
     *
     * @return string|null
     */
    public static function guardMe()
    {
        if (is_null(auth()->id()))
            return null;

        return auth()->getDefaultDriver();
    }

    /**
     * Get Class name Model from guard
     *
     * @param string $guard
     * @return \Illuminate\Database\Eloquent\Model|string
     */
    public static function guardClass(string $guard = 'user')
    {
        $provider = config('auth.guards.' . $guard . '.provider');
        $model = config('auth.providers.' . $provider . '.model');

        return $model;
    }

    /**
     * Get auth id
     *
     * @param string $guard
     * @return string
     * @throws AuthenticationException
     */
    public static function authId(string $guard = 'user')
    {
        try {
            $user = auth($guard)->user();

            if ($user) {
                return $user->id;
            } else {
                throw new AuthenticationException('Unauthenticated', [$guard], 401);
            }
        } catch (AuthenticationException $e) {
            throw $e;
        }
    }
}
