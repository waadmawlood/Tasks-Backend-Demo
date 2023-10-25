<?php

namespace App\Interfaces;

use Waad\Repository\Interfaces\BaseInterface;

interface AuthAdminInterface extends BaseInterface
{
    /**
     * Attempt user authentication and create a new JWT token.
     *
     * @param array $attempts
     * @return \Illuminate\Http\JsonResponse
     */
    public function login($attempts);

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout();

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh();

    /**
     * Get the authenticated User.
     *
     * @return array
     */
    public function userProfile();
}
