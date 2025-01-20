<?php

namespace Database\Seeders;

use App\Models\User;
use App\Consts\UserRoleConst;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create an Admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt(config('app.ADMIN_DEFAULT_PASSWORD')),
            'role_id' => UserRoleConst::ADMIN,
            'branch_id' => 1,
            'address' => 'Admin Address',
            'nic' => '200123902538',
            'contact_number' => '1234567890',
            'is_organization' => false, // Default to false
            'verification_file' => null, // No file for seeded data
            'status' => 'active', // Set status as active by default for regular users
        ]);

      
        // Create a Manager user
        User::create([
            'name' => 'Manager User',
            'email' => 'manager@example.com',
            'password' => bcrypt(config('app.MANAGER_DEFAULT_PASSWORD')),
            'role_id' => UserRoleConst::MANAGER,
            'branch_id' => 1,
            'address' => 'Manager Address',
            'nic' => '200123902539',
            'contact_number' => '1234567891',
            'is_organization' => false, // Default to false
            'verification_file' => null, // No file for seeded data
            'status' => 'active', // Set status as active by default for regular users
        ]);

        // Create a Regular User
        User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => bcrypt(config('app.USER_DEFAULT_PASSWORD')),
            'role_id' => UserRoleConst::USER,
            'branch_id' => null,
            'address' => 'User Address',
            'nic' => '200123902536',
            'contact_number' => '1234567892',
            'is_organization' => false, // Default to false
            'verification_file' => null, // No file for seeded data
            'status' => 'active', // Set status as active by default for regular users
        ]);
    }
}
