<?php

namespace App\Domain\Service;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Cartalyst\Sentinel\Users\UserInterface;
use Illuminate\Routing\Router;

class PagePermissionResolver
{
    private $router;

    /**
     * //     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * @param UserInterface $user
     *
     * @return string[]
     */
    public function resolve(UserInterface $user): array
    {
        if (!Sentinel::getUser()) {
            return [];
        }

        $result = [];
        /**
         * @var \Illuminate\Routing\Route
         */
        foreach ($this->router->getRoutes() as $route) {
            if (!preg_match('/^authenticated(.*)/', $route->getName())) {
                continue;
            }

            if (!Sentinel::hasAccess($route->getName())) {
                continue;
            }

            $result[] = $route->getName();
        }

        return $result;
    }
}
