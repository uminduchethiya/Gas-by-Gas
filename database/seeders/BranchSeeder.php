<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\User;
use App\Models\Outlet;


use Illuminate\Database\Seeder;
use App\Consts\UserRoleConst;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $districts = [
            ['name' => 'Colombo', 'province' => 'Western Province'],
            ['name' => 'Gampaha', 'province' => 'Western Province'],
            ['name' => 'Kalutara', 'province' => 'Western Province'],
            ['name' => 'Kandy', 'province' => 'Central Province'],
            ['name' => 'Matale', 'province' => 'Central Province'],
            ['name' => 'Nuwara Eliya', 'province' => 'Central Province'],
            ['name' => 'Galle', 'province' => 'Southern Province'],
            ['name' => 'Matara', 'province' => 'Southern Province'],
            ['name' => 'Hambantota', 'province' => 'Southern Province'],
            ['name' => 'Jaffna', 'province' => 'Northern Province'],
            ['name' => 'Kilinochchi', 'province' => 'Northern Province'],
            ['name' => 'Mannar', 'province' => 'Northern Province'],
            ['name' => 'Mullaitivu', 'province' => 'Northern Province'],
            ['name' => 'Vavuniya', 'province' => 'Northern Province'],
            ['name' => 'Batticaloa', 'province' => 'Eastern Province'],
            ['name' => 'Ampara', 'province' => 'Eastern Province'],
            ['name' => 'Trincomalee', 'province' => 'Eastern Province'],
            ['name' => 'Kurunegala', 'province' => 'North Western Province'],
            ['name' => 'Puttalam', 'province' => 'North Western Province'],
            ['name' => 'Anuradhapura', 'province' => 'North Central Province'],
            ['name' => 'Polonnaruwa', 'province' => 'North Central Province'],
            ['name' => 'Badulla', 'province' => 'Uva Province'],
            ['name' => 'Monaragala', 'province' => 'Uva Province'],
            ['name' => 'Ratnapura', 'province' => 'Sabaragamuwa Province'],
            ['name' => 'Kegalle', 'province' => 'Sabaragamuwa Province'],
        ];

        foreach ($districts as $district) {
            $branch =  Branch::create($district);


            // $user = User::create([
            //     'name' => $district['name'] . ' User',
            //     'email' =>  strtolower($district['name']) . '@example.com',
            //     'password' => bcrypt(config('app.MANAGER_DEFAULT_PASSWORD')),
            //     'role_id' => UserRoleConst::MANAGER,
            //     'branch_id' => $branch->id,  
            //     'address' => $district['province'],
            //     'contact_number' => '1234567890',
            //     'nic' => '123456428',
            // ]);

            // Outlet::create([
            //     'branch_id' => $branch->id,
            //     'UserID' => $user->id, 
            //     'Name' => $district['name'] . ' Outlet',
            //     'Address' => $district['name'] . ' Address',
            //     'ContactNumber' => '0712345678',
            //     'Email' => strtolower($district['name']) . '@outlet.com',
            //     'Latitude' => 6.9271, 
            //     'Longitude' => 79.8612, 
            //     'Status' => 'Active',
            // ]);
        }
        
    }

    
}
