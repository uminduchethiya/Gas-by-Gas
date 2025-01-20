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

            $uniqueNic = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT);

                $user = User::create([
                    'name' => $district['name'] . ' Manager',
                    'email' => strtolower($district['name']) . '@example.com',
                    'password' => bcrypt(config('app.MANAGER_DEFAULT_PASSWORD')),
                    'role_id' => UserRoleConst::MANAGER,
                    'address' => $district['province'],
                    'contact_number' => '1234567890',
                    'nic' => $uniqueNic, // Assign the unique NIC value
                    'outlet_id' => null, // Temporarily null
                ]);
    
                // Step 3: Create Outlet
                $outlet = Outlet::create([
                    'branch_id' => $branch->id,
                    'user_id' => $user->id, // Assign the user to the outlet
                    'Name' => $district['name'] . ' Outlet',
                    'Address' => $district['name'] . ' Address',
                    'ContactNumber' => '0712345678',
                    'Email' => strtolower($district['name']) . '@outlet.com',
                    'Latitude' => null,
                    'Longitude' => null,
                   
                    'isActive' => true,
                ]);

            // Step 4: Assign outlet_id to the User
            $user->update([
                'outlet_id' => $outlet->id,
            ]);

            // Step 5: Assign user_id to the Outlet
            $outlet->update([
                'user_id' => $user->id,
            ]);

           
        }
        
    }

    
}
