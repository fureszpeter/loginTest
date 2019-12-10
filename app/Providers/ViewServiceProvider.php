<?php

namespace App\Providers;

use App\Http\Composers\ProfileComposer;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\View;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        parent::boot();

        View::composer(['home', 'admin.home', 'editor.home', 'user.home'], ProfileComposer::class);
    }
}
