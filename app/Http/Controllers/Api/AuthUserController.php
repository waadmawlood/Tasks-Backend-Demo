<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthLogin;
use App\Http\Requests\Auth\AuthRegister;
use App\Http\Requests\Auth\UpdateAvatar;
use App\Http\Requests\Auth\updateInforamtion;
use App\Interfaces\AuthUserInterface;

class AuthUserController extends Controller
{
    private $AuthRepository;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(AuthUserInterface $authInterface)
    {
        $this->AuthRepository = $authInterface;
    }

    /**
     * Login User
     * @unauthenticated
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(AuthLogin $authLogin)
    {
        return $this->AuthRepository->login($authLogin->validated());
    }

    /**
     * Register User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(AuthRegister $authRegister)
    {
        return $this->AuthRepository->register($authRegister->validated());
    }


    /**
     * Logout User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        return $this->AuthRepository->logout();
    }

    /**
     * Refresh token User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->AuthRepository->refresh();
    }

    /**
     * Get Me User
     *
     * @return array
     */
    public function userProfile()
    {
        return $this->AuthRepository->userProfile();
    }

    /**
     * Update Avatar User
     *
     * @param UpdateAvatar $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateAvatar(UpdateAvatar $request)
    {
        return $this->AuthRepository->updateAvatar($request);
    }

    /**
     * Update Information User
     *
     * @param updateInforamtion $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateInforamtion(updateInforamtion $request)
    {
        return $this->AuthRepository->updateInforamtion($request);
    }

    /**
     * Update Last Active User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateLastActive()
    {
        return $this->AuthRepository->updateLastActive();
    }
}
