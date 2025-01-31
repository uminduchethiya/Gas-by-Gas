<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminStoreTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_store_outlet_successfully()
    {
        Mail::fake();

        $branch = \App\Models\Branch::factory()->create();
        $data = [
            'branch_id' => $branch->id,
            'Name' => 'Test Outlet',
            'Address' => '123 Test Street',
            'ContactNumber' => '0712345678',
            'ManagerName' => 'John Doe',
            'ManagerAddress' => '456 Manager Road',
            'nic' => '200012345678',
            'ManagerContactNumber' => '0723456789',
            'Email' => 'manager@example.com',
            'isActive' => 'Active',
        ];

        $response = $this->postJson(route('admin.store'), $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('outlets', ['name' => 'Test Outlet']);
        $this->assertDatabaseHas('users', ['email' => 'manager@example.com']);
    }

    public function test_store_outlet_fails_with_missing_fields()
    {
        $response = $this->postJson(route('admin.store'), []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['branch_id', 'Name', 'Address', 'ContactNumber', 'ManagerName', 'nic']);
    }

    public function test_store_outlet_fails_with_invalid_nic()
    {
        $branch = \App\Models\Branch::factory()->create();
        $data = [
            'branch_id' => $branch->id,
            'Name' => 'Test Outlet',
            'Address' => '123 Test Street',
            'ContactNumber' => '0712345678',
            'ManagerName' => 'John Doe',
            'ManagerAddress' => '456 Manager Road',
            'nic' => 'invalidNIC',
            'ManagerContactNumber' => '0723456789',
            'Email' => 'manager@example.com',
            'isActive' => 'Active',
        ];

        $response = $this->postJson(route('admin.store'), $data);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['nic']);
    }

    public function test_store_outlet_fails_with_duplicate_email()
    {
        User::factory()->create(['email' => 'manager@example.com']);

        $branch = \App\Models\Branch::factory()->create();
        $data = [
            'branch_id' => $branch->id,
            'Name' => 'Test Outlet',
            'Address' => '123 Test Street',
            'ContactNumber' => '0712345678',
            'ManagerName' => 'John Doe',
            'ManagerAddress' => '456 Manager Road',
            'nic' => '200012345678',
            'ManagerContactNumber' => '0723456789',
            'Email' => 'manager@example.com',
            'isActive' => 'Active',
        ];

        $response = $this->postJson(route('admin.store'), $data);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['Email']);
    }


    public function it_creates_delivery_plan_and_updates_outlet_token()
    {
        $outlet = Outlet::factory()->create();
        $gasCylinder = GasCylinder::factory()->create();
        $outletToken = OutletToken::factory()->create([
            'outlet_id' => $outlet->id,
            'cylinder_type_id' => $gasCylinder->id,
            'maxTokens' => 10,
            'currentTokens' => 5,
        ]);

        $response = $this->postJson(route('delivery-plan.store'), [
            'DeliveryDate' => now()->toDateString(),
            'QuantityPlanned' => 5,
            'Status' => 'Planned',
            'OutletID' => $outlet->id,
            'gas_cylinder_id' => $gasCylinder->id,
        ]);

        $response->assertStatus(200)
            ->assertJson(['success' => 'DeliveryPlan created and OutletToken updated successfully!']);

        $this->assertDatabaseHas('delivery_plans', [
            'outlet_id' => $outlet->id,
            'cylinder_type_id' => $gasCylinder->id,
            'QuantityPlanned' => 5,
        ]);

        $this->assertDatabaseHas('outlet_tokens', [
            'outlet_id' => $outlet->id,
            'cylinder_type_id' => $gasCylinder->id,
            'maxTokens' => 15, // Updated
            'currentTokens' => 10, // Updated
        ]);
    }

    /** @test */
    public function it_fails_validation_when_required_fields_are_missing()
    {
        $response = $this->postJson(route('delivery-plan.store'), []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'DeliveryDate',
                'QuantityPlanned',
                'Status',
                'OutletID',
                'gas_cylinder_id',
            ]);
    }

    /** @test */
    public function it_fails_validation_if_delivery_date_is_in_past()
    {
        $outlet = Outlet::factory()->create();
        $gasCylinder = GasCylinder::factory()->create();

        $response = $this->postJson(route('delivery-plan.store'), [
            'DeliveryDate' => now()->subDay()->toDateString(), // Past date
            'QuantityPlanned' => 10,
            'Status' => 'Planned',
            'OutletID' => $outlet->id,
            'gas_cylinder_id' => $gasCylinder->id,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['DeliveryDate']);
    }

    /** @test */
    public function it_fails_validation_if_quantity_planned_is_zero_or_negative()
    {
        $outlet = Outlet::factory()->create();
        $gasCylinder = GasCylinder::factory()->create();

        $response = $this->postJson(route('delivery-plan.store'), [
            'DeliveryDate' => now()->toDateString(),
            'QuantityPlanned' => -5,
            'Status' => 'Planned',
            'OutletID' => $outlet->id,
            'gas_cylinder_id' => $gasCylinder->id,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['QuantityPlanned']);
    }

    /** @test */
    public function it_rolls_back_database_transaction_on_exception()
    {
        $outlet = Outlet::factory()->create();
        $gasCylinder = GasCylinder::factory()->create();

        DB::shouldReceive('beginTransaction')->once()->andThrow(new \Exception('Database Error'));

        $response = $this->postJson(route('delivery-plan.store'), [
            'DeliveryDate' => now()->toDateString(),
            'QuantityPlanned' => 10,
            'Status' => 'Planned',
            'OutletID' => $outlet->id,
            'gas_cylinder_id' => $gasCylinder->id,
        ]);

        $response->assertStatus(500)
            ->assertJson(['error' => 'Database Error']);

        $this->assertDatabaseMissing('delivery_plans', [
            'outlet_id' => $outlet->id,
            'cylinder_type_id' => $gasCylinder->id,
        ]);
    }
}
