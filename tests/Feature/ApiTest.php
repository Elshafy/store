<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ApiTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    public function test_api_customer()
    {
        $user = User::first();
        Sanctum::actingAs($user, ['*']);

        $response = $this->get('api/customer/1');
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);
    }
    public function test_api_supplier()
    {
        $user = User::first();
        Sanctum::actingAs($user, ['*']);

        $response = $this->get('api/supplier/1');
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);
    }
}