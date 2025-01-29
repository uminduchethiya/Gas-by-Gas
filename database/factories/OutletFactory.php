<?php

namespace Database\Factories;

use App\Models\Outlet;
use App\Models\Branch;

use Illuminate\Database\Eloquent\Factories\Factory;

class OutletFactory extends Factory
{
    protected $model = Outlet::class;

    public function definition()
    {
        return [
            'branch_id' => Branch::factory(), // Generate a branch dynamically
            'user_id' => null, // Update if you have a UserFactory
            'name' => $this->faker->company,
            'address' => $this->faker->address,
            'ContactNumber' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'isActive' => true,
        ];
    }
}
