<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Export;
use App\Models\Import;
use App\Models\Supplier;
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

    public function test_api_customer()
    {
        $user = User::factory()->create();


        $customer = Customer::create(
            ['user_id' => $user->id]
        );

        $cusUser = $customer->user;
        Export::factory(20)->create([
            'item_id' => 1,
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
    public function test_api_supplier()
    {
        $user = User::factory()->create();


        $supplier = Supplier::create(
            ['user_id' => $user->id]
        );
        $supUser = $supplier->user;

        $imports = Import::factory(20)->create([
            'item_id' => 1,
            'supplier_id' => $supplier->id
        ]);

        // dd($imports);

        Sanctum::actingAs($supUser, ['*']);

        $response = $this->get('api/supplier');
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
    public function test_error_when_user_have_no_supplier()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $response = $this->get('api/supplier');
        $response->assertStatus(404)
            ->assertJson([
                'success' => false,
                'message' => 'you dont have a supplier or data'
            ]);
    }
}