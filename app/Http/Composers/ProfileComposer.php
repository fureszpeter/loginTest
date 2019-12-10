<?php

namespace App\Http\Composers;

use App\Domain\Service\PagePermissionResolver;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\View\View;

class ProfileComposer
{
    /**
     * @var PagePermissionResolver
     */
    private $pagePermissionResolver;

    public function __construct(PagePermissionResolver $pagePermissionResolver)
    {
        $this->pagePermissionResolver = $pagePermissionResolver;
    }

    public function compose(View $view)
    {
        $user = Sentinel::getUser();

        if (!$user) {
            return;
        }

        $view->with('routes', $this->pagePermissionResolver->resolve($user));
    }
}
