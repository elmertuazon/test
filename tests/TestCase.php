<?php

namespace Tests;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase, WithFaker;

    protected function signIn($user = null)
    {
        $user = $user ?: User::factory()->create();
        $this->actingAs($user);

        return $this;
    }

    protected function createAdmin()
    {
        $this->signInAsAdmin();

        return $this;
    }

    protected function signInAsAdmin($user = null)
    {
        $user = $user ?: Admin::create([
            'name' => 'Admin',
            'email' => 'admin@blog.example',
            'password' => bcrypt('password'),
        ]);

        $this->actingAs($user, 'backpack');

        return $user;
    }
}
