<?php

namespace App\Utils\Response;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;

final class SuccessResponse extends JsonResponse
{
    public function __construct(array $data = [], int $status = 200, array $headers = [])
    {
        $body = [
            'data' => Arr::pull($data, 'data'),
            'message' => Arr::pull($data, 'message', 'Ok'),
            'code' => 0,
            'error' => false,
            'success' => true,
            ...$data,
        ];

        parent::__construct($body, $status, $headers);
    }
}
