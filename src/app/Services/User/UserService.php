<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

final class UserService implements UserServiceInterface
{
    public function login(array $data): User|Builder|Model|null
    {
        $user = User::query()->where('email', $data['login'])->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            return null;
        }

        return $user;
    }

    public function logout(Request $request): bool
    {
        return (bool) $request->user()->currentAccessToken()->delete();
    }
}
