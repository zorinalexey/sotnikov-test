<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

final class AuthResource extends JsonResource
{
    private const LOCAL_AUTH = 'auth-token';

    public function toArray($request): array
    {
        return [
            'user' => AuthUserResource::make($this),
            'token' => $this->createToken(self::LOCAL_AUTH)->plainTextToken,
        ];
    }
}
