<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Testing\TestResponse;


class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_redirects_to_products()
    {
        $this->createUser();

        $response = $this->loginUser();

        $response->assertStatus(302);
        $response->assertRedirect('products');
    }

    public function test_unauthenticated_user_cannot_access_product()
    {
        $response = $this->get('/products');

        $response->assertStatus(302);
        $response->assertRedirect('login');
    }

    private function createUser(): User
    {
        return User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@user.com',
            'password' => bcrypt('password')
        ]);
    }

    private function loginUser(): TestResponse
    {
        return $this->post('/login', [
            'email' => 'admin@user.com',
            'password' => 'password',
        ]);
    }
}
