<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class ProductsTest extends TestCase
{
    use RefreshDatabase;
    public function test_homepage_contains_empty_table(): void
    {
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@user.com',
            'password' => bcrypt('password')
        ]);

        $this->post('/login', [
            'email' => 'admin@user.com',
            'password' => 'password',
        ]);

        $response = $this->get('/products');
        $response->assertStatus(200);
        $response->assertSee(__('No products found'));
    }

    public function test_homepage_contains_non_empty_table(): void
    {
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@user.com',
            'password' => bcrypt('password')
        ]);

        $this->post('/login', [
            'email' => 'admin@user.com',
            'password' => 'password',
        ]);

        Product::factory()->create([
            'name' => 'Product Test',
            'price' => 123,
        ]);

        $response = $this->get('/products');
        $response->assertStatus(200);
        $response->assertDontSee(__('No products found'));
    }

}
