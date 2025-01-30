<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UserRole;
use App\Models\Outlet;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Consts\UserRoleConst;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
   
    public function definition(): array
    {
        $role = UserRole::create(['id' => UserRoleConst::USER, 'name' => 'User']);
        
        $outlet = Outlet::factory()->create();

        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'), 
            'address' => $this->faker->address(),
            'nic' => $this->faker->unique()->numerify('#########V'), // NIC Format
            'contact_number' => $this->faker->phoneNumber(),
            'role_id' => $role->id,
            'outlet_id' => $outlet->id, // Set a valid outlet
            'isActive' => true,
            'is_organization' => false, 
            'verification_file' => null, 
            'status' => 'active', // Or any valid status you're using
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Indicate that the user is an organization user.
     */
    public function asOrganization(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_organization' => true,
        ]);
    }
}
