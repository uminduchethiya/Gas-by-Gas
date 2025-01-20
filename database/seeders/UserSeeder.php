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
            'contact_number' => '1234567890',
        ]);

      
        // Create a Regular User
        User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => bcrypt(config('app.USER_DEFAULT_PASSWORD')),
            'role_id' => UserRoleConst::USER,
            'branch_id' => null,
            'address' => 'User Address',
            'contact_number' => '1234567892',
        ]);

    }
}
