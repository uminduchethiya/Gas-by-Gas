<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Outlet;
use App\Models\GasCylinder;
use App\Models\Token;
use App\Models\OutletToken;
use App\Models\TokenHistory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use App\Services\TwilioSmsService;

class TokenApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the token API with valid data.
     *
     * @return void
     */
    public function test_issue_token_success()
    {
        $user = User::factory()->create();
        $outlet = Outlet::factory()->create();
        $cylinder = GasCylinder::factory()->create();

        // Create outlet token for the specific cylinder type
        $outletToken = OutletToken::create([
            'outlet_id' => $outlet->id,
            'cylinder_type_id' => $cylinder->id,
            'currentTokens' => 10
        ]);

        $this->actingAs($user);  // Authenticate the user

        $response = $this->postJson(route('token.issueTokenAPI'), [
            'user_id' => $user->id,
            'outlet_id' => $outlet->id,
            'cylinder_type_id' => $cylinder->id,
            'cylinder_quantity' => 2,
        ]);

        $response->assertStatus(200)
            ->assertJson(['success' => true, 'message' => 'User token create successfully ']);

        // Assert that a token was created
        $this->assertDatabaseHas('tokens', [
            'user_id' => $user->id,
            'outlet_id' => $outlet->id,
            'cylinder_type_id' => $cylinder->id,
            'quantity' => 2,
            'status' => Token::STATUS_PENDING,
        ]);

        // Assert that the outlet tokens are decreased
        $outletToken->refresh();
        $this->assertEquals(8, $outletToken->currentTokens); // 10 - 2 = 8

        // Assert that a token history was created
        $this->assertDatabaseHas('token_histories', [
            'token_id' => Token::latest()->first()->id,
            'currentStatus' => Token::STATUS_PENDING,
            'updateStatus' => Token::STATUS_PENDING,
        ]);
    }

    /**
     * Test the token API when there are more than 2 active tokens.
     *
     * @return void
     */
    public function test_issue_token_max_active_tokens()
    {
        $user = User::factory()->create();
        $outlet = Outlet::factory()->create();
        $cylinder = GasCylinder::factory()->create();

        // Simulate 2 active tokens for the user
        Token::factory()->create(['user_id' => $user->id, 'status' => Token::STATUS_PENDING]);
        Token::factory()->create(['user_id' => $user->id, 'status' => Token::STATUS_SCHEDULED]);

        $this->actingAs($user);

        $response = $this->postJson(route('token.issueTokenAPI'), [
            'user_id' => $user->id,
            'outlet_id' => $outlet->id,
            'cylinder_type_id' => $cylinder->id,
            'cylinder_quantity' => 1,
        ]);

        $response->assertStatus(400)
            ->assertJson(['error' => 'You cannot have more than 2 active tokens.']);
    }

    /**
     * Test the token API with insufficient tokens at the branch.
     *
     * @return void
     */
    public function test_issue_token_insufficient_tokens()
    {
        $user = User::factory()->create();
        $outlet = Outlet::factory()->create();
        $cylinder = GasCylinder::factory()->create();

        // Create outlet token with insufficient tokens
        OutletToken::create([
            'outlet_id' => $outlet->id,
            'cylinder_type_id' => $cylinder->id,
            'currentTokens' => 1
        ]);

        $this->actingAs($user);

        $response = $this->postJson(route('token.issueTokenAPI'), [
            'user_id' => $user->id,
            'outlet_id' => $outlet->id,
            'cylinder_type_id' => $cylinder->id,
            'cylinder_quantity' => 2,
        ]);

        $response->assertStatus(400)
            ->assertJson(['error' => 'No tokens are available for this cylinder type at the selected branch.']);
    }

    /**
     * Test the token API with invalid user_id.
     *
     * @return void
     */
    public function test_issue_token_invalid_user()
    {
        $outlet = Outlet::factory()->create();
        $cylinder = GasCylinder::factory()->create();

        $response = $this->postJson(route('token.issueTokenAPI'), [
            'user_id' => 999, // Invalid user ID
            'outlet_id' => $outlet->id,
            'cylinder_type_id' => $cylinder->id,
            'cylinder_quantity' => 2,
        ]);

        $response->assertStatus(400)
            ->assertJson(['error' => 'The given data was invalid.']);
    }

    /**
     * Test the token API with missing required parameters.
     *
     * @return void
     */
    public function test_issue_token_missing_parameters()
    {
        $response = $this->postJson(route('token.issueTokenAPI'), []);

        $response->assertStatus(400)
            ->assertJson([
                'error' => [
                    'user_id' => ['The user id field is required.'],
                    'outlet_id' => ['The outlet id field is required.'],
                    'cylinder_type_id' => ['The cylinder type id field is required.'],
                ]
            ]);
    }

    /**
     * Test token API with an SMS service failure.
     *
     * @return void
     */
    public function test_issue_token_sms_failure()
    {
        $user = User::factory()->create();
        $outlet = Outlet::factory()->create();
        $cylinder = GasCylinder::factory()->create();
        $outletToken = OutletToken::create([
            'outlet_id' => $outlet->id,
            'cylinder_type_id' => $cylinder->id,
            'currentTokens' => 10
        ]);

        // Mock the SMS service failure
        $smsService = \Mockery::mock(TwilioSmsService::class);
        $smsService->shouldReceive('sendSms')->andReturn(false);

        $this->actingAs($user);

        $response = $this->postJson(route('token.issueTokenAPI'), [
            'user_id' => $user->id,
            'outlet_id' => $outlet->id,
            'cylinder_type_id' => $cylinder->id,
            'cylinder_quantity' => 1,
        ]);

        $response->assertStatus(500)
            ->assertJson(['success' => false, 'error' => 'Failed to create user to token.']);
    }

    public function testUpdateTokenStatusToComplete()
    {
        $user = User::factory()->create();
        $token = Token::factory()->create([
            'user_id' => $user->id,
            'status' => Token::STATUS_PENDING,
            'quantity' => 1,
        ]);

        $this->mock(TwilioSmsService::class, function ($mock) {
            $mock->shouldReceive('sendSms')->andReturn(['success' => true]);
        });

        $stock = Stock::factory()->create([
            'gas_cylinder_id' => $token->cylinder_type_id,
            'quantity' => 10,
        ]);

        $response = $this->putJson("/tokens/{$token->id}/update", [
            'status' => Token::STATUS_COMPLETE,
        ]);

        $stock->refresh();

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Token status updated successfully']);
        $this->assertEquals(9, $stock->quantity);  // Ensure stock is decremented.
    }

    /** @test */
    public function testCancelTokenWithoutReason()
    {
        $user = User::factory()->create();
        $token = Token::factory()->create([
            'user_id' => $user->id,
            'status' => Token::STATUS_PENDING,
        ]);

        $response = $this->putJson("/tokens/{$token->id}/update", [
            'status' => Token::STATUS_CANCELED,
            'reason' => '',
        ]);

        $response->assertStatus(422);
        $response->assertJson(['error' => 'A reason is required when canceling a token']);
    }

    /** @test */
    public function testNoStockAvailableForCylinderType()
    {
        $user = User::factory()->create();
        $token = Token::factory()->create([
            'user_id' => $user->id,
            'status' => Token::STATUS_PENDING,
        ]);

        $response = $this->putJson("/tokens/{$token->id}/update", [
            'status' => Token::STATUS_COMPLETE,
        ]);

        $response->assertStatus(404);
        $response->assertJson(['error' => 'No stock available for selected cylinder type']);
    }

    /** @test */
    public function testUserContactNumberNotFound()
    {
        $user = User::factory()->create(['contact_number' => null]);
        $token = Token::factory()->create([
            'user_id' => $user->id,
            'status' => Token::STATUS_PENDING,
        ]);

        $response = $this->putJson("/tokens/{$token->id}/update", [
            'status' => Token::STATUS_COMPLETE,
        ]);

        $response->assertStatus(404);
        $response->assertJson(['error' => 'User contact number not found']);
    }
    public function testAssignNewUserToTokenSuccess()
    {
        $user = User::factory()->create();
        $newUser = User::factory()->create();
        $token = Token::factory()->create(['user_id' => $user->id]);

        $response = $this->json('POST', '/api/token/assign', [
            'newUserId' => $newUser->id,
            'tokenId' => $token->id,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'User reassigned successfully and SMS notification sent.',
        ]);
        $this->assertEquals($newUser->id, $token->fresh()->user_id);

        $this->assertDatabaseHas('token_histories', [
            'token_id' => $token->id,
            'currentStatus' => $token->status,
            'updateStatus' => Token::STATUS_REASIGNED,
        ]);
    }
    public function testAssignNewUserToTokenExceededActiveTokens()
    {
        // Arrange: Create a new user with 2 active tokens
        $newUser = User::factory()->create();
        Token::factory()->create(['user_id' => $newUser->id, 'status' => Token::STATUS_PENDING]);
        Token::factory()->create(['user_id' => $newUser->id, 'status' => Token::STATUS_SCHEDULED]);

        // Create a new token
        $token = Token::factory()->create();

        $response = $this->json('POST', '/api/token/assign', [
            'newUserId' => $newUser->id,
            'tokenId' => $token->id,
        ]);

        $response->assertStatus(400);
        $response->assertJson([
            'error' => 'You cannot have more than 2 active tokens.',
        ]);
    }
    public function testAssignNewUserToTokenTransactionRollback()
    {
        $this->mock(Token::class, function ($mock) {
            $mock->shouldReceive('save')->andThrow(new \Exception('Database error'));
        });

        $user = User::factory()->create();
        $newUser = User::factory()->create();
        $token = Token::factory()->create(['user_id' => $user->id]);

        $response = $this->json('POST', '/api/token/assign', [
            'newUserId' => $newUser->id,
            'tokenId' => $token->id,
        ]);

        $response->assertStatus(500);
        $response->assertJson([
            'error' => 'Failed to reassign user to token.',
        ]);
    }

}
