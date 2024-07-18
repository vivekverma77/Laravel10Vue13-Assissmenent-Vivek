<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class LoginTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_login_successful()
    {
        $password = 'password';
        $user = User::factory()->create(['password' => bcrypt($password)]);

        $response = $this->postJson(route('login'), [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'user' => ['id', 'name', 'email'],
                     'token'
                 ]);
    }

    public function test_login_failed()
    {
        $user = User::factory()->create(['password' => bcrypt('password')]);

        $response = $this->postJson(route('login'), [
            'email' => $user->email,
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(422)
                 ->assertJsonStructure(['errors' => ['email']]);
    }
}
