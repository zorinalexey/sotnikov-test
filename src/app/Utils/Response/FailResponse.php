<?php

namespace App\Utils\Response;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;

final class FailResponse extends JsonResponse
{
    public function __construct(array $data, int $code, int $status = 500, array $headers = [])
    {
        $body = [
            'data' => Arr::pull($data, 'data', []),
            'message' => Arr::pull($data, 'message', null),
            'code' => $code,
            'error' => true,
            'success' => false,
            ...$data,
        ];

        parent::__construct($body, $status, $headers);
    }
}
