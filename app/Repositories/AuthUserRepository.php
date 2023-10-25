<?php

namespace App\Repositories;

use App\Http\Requests\Auth\UpdateAvatar;
use App\Http\Requests\Auth\updateInforamtion;
use App\Interfaces\AuthUserInterface;
use App\Models\User;
use Carbon\Carbon;
use Waad\Repository\Repositories\BaseRepository;

class AuthUserRepository extends BaseRepository implements AuthUserInterface
{
    const GUARD = 'user';

    public function __construct()
    {
        $this->model = new User();
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
     * Register a User.
     *
     * @param array $data
     * @param bool $isArray
     * @return \Illuminate\Http\JsonResponse|array
     */
    public function register(array $data, bool $isArray = false)
    {
        $user = $this->storeObject($data);

        return $this->createNewToken(auth(self::GUARD)->login($user), $isArray);
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
        return $this->createNewToken(auth(self::GUARD)->refresh());
    }

    /**
     * Get the authenticated User.
     *
     * @return array
     */
    public function userProfile()
    {
        $user = auth(self::GUARD)->user();
        $data = [
            'user' => $user,
            'permissions' => $user->getAllPermissions()->where('guard_name', self::GUARD)->values(),
            'expiration' => $this->getExpiration(),
        ];

        return $data;
    }

    /**
     * Update Avatar
     *
     * @param UpdateAvatar $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateAvatar(UpdateAvatar $request)
    {
        $user = auth(self::GUARD)->user();
        if ($request->hasFile('avatar')) {
            $user->addMedia($request->file('avatar'))->upload();
        }

        return $this->jsonResponce('Avatar updated successfully', $user, 201);
    }

    /**
     * Update Inforamtion
     *
     * @param updateInforamtion $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateInforamtion(updateInforamtion $request)
    {
        $user = auth(self::GUARD)->user();
        $user->update($request->validated());

        return $this->jsonResponce(status: 204);
    }

    /**
     * Update Last Active
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateLastActive()
    {
        $user = auth(self::GUARD)->user();
        $user->update(['last_active' => now()]);

        return $this->jsonResponce(status: 204);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function createNewToken($token, $isArray = false)
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

        return $isArray ? $data : response()->json($data);
    }

    private function getExpiration()
    {
        $auth = auth(self::GUARD);
        return Carbon::createFromTimestamp($auth->payload()->toArray()['exp'])
            ->timezone($auth->user()->timezone ?? config('app.timezone'))
            ->toDateTimeString();
    }
}
