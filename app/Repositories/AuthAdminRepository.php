<?php

namespace App\Repositories;

use App\Interfaces\AuthAdminInterface;
use App\Models\Admin;
use Carbon\Carbon;
use Waad\Repository\Repositories\BaseRepository;

class AuthAdminRepository extends BaseRepository implements AuthAdminInterface
{
    const GUARD = 'admin';

    public function __construct()
    {
        $this->model = new Admin();
    }

    /**
     * Attempt user authentication and create a new JWT token.
     *
     * @param array $attempts
     * @return \Illuminate\Http\JsonResponse
     */
    public function login($attempts)
    {
        if (!$token = auth(self::GUARD)->attempt($attempts)) {
            return $this->jsonResponce('Unauthorized', null, 401, false);
        }

        return $this->createNewToken($token);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth(self::GUARD)->logout();

        return $this->jsonResponce('User successfully signed out');
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->createNewToken(auth(self::GUARD)->refresh(true, true));
    }

    /**
     * Get the authenticated User.
     *
     * @return array
     */
    public function userProfile()
    {
        $data = [
            'user' => auth(self::GUARD)->user(),
            'permissions' => auth(self::GUARD)->user()->getAllPermissions()->where('guard_name', self::GUARD)->values(),
            'expiration' => $this->getExpiration(),
        ];

        return $data;
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function createNewToken($token)
    {
        $userProfile = $this->userProfile();
        $data = [
            'token_type' => 'Bearer',
            'access_token' => $token,
            'expire_after_minutes' => auth(self::GUARD)->factory()->getTTL(),
            'expiration' => $this->getExpiration(),
            'user' => $userProfile['user'],
            'permissions' => $userProfile['permissions'] ?? [],
        ];

        return response()->json($data);
    }

    private function getExpiration()
    {
        return Carbon::createFromTimestamp(auth(self::GUARD)->payload()->toArray()['exp'])
        ->timezone(config('app.timezone'))
        ->toDateTimeString();
    }
}
