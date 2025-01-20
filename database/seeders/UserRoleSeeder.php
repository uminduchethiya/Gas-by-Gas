<?php

namespace Database\Seeders;

use App\Models\UserRole;
use App\Consts\UserRoleConst;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserRole::create(['id' => UserRoleConst::ADMIN, 'name' => 'Admin']);
        UserRole::create(['id' => UserRoleConst::MANAGER, 'name' => 'Manager']);
        UserRole::create(['id' => UserRoleConst::USER, 'name' => 'User']);
        UserRole::create(['id' => UserRoleConst::ORGANIZATION, 'name' => 'Organization']);
    }
}
