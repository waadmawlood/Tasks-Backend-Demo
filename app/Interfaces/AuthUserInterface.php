<?php

namespace App\Interfaces;

use App\Http\Requests\Auth\UpdateAvatar;
use App\Http\Requests\Auth\updateInforamtion;
use Waad\Repository\Interfaces\BaseInterface;

interface AuthUserInterface extends BaseInterface
{
    /**
     * Attempt user authentication and create a new JWT token.
     *
     * @param array $attempts
     * @return \Illuminate\Http\JsonResponse
     */
    public function login($attempts);

    /**
     * Register a User.
     *
     * @param array $data
     * @param bool $isArray
     * @return \Illuminate\Http\JsonResponse|array
     */
    public function register(array $data, bool $isArray = false);

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

    /**
     * Update Avatar
     *
     * @param UpdateAvatar $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateAvatar(UpdateAvatar $request);

    /**
     * Update Inforamtion
     *
     * @param updateInforamtion $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateInforamtion(updateInforamtion $request);

    /**
     * Update Last Active
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateLastActive();
}
