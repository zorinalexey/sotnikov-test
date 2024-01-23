<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\V1\LoginRequest;
use App\Http\Resources\Api\V1\AuthResource;
use App\Services\User\UserServiceInterface;
use App\Utils\Response\FailResponse;
use App\Utils\Response\SuccessResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class UsersController extends ApiController
{
    public function __construct(
        private readonly UserServiceInterface $service
    ) {

    }

    public function login(LoginRequest $request): JsonResponse
    {
        $user = $this->service->login($request->validated());

        if (! $user) {
            return new FailResponse([
                'message' => 'Не верный логин или пароль',
            ], 401, 401);
        }

        return new SuccessResponse([
            'data' => AuthResource::make($user),
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        if ($this->service->logout($request)) {
            return new SuccessResponse();
        }

        return new FailResponse([
            'message' => 'Не удалось совершить выход из приложения',
        ], 500, 500);
    }
}
