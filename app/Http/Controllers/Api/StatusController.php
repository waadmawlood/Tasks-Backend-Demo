<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Status\StoreStatusRequest;
use App\Http\Requests\Status\UpdateStatusRequest;
use App\Http\Requests\Unlimit;
use App\Interfaces\StatusInterface;
use App\Models\Status;
use App\Models\Workspace;

class StatusController extends Controller
{
    /**
     * StatusRepository
     * @var StatusInterface
     */
    private $StatusRepository;

    /**
     * StatusController::__construct
     *
     * @param StatusInterface $statusRepository
     */
    public function __construct(StatusInterface $statusRepository)
    {
        $this->authorizeResource(Status::class, 'status');
        $this->StatusRepository = $statusRepository;
    }

    /**
     * Get List
     *
     * @param Unlimit $pagination use `Pagination Or Unlimit`
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Pagination\LengthAwarePaginator
     */
    public function index(Unlimit $request, Workspace $workspace)
    {
        // $workspace = Workspace::findOrFail(getPermissionsTeamId());
        return $this->StatusRepository->index($request, $workspace);
    }

    /**
     * Store
     *
     * @param  \App\Http\Requests\Status\StoreStatusRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreStatusRequest $request)
    {
        return $this->StatusRepository->store($request->validated());
    }

    /**
     * Show
     *
     * @param  \App\Models\Status  $status
     * @return Status|null
     */
    public function show(Workspace $workspace, Status $status)
    {
        return $this->StatusRepository->show($status);
    }

    /**
     * Update
     *
     * @param  \App\Http\Requests\Status\UpdateStatusRequest  $request
     * @param  \App\Models\Status  $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateStatusRequest $request, Workspace $workspace, Status $status)
    {
        return $this->StatusRepository->update($request->validated(), $status);
    }

    /**
     * Soft Delete
     *
     * @param  \App\Models\Status  $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Workspace $workspace, Status $status)
    {
        return $this->StatusRepository->destroy($status);
    }

    /**
     * Force Delete
     *
     * @param  \App\Models\Status  $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Workspace $workspace, Status $status)
    {
        return $this->StatusRepository->delete($status);
    }

    /**
     * Restore
     *
     * @param  \App\Models\Status  $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore(Workspace $workspace, Status $status)
    {
        return $this->StatusRepository->restore($status);
    }
}
