<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Outlet;
use App\Models\Branch;
use App\Models\UserRole;
use App\Consts\UserRoleConst;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

use Illuminate\Support\Facades\Storage;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase; // Ensure database is reset before each test

    // /** @test */
    public function it_registers_a_user_successfully()
    {
        $branch = Branch::factory()->create();

        $outlet = Outlet::factory()->create(['branch_id' => $branch->id]);

        $role = UserRole::create(['id' => UserRoleConst::USER, 'name' => 'User']);



        $response = $this->postJson(route('registerByAdmin.api'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'contact_number' => '1234567890',
            'address' => '123 Street',
            'nic' => '987654321V',
            'outlet' => $outlet->id, // Use the created outlet ID
        ]);

        $response->assertStatus(200)
            ->assertJson(['success' => 'Customer created successfully!']);

        $this->assertDatabaseHas('users', ['email' => 'john@example.com']);
    }

    // /** @test */
    public function it_fails_registration_due_to_validation_errors()
    {
        $response = $this->postJson(route('registerByAdmin.api'), [
            'name' => '',
            'email' => 'invalid-email',
            'password' => '123',
        ]);

        $response->assertStatus(422)
            ->assertJsonStructure(['errors']);
    }


    // /** @test */

    public function it_registers_an_organization_user_with_verification_file()
    {
        $branch = Branch::factory()->create();
        $outlet = Outlet::factory()->create(['branch_id' => $branch->id]);

        $role = UserRole::create(['id' => UserRoleConst::USER, 'name' => 'User']);

        Storage::fake('public');

        // Create a fake file
        $file = UploadedFile::fake()->create('document.pdf', 100);

        // Send the request with the file
        $response = $this->postJson(route('registerByAdmin.api'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'contact_number' => '1234567890',
            'address' => '123 Street',
            'nic' => '987654321V',
            'outlet' => $outlet->id,
            'is_organization' => true,
            'verification_file' => $file,
        ]);

        // Check the response

        // Assert the status and JSON response
        $response->assertStatus(200)
            ->assertJson(['success' => 'Customer created successfully!']);

        // Assert the database contains the user
        $this->assertDatabaseHas('users', ['email' => 'john@example.com', 'is_organization' => true]);

        // Check that the file was uploaded correctly
        Storage::disk('public')->assertExists('verification_files/document.pdf');
    }
    // /** @test */

    public function it_fails_to_register_a_user_with_duplicate_email()
    {
        $outlet = Outlet::factory()->create();
        User::factory()->create(['email' => 'john@example.com']);

        $response = $this->postJson(route('registerByAdmin.api'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'outlet' => $outlet->id, // Use the created outlet ID
        ]);

        // Assert that the response status is 422
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']); // Check for the email validation error
    }


     /** @test */
     public function it_updates_a_customer_successfully()
     {
         $outlet = Outlet::factory()->create();

         $user = User::factory()->create([
             'name' => 'Old Name',
             'email' => 'old@example.com',
         ]);

         $response = $this->postJson(route('updateCustomer.api'), [
             'id' => $user->id,
             'name' => 'New Name',
             'email' => 'new@example.com',
             'outlet' => $outlet->id // Use the created outlet ID
         ]);

         $response->assertStatus(200)
             ->assertJson(['success' => 'Customer updated successfully!']);

         $this->assertDatabaseHas('users', ['id' => $user->id, 'name' => 'New Name']);
     }

    // /** @test */
     public function it_fails_update_due_to_validation_errors()
     {
         $user = User::factory()->create();

         $response = $this->postJson(route('updateCustomer.api'), [
             'id' => $user->id,
             'name' => '',
             'email' => 'invalid-email',
         ]);

        $response->assertStatus(422)
             ->assertJsonStructure(['errors']);
     }

    // /** @test */
    // public function it_fails_update_due_to_duplicate_email()
    // {
    //     User::factory()->create(['email' => 'existing@example.com']);
    //     $user = User::factory()->create(['email' => 'unique@example.com']);

    //     $response = $this->postJson(route('updateCustomer.api'), [
    //         'id' => $user->id,
    //         'name' => 'Test',
    //         'email' => 'existing@example.com',
    //     ]);

    //     $response->assertStatus(422)
    //         ->assertJsonStructure(['errors']);
    // }

    // /** @test */
    // public function it_updates_a_user_with_new_password()
    // {
    //     $outlet = Outlet::factory()->create();

    //     $user = User::factory()->create([
    //         'password' => Hash::make('oldpassword'),
    //     ]);

    //     $response = $this->postJson(route('updateCustomer.api'), [
    //         'id' => $user->id,
    //         'name' => 'Updated Name',
    //         'email' => $user->email,
    //         'outlet' => $outlet->id,// Use the created outlet ID
    //         'password' => 'newpassword123',
    //     ]);

    //     $response->assertStatus(200)
    //         ->assertJson(['success' => 'Customer updated successfully!']);

    //     $this->assertTrue(Hash::check('newpassword123', $user->fresh()->password));
    // }
}
