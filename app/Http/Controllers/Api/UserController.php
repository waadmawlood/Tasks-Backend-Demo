<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pagination;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Interfaces\UserInterface;
use App\Models\User;

class UserController extends Controller
{
    /**
     * UserRepository
     * @var UserInterface
     */
    private $UserRepository;

    /**
     * UserController::__construct
     *
     * @param UserInterface $userRepository
     */
    public function __construct(UserInterface $userRepository)
    {
        $this->authorizeResource(User::class, 'user');
        $this->UserRepository = $userRepository;
    }

    /**
     * Get List
     *
     * @param Pagination $pagination use `Pagination Or Unlimit`
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Pagination\LengthAwarePaginator
     */
    public function index(Pagination $pagination)
    {
        return $this->UserRepository->index($pagination);
    }

    /**
     * Store
     *
     * @param  \App\Http\Requests\User\StoreUserRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreUserRequest $request)
    {
        return $this->UserRepository->store($request->validated());
    }

    /**
     * Show
     *
     * @param  \App\Models\User  $user
     * @return User|null
     */
    public function show(User $user)
    {
        return $this->UserRepository->show($user);
    }

    /**
     * Update
     *
     * @param  \App\Http\Requests\User\UpdateUserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        return $this->UserRepository->update($request->validated(), $user);
    }

    /**
     * Soft Delete
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user)
    {
        return $this->UserRepository->destroy($user);
    }

    /**
     * Force Delete
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(User $user)
    {
        return $this->UserRepository->delete($user);
    }

    /**
     * Restore
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore(User $user)
    {
        return $this->UserRepository->restore($user);
    }
}
