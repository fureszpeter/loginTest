<?php

namespace App\Domain;

use Cartalyst\Sentinel\Checkpoints\ThrottleCheckpoint;
use Cartalyst\Sentinel\Throttling\ThrottleRepositoryInterface;
use Cartalyst\Sentinel\Users\UserInterface;
use Illuminate\Http\Request;

class CaptchaCheckpoint extends ThrottleCheckpoint
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var ThrottleRepositoryInterface
     */
    private $throttleRepository;

    public function __construct(
        ThrottleRepositoryInterface $throttleRepository,
        Request $request
    ) {
        $this->throttleRepository = $throttleRepository;
        $this->request = $request;

        parent::__construct($throttleRepository, $request->getClientIp());
    }

    public function fail(UserInterface $user = null): bool
    {
        $this->checkThrottling('login', $user);

        return !(bool)$this->request->session()->get('captcha');
    }

    protected function throwException(string $message, string $type, int $delay): void
    {
        $this->request->session()->put('captcha', 1);
    }
}
