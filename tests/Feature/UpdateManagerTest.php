<?php

namespace Tests\Feature;

use App\Models\DeliveryPlan;
use App\Models\Stock;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class UpdateManagerTest extends TestCase
{
    use RefreshDatabase;

    public function testUpdateManagerSuccess()
    {
        $deliveryPlan = DeliveryPlan::factory()->create();

        $data = [
            'Status' => 'Delivered',
            'QuantityReceived' => 10,
            'Notes' => 'Delivered successfully',
        ];

        $response = $this->json('POST', '/api/delivery-plan/update/' . $deliveryPlan->id, $data);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => 'Delivery Plan updated successfully!',
        ]);

        $this->assertDatabaseHas('delivery_plans', [
            'id' => $deliveryPlan->id,
            'Status' => 'Delivered',
            'QuantityReceived' => 10,
            'Notes' => 'Delivered successfully',
        ]);

        $this->assertDatabaseHas('stocks', [
            'outlet_id' => $deliveryPlan->outlet_id,
            'gas_cylinder_id' => $deliveryPlan->cylinder_type_id,
            'quantity' => 10,
        ]);
    }

    public function testUpdateManagerDiscrepancyStatus()
    {
        $deliveryPlan = DeliveryPlan::factory()->create();

        $data = [
            'Status' => 'Discrepancy',
            'QuantityReceived' => 5,
            'Notes' => 'Received less than expected',
        ];

        $response = $this->json('POST', '/api/delivery-plan/update/' . $deliveryPlan->id, $data);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => 'Delivery Plan updated successfully!',
        ]);

        $this->assertDatabaseHas('delivery_plans', [
            'id' => $deliveryPlan->id,
            'Status' => 'Discrepancy',
            'QuantityReceived' => 5,
            'Notes' => 'Received less than expected',
        ]);

        $this->assertDatabaseMissing('stocks', [
            'outlet_id' => $deliveryPlan->outlet_id,
            'gas_cylinder_id' => $deliveryPlan->cylinder_type_id,
        ]);

        Mail::assertSent(DiscrepancyNotification::class, function ($mail) use ($deliveryPlan) {
            return $mail->hasTo('admin@example.com') && $mail->deliveryPlan->id === $deliveryPlan->id;
        });
    }

    public function testUpdateManagerValidationMissingStatus()
    {
        $deliveryPlan = DeliveryPlan::factory()->create();

        $data = [
            'QuantityReceived' => 10,
            'Notes' => 'Missing status',
        ];

        $response = $this->json('POST', '/api/delivery-plan/update/' . $deliveryPlan->id, $data);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['Status']);
    }

    public function testUpdateManagerValidationInvalidQuantityReceived()
    {
        $deliveryPlan = DeliveryPlan::factory()->create();

        $data = [
            'Status' => 'Delivered',
            'QuantityReceived' => -10,
            'Notes' => 'Invalid quantity',
        ];

        $response = $this->json('POST', '/api/delivery-plan/update/' . $deliveryPlan->id, $data);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['QuantityReceived']);
    }

    public function testUpdateManagerDatabaseRollbackOnError()
    {
        $deliveryPlan = DeliveryPlan::factory()->create();

        DB::shouldReceive('beginTransaction')->once();
        DB::shouldReceive('commit')->once();
        DB::shouldReceive('rollBack')->once();
        \Mockery::mock(DeliveryPlan::class)
            ->shouldReceive('save')
            ->andThrow(new \Exception('Database error'));

        $data = [
            'Status' => 'Delivered',
            'QuantityReceived' => 10,
            'Notes' => 'Database error simulation',
        ];

        $response = $this->json('POST', '/api/delivery-plan/update/' . $deliveryPlan->id, $data);

        $response->assertStatus(500);
        $response->assertJson([
            'error' => 'Database error',
        ]);
    }

    public function testUpdateManagerDeliveryPlanNotFound()
    {
        $data = [
            'Status' => 'Delivered',
            'QuantityReceived' => 10,
            'Notes' => 'Delivery plan not found',
        ];

        $response = $this->json('POST', '/api/delivery-plan/update/999999', $data);

        $response->assertStatus(404);
        $response->assertJson([
            'error' => 'Delivery Plan not found.',
        ]);
    }

    public function testUpdateManagerNoEmailSentWhenStatusIsNotDiscrepancy()
    {
        $deliveryPlan = DeliveryPlan::factory()->create();

        $data = [
            'Status' => 'Delivered',
            'QuantityReceived' => 10,
            'Notes' => 'Successfully delivered',
        ];

        $response = $this->json('POST', '/api/delivery-plan/update/' . $deliveryPlan->id, $data);

        Mail::assertNotSent(DiscrepancyNotification::class);
    }

    public function testUpdateManagerValidQuantityReceivedDeliveredStatus()
    {
        $deliveryPlan = DeliveryPlan::factory()->create();

        $data = [
            'Status' => 'Delivered',
            'QuantityReceived' => 15,
            'Notes' => 'Full delivery received',
        ];

        $response = $this->json('POST', '/api/delivery-plan/update/' . $deliveryPlan->id, $data);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => 'Delivery Plan updated successfully!',
        ]);

        $this->assertDatabaseHas('stocks', [
            'outlet_id' => $deliveryPlan->outlet_id,
            'gas_cylinder_id' => $deliveryPlan->cylinder_type_id,
            'quantity' => 15,
        ]);
    }
}
