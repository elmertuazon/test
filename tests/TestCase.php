<?php

namespace Tests;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function signIn($user = null)
    {
        $user = $user ?: User::factory()->create();

        $this->actingAs($user);

        return $user;
    }

    protected function createAdmin()
    {
        Admin::create([
            'name' => 'Admin',
            'email' => 'admin@blog.example',
            'password' => bcrypt('password'),
        ]);
    }

    protected function signInAsAdmin($user = null)
    {
        $user = $user ?: Admin::create([
            'name' => 'Admin',
            'email' => 'admin@blog.example',
            'password' => bcrypt('password'),
        ]);

        $this->actingAs($user);

        return $user;
    }
}
