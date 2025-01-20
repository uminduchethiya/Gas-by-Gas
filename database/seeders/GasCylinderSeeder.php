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
                'isActive' => true,
            ],
            [
                'name' => 'LPG Cylinder 5kg',
                'description' => 'Medium LPG cylinder for residential use',
                'size' => 5.0,
                'isActive' => true,
            ],
            [
                'name' => 'LPG Cylinder 12.56kg',
                'description' => 'Standard 12.56kg LPG cylinder for commercial use',
                'size' => 12.56,
                'isActive' => true,
            ],
            [
                'name' => 'LPG Cylinder 15kg',
                'description' => 'Large LPG cylinder for industrial use',
                'size' => 15.0,
                'isActive' => true, 
            ],
        ];
        $outlets = Outlet::all();
        foreach ($cylinders as $cylinder) {
            $cylinder = GasCylinder::create($cylinder);


            foreach ($outlets as $outlet) {
                OutletToken::create([
                    'outlet_id' => $outlet->id,
                    'cylinder_type_id' => $cylinder->id,
                    'maxTokens' => config('tokens.DEFAULT_TOKEN_LIMIT', 100), 
                    'currentTokens' =>config('tokens.DEFAULT_TOKEN_LIMIT', 100),
                ]);
            }
        }
    }
}
