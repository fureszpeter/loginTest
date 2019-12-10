<?php

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Sentinel::registerAndActivate([
            'first_name' => 'John',
            'last_name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@test.local',
            'password' => '123',
        ]);

        Sentinel::findRoleBySlug('administrators')->users()->attach($admin);

        $editor = Sentinel::registerAndActivate([
            'first_name' => 'Elisabeth',
            'last_name' => 'Editor',
            'username' => 'editor',
            'email' => 'editor@test.local',
            'password' => '123',
        ]);

        Sentinel::findRoleBySlug('editors')->users()->attach($editor);

        $user = Sentinel::registerAndActivate([
            'first_name' => 'Demo',
            'last_name' => 'User',
            'username' => 'user',
            'email' => 'user@test.local',
            'password' => '123',
        ]);

        Sentinel::findRoleBySlug('users')->users()->attach($user);
    }
}
