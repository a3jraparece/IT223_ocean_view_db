<?php

namespace Database\Seeders;

use App\Models\Resort;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ResortSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $initial_resorts = [
            [
                'name' => 'Punta Verde',
                'location' => 'Lobo - Malabrigo',
                'location_coordinates' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d495769.14625124517!2d120.91107645306354!3d13.88719842861475!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33bd215ae45c82c7%3A0x4bd2fb540cf7c003!2sPunta%20Verde%20Resort!5e0!3m2!1sen!2sph!4v1743441362225!5m2!1sen!2sph',
                'tax_rate' => '12',
                'status' => 'active'
            ],
            [
                'name' => 'Bruzy Resort',
                'location' => 'New Corella',
                'location_coordinates' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d253269.64483085732!2d125.54060155066222!3d7.315852589701174!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x32f953a38f5f6273%3A0x99b17e0bee4b0a9a!2sARRS%20Hotel%20%26%20Resort!5e0!3m2!1sen!2sph!4v1743442287773!5m2!1sen!2sph',
                'tax_rate' => '12',
                'status' => 'active'
            ],
        ];

        foreach ($initial_resorts as $resort) {
            Resort::create($resort);
        }
    }
}
