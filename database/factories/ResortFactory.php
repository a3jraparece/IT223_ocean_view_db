<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Resort>
 */
class ResortFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company . ' Resort',
            'location' => $this->faker->city,
            'location_coordinates' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d495769.14625124517!2d120.91107645306354!3d13.88719842861475!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33bd215ae45c82c7%3A0x4bd2fb540cf7c003!2sPunta%20Verde%20Resort!5e0!3m2!1sen!2sph!4v1743441362225!5m2!1sen!2sph',
            'tax_rate' => $this->faker->numberBetween(1, 25),
            'status' => 'active',
        ];
    }
}
