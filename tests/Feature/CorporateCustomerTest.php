<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserRole;

use App\Mail\CoparateCustomerAproval;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Consts\UserRoleConst;


class CorporateCustomerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test successful customer status update and email send.
     *
     * @return void
     */
    public function test_update_corporate_customer_status()
    {


        $manager = User::factory()->create([
            'role_id' => UserRoleConst::MANAGER,
        ]);

        $this->actingAs($manager);
        $user = User::factory()->create();
        dd($user);
        Mail::fake();

        $response = $this->postJson(route('manager.CoparateCustomers.updateCopareateCustomerStatus', $user->id));

        $response->assertStatus(200)
            ->assertJson(['success' => 'Customer status updated successfully!']);

        $user->refresh();

        $this->assertEquals('active', $user->status);

        Mail::assertSent(CoparateCustomerAproval::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }


    /**
     * Test failure when user is not found.
     *
     * @return void
     */
    public function test_user_not_found()
    {
        // Call the API endpoint with a non-existent user ID
        $response = $this->postJson(route('manager.CoparateCustomers.updateCopareateCustomerStatus', 999));

        // Assert the response status and error message
        $response->assertStatus(500)
            ->assertJson(['error' => 'Failed to update customer status']);
    }
}
