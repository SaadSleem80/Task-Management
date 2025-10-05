<?php

namespace App\Http\Controllers\Tasks;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\TaskCreateRequest;
use App\Http\Requests\Task\TaskUpdateRequest;
use App\Http\Resources\Tasks\TaskResource;
use App\Services\Task\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpFoundation\Response;

class TasksController extends Controller
{

    private $service;
    
    public function __construct(TaskService $service)
    {
        $this->service = $service;
    }

    /**
     * Get all tasks
     * 
     * @group Tasks
     * @authenticated
     * @param Request $request
     * @queryParam search string optional Search by title or description
     * @queryParam user_id int optional Search by user id
     * @queryParam parent_id int optional Search by parent id
     * @queryParam status string optional Search by status | pending, completed, cancelled
     * @queryParam paginate int optional Paginate results
     * @queryParam sort_by string optional Sort by column
     * @queryParam sort_type string optional Sort type
     * @queryParam start_date string optional Search by start date
     * @queryParam end_date string optional Search by end date
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $response = $this->service->getAll($request);
        
        if($response instanceof LengthAwarePaginator)
            return $this->paginatedResponse('success',  TaskResource::collection($response), Response::HTTP_OK);

        return $this->response('success', TaskResource::collection($response), Response::HTTP_OK);
    }

    /**
     * Create a new task
     * 
     * @group Tasks
     * @authenticated
     * @param TaskCreateRequest $request
     * @return JsonResponse
     */
    public function store(TaskCreateRequest $request): JsonResponse
    {
        $request = $request->validated();
        $response = $this->service->create($request);
        return $this->response('success', TaskResource::make($response), Response::HTTP_CREATED);
    }

    /**
     * Get a task by id
     * 
     * @group Tasks
     * @authenticated
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $response = $this->service->get($id);
        return $this->response('success', TaskResource::make($response), Response::HTTP_OK);
    }

    /**
     * Update a task by id
     * 
     * @group Tasks
     * @authenticated
     * @param int $id
     * @param TaskUpdateRequest $request
     * @return JsonResponse
     */
    public function update(int $id, TaskUpdateRequest $request): JsonResponse
    {
        $request = $request->validated();
        $response = $this->service->update($id, $request);
        return $this->response('success', TaskResource::make($response), Response::HTTP_ACCEPTED);
    }

    /**
     * Delete a task by id
     * 
     * @group Tasks
     * @authenticated
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->service->delete($id);
        return $this->response('success', null, Response::HTTP_OK);
    }
}
