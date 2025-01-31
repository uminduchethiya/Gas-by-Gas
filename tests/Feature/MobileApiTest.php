<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MobileApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_with_valid_credentials_and_active_user()
    {
        $user = User::factory()->create([
            'email' => 'user@example.com',
            'password' => Hash::make('password123'),
            'status' => 'active',
            'role_id' => UserRoleConst::USER,
        ]);

        $response = $this->post('/login', [
            'email' => 'user@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_login_fails_with_inactive_user()
    {
        $user = User::factory()->create([
            'email' => 'inactive@example.com',
            'password' => Hash::make('password123'),
            'status' => 'deactive',
        ]);

        $response = $this->post('/login', [
            'email' => 'inactive@example.com',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors(['email' => 'Your account is not active. Please contact the admin.']);
        $this->assertGuest();
    }

    public function test_login_fails_with_invalid_credentials()
    {
        $response = $this->post('/login', [
            'email' => 'wrong@example.com',
            'password' => 'invalidpassword',
        ]);

        $response->assertSessionHasErrors(['email' => 'These credentials do not match our records.']);
        $this->assertGuest();
    }

    public function test_can_register_a_new_user()
    {
        $response = $this->post('/register-by-admin', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'outlet' => 1,
        ]);

        $response->assertJson(['success' => 'Customer created successfully!']);
        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
    }

    public function test_admin_can_register_an_organization_with_verification_file()
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->create('verification.pdf', 100, 'application/pdf');

        $response = $this->post('/register-by-admin', [
            'name' => 'Org User',
            'email' => 'org@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'outlet' => 1,
            'is_organization' => true,
            'verification_file' => $file,
        ]);

        $response->assertJson(['success' => 'Customer created successfully!']);
        Storage::disk('public')->assertExists('verification_files/' . $file->hashName());
    }

    public function test_registration_fails_with_missing_required_fields()
    {
        $response = $this->post('/register-by-admin', []);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name', 'email', 'password', 'outlet']);
    }
}
