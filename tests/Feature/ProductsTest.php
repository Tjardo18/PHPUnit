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
        $this->createUser();
        $this->loginUser();

        $response = $this->get('/products');
        $response->assertStatus(200);
        $response->assertSee(__('No products found'));
    }

    public function test_homepage_contains_non_empty_table(): void
    {
        $this->createUser();
        $this->loginUser();

        $product = Product::factory()->create([
            'name' => 'Product Test',
            'price' => 123,
        ]);

        $response = $this->get('/products');
        $response->assertStatus(200);
        $response->assertDontSee(__('No products found'));
        $response->assertSee('Product Test');
        $response->assertViewHas('products', function ($collection) use ($product) {
            return $collection->contains($product);
        });
    }

    public function test_paginated_products_table_doesnt_contain_11th_record()
    {
        $this->createUser();
        $this->loginUser();

        $products = Product::factory(11)->create();
        $lastProduct = $products->last();

        $response = $this->get('/products');

        $response->assertStatus(200);
        $response->assertViewHas('products', function ($collection) use ($lastProduct) {
            return !$collection->contains($lastProduct);
        });
    }

    private function createUser(): User
    {
        return User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@user.com',
            'password' => bcrypt('password')
        ]);
    }

    private function loginUser(): void
    {
        $this->post('/login', [
            'email' => 'admin@user.com',
            'password' => 'password',
        ]);
    }

}
