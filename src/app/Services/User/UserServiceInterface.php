<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface UserServiceInterface
{
    public function login(array $data): User|Builder|Model|null;

    public function logout(Request $request): bool;
}
