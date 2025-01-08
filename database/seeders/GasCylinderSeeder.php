<?php

namespace Database\Seeders;

use App\Models\GasCylinder;
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

        foreach ($cylinders as $cylinder) {
            GasCylinder::create($cylinder);
        }
    }
}
