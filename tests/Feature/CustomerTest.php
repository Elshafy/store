<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Export;
use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_api_customer()
    {
        $user = User::factory()->create();


        $customer = Customer::create(
            ['user_id' => $user->id]
        );

        $cusUser = $customer->user;
        Export::factory(20)->create([
            'item_id' => Item::first()->id,
            'customer_id' => $customer->id
        ]);

        Sanctum::actingAs($cusUser, ['*']);

        $response = $this->get('api/customer');
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => ['number' => 20]
            ]);
    }
    public function test_error_when_user_have_no_customer()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $response = $this->get('api/customer');
        $response->assertStatus(404)
            ->assertJson([
                'success' => false,
                'message' => 'you dont have a customer or data'
            ]);
    }
}