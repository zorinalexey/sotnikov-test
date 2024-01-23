<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\ToDoList\CreateRequest;
use App\Http\Requests\Api\V1\ToDoList\FilterRequest;
use App\Http\Requests\Api\V1\ToDoList\UpdateRequest;
use App\Http\Resources\Api\General\PaginatorMetaResource;
use App\Http\Resources\Api\V1\TaskResource;
use App\Services\Task\TaskServiceInterface;
use App\Utils\Response\FailResponse;
use App\Utils\Response\SuccessResponse;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;

final class TaskController extends ApiV1Controller
{
    public function __construct(
        private readonly TaskServiceInterface $service
    ) {

    }

    public function index(FilterRequest $request): JsonResponse
    {
        try {
            $tasks = $this->service->list($request->validated());
            $data['data'] = TaskResource::collection($tasks);

            if ($tasks instanceof LengthAwarePaginator) {
                $data['paginate'] = PaginatorMetaResource::make($tasks);
            }

            return new SuccessResponse($data);
        } catch (Exception $exception) {
            $code = $exception->getCode();

            return new FailResponse([
                'message' => $exception->getMessage(),
                'data' => $exception->getTrace(),
            ], $code, $code);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request): JsonResponse
    {
        try {
            $task = $this->service->create($request->validated());

            return new SuccessResponse([
                'data' => TaskResource::make($task),
            ]);
        } catch (Exception $exception) {
            return new FailResponse([
                'message' => $exception->getMessage(),
                'data' => $exception->getTrace(),
            ], $exception->getCode(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string|int $id): JsonResponse
    {
        try {
            $task = $this->service->view($id);

            return new SuccessResponse([
                'data' => TaskResource::make($task),
            ]);
        } catch (Exception $exception) {
            return new FailResponse([
                'message' => $exception->getMessage(),
                'data' => $exception->getTrace(),
            ], $exception->getCode(), $exception->getCode());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string|int $id): JsonResponse
    {
        try {
            $task = $this->service->update($request->validated(), $id);

            return new SuccessResponse([
                'data' => TaskResource::make($task),
            ]);
        } catch (Exception $exception) {
            return new FailResponse([
                'message' => $exception->getMessage(),
                'data' => $exception->getTrace(),
            ], $exception->getCode(), $exception->getCode());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $this->service->delete($id);

            return new SuccessResponse();
        } catch (Exception $exception) {
            return new FailResponse([
                'message' => $exception->getMessage(),
                'data' => $exception->getTrace(),
            ], $exception->getCode(), $exception->getCode());
        }
    }
}
