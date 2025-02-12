<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class gascilynderTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase; // Reset the database after each test

    /** @test */
    public function it_should_return_all_gas_cylinders()
    {
        GasCylinder::factory()->count(3)->create();

        $response = $this->get(route('gascylinderview'));

        $response->assertStatus(200);
        $response->assertViewHas('gasCylinders');
    }

    /** @test */
    public function it_should_store_a_valid_gas_cylinder()
    {
        $data = [
            'name' => 'Test Gas',
            'description' => 'Test description',
            'size' => 10,
            'user_price' => 500.00,
            'organization_price' => 450.00,
            'isActive' => true,
        ];

        $response = $this->post(route('gascylinder.store'), $data);

        $response->assertRedirect(route('gascylinderview'));
        $this->assertDatabaseHas('gas_cylinders', ['name' => 'Test Gas']);
    }

    /** @test */
    public function it_should_fail_to_store_gas_cylinder_with_invalid_data()
    {
        $data = [
            'name' => '',
            'description' => '',
            'size' => 'invalid',
            'user_price' => null,
            'organization_price' => null,
            'isActive' => 'invalid'
        ];

        $response = $this->post(route('gascylinder.store'), $data);

        $response->assertSessionHasErrors(['name', 'description', 'size', 'user_price', 'organization_price']);
    }

    /** @test */
    public function it_should_return_a_gas_cylinder_for_edit()
    {
        $gasCylinder = GasCylinder::factory()->create();

        $response = $this->getJson(route('gascylinder.edit', $gasCylinder->id));

        $response->assertStatus(200)
            ->assertJson($gasCylinder->toArray());
    }

    /** @test */
    public function it_should_return_404_when_editing_non_existing_gas_cylinder()
    {
        $response = $this->getJson(route('gascylinder.edit', 999));

        $response->assertStatus(404);
    }

    /** @test */
    public function it_should_update_a_gas_cylinder()
    {
        $gasCylinder = GasCylinder::factory()->create();

        $updatedData = [
            'name' => 'Updated Gas',
            'description' => 'Updated description',
            'size' => 15,
            'user_price' => 600.00,
            'organization_price' => 550.00,
            'isActive' => false,
        ];

        $response = $this->put(route('gascylinder.update', $gasCylinder->id), $updatedData);

        $response->assertRedirect(route('gascylinderview'));
        $this->assertDatabaseHas('gas_cylinders', ['name' => 'Updated Gas']);
    }

    /** @test */
    public function it_should_fail_to_update_a_gas_cylinder_with_invalid_data()
    {
        $gasCylinder = GasCylinder::factory()->create();

        $invalidData = [
            'name' => '',
            'description' => '',
            'size' => 'invalid',
            'user_price' => null,
            'organization_price' => null,
            'isActive' => 'invalid'
        ];

        $response = $this->put(route('gascylinder.update', $gasCylinder->id), $invalidData);

        $response->assertSessionHasErrors(['name', 'description', 'size', 'user_price', 'organization_price']);
    }

    /** @test */
    public function it_should_delete_a_gas_cylinder()
    {
        $gasCylinder = GasCylinder::factory()->create();

        $response = $this->delete(route('gascylinder.destroy', $gasCylinder->id));

        $response->assertRedirect(route('gascylinderview'));
        $this->assertDatabaseMissing('gas_cylinders', ['id' => $gasCylinder->id]);
    }

    /** @test */
    public function it_should_return_404_when_deleting_non_existing_gas_cylinder()
    {
        $response = $this->delete(route('gascylinder.destroy', 999));

        $response->assertStatus(404);
    }
}