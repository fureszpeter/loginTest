<?php

namespace App\Domain;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Cartalyst\Sentinel\Users\UserInterface;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;

class SentinelGuard implements Guard
{
    public function check(): bool
    {
        return !$this->guest();
    }

    public function guest(): bool
    {
        return null === $this->user();
    }

    public function user(): ?UserInterface
    {
        return Sentinel::getUser();
    }

    public function id(): ?int
    {
        $user = $this->user();
        return $user ? $user->getUserId() : null;
    }

    public function validate(array $credentials = []): bool
    {
        return (bool) Sentinel::authenticate($credentials);
    }

    public function setUser(Authenticatable $user): void
    {
        Sentinel::forceAuthenticate($user);
    }
}
