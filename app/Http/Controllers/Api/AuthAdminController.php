<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthLogin;
use App\Interfaces\AuthAdminInterface;

class AuthAdminController extends Controller
{
    private $AuthRepository;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(AuthAdminInterface $authInterface)
    {
        $this->AuthRepository = $authInterface;
    }

    /**
     * Login Admin
     * @unauthenticated
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(AuthLogin $authLogin)
    {
        return $this->AuthRepository->login($authLogin->validated());
    }


    /**
     * Logout Admin
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        return $this->AuthRepository->logout();
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->AuthRepository->refresh();
    }

    /**
     * Get Me Admin.
     *
     * @return array
     */
    public function userProfile()
    {
        return $this->AuthRepository->userProfile();
    }
}
