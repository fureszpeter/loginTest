<?php

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Sentinel::getRoleRepository()->createModel()->create([
            'name' => 'Administrators',
            'slug' => 'administrators',
            'permissions' => [
                'authenticated.admin' => true,
                'authenticated.editor' => true,
                'authenticated.user' => true,
            ],
        ]);

        Sentinel::getRoleRepository()->createModel()->create([
            'name' => 'Content editors',
            'slug' => 'editors',
            'permissions' => [
                'authenticated.editor' => true,
            ],
        ]);

        Sentinel::getRoleRepository()->createModel()->create([
            'name' => 'Users',
            'slug' => 'users',
            'permissions' => [
                'authenticated.user' => true,
            ],
        ]);
    }
}
