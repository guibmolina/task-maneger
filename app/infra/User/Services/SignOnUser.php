<?php

declare(strict_types=1);

namespace Infra\User\Services;

use App\Models\User;
use Domain\User\Entities\UserEntity;
use Domain\User\Exceptions\FailedToSignOnUserException;
use Domain\User\Services\SignOnUser as BaseSignOnUser;
use Illuminate\Support\Facades\Auth;

class SignOnUser implements BaseSignOnUser
{
    public function signOn(UserEntity $userEntity): UserEntity
    {
        $user = User::where('email', $userEntity->email())->firstOrFail();

        $token = auth()->login($user);
   
        if(!Auth::check()) {
            throw new FailedToSignOnUserException();
        }

        return $this->mapUserEntityDomain($user, $token);
    }

    private function mapUserEntityDomain(User $user, $token): UserEntity
    {
        return new UserEntity(
            $user->id,
            $user->name,
            $user->email,
            $user->password,
            $token
        );
    }
}