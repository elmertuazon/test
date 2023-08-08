<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManageUsersTest extends TestCase
{
    /** @test */
    public function user_can_show_edit_page()
    {
        $this->signIn();
        $this->actingAs(auth()->user())
            ->get(route('user.edit'))
            ->assertStatus(200);
    }

    /** @test */
    public function user_can_be_updated()
    {
        $this->signIn();
        $attributes = [
            'name' => auth()->user()->name,
            'email' => auth()->user()->email
        ];
        
        $this->actingAs(auth()->user())
        ->put(route('user.update'), $attributes)
        ->assertStatus(302);
    }

    /** @test */
    public function user_can_update_password()
    {
        $this->signIn();
        $attributes = [
            'current_password' => 'password',
            'password' => 'password'
        ];
        
        $this->actingAs(auth()->user())
        ->put(route('user.update-password'), $attributes)
        ->assertStatus(302);
    }
}
