<?php

namespace App\Providers;

use App\Domain\CaptchaCheckpoint;
use App\Domain\SentinelGuard;
use Cartalyst\Sentinel\Throttling\IlluminateThrottleRepository;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot()
    {
        $this->registerPolicies();
        app('auth')->extend('sentinel', function () {
            return $this->app->make(SentinelGuard::class);
        });
    }

    public function register()
    {
        parent::register();

        $this->registerCaptchaCheckpoint();
    }

    public function provides()
    {
        return array_merge(
            parent::provides(),
            [
                'sentinel.checkpoint.captcha',
            ]
        );
    }

    protected function registerCaptchaCheckpoint()
    {
        $this->app->singleton('sentinel.checkpoint.captcha', function ($app) {
            return new CaptchaCheckpoint(
                $this->getCaptchaThrottling(),
                $app['request']
            );
        });
    }

    /**
     * Registers the throttle.
     */
    protected function getCaptchaThrottling(): IlluminateThrottleRepository
    {
        $model = app('config')->get('cartalyst.sentinel.throttling.model');

        $throttling = app('config')->get('cartalyst.sentinel.throttling');

        foreach (['global', 'ip', 'user'] as $type) {
            ${"{$type}Interval"} = $throttling[$type]['interval'];
            ${"{$type}Thresholds"} = $throttling[$type]['captchaThresholds'];
        }

        return new IlluminateThrottleRepository(
                $model,
                $globalInterval,
                $globalThresholds,
                $ipInterval,
                $ipThresholds,
                $userInterval,
                $userThresholds
            );
    }
}
