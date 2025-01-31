<?php

namespace Database\Seeders;

use App\Models\GasCylinder;
use App\Models\Outlet;
use App\Models\OutletToken;
use App\Consts\UserRoleConst;

use Illuminate\Database\Seeder;

class GasCylinderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cylinders = [
            [
                'name' => 'LPG Cylinder 2.5kg',
                'description' => 'Small LPG cylinder for residential use',
                'size' => 2.5,
                'user_price' => 1500.00, // Example normal price
                'organization_price' => 1400.00, // Discounted price
                'isActive' => true,
            ],
            [
                'name' => 'LPG Cylinder 5kg',
                'description' => 'Medium LPG cylinder for residential use',
                'size' => 5.0,
                'user_price' => 3000.00,
                'organization_price' => 2800.00,
                'isActive' => true,
            ],
            [
                'name' => 'LPG Cylinder 12.56kg',
                'description' => 'Standard 12.56kg LPG cylinder for commercial use',
                'size' => 12.56,
                'user_price' => 7500.00,
                'organization_price' => 7200.00,
                'isActive' => true,
            ],
            [
                'name' => 'LPG Cylinder 15kg',
                'description' => 'Large LPG cylinder for industrial use',
                'size' => 15.0,
                'user_price' => 9000.00,
                'organization_price' => 8700.00,
                'isActive' => true, 
            ],
        ];
        $outlets = Outlet::all();
        foreach ($cylinders as $cylinder) {
            $cylinder = GasCylinder::create($cylinder);


            
        }
    }
}
