<?php

namespace Database\Factories;

use App\Models\Resort;
use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Event::class;

    public function definition(): array
    {
        $start = $this->faker->dateTimeBetween('now', '+1 month');
        $end = (clone $start)->modify('+3 days');

        return [
            'resort_id' => Resort::inRandomOrder()->first()?->id ?? Resort::factory(),
            'name' => $this->faker->words(3, true),
            'image' => null,
            'discount_rate' => $this->faker->randomFloat(2, 0, 2),
            'description' => $this->faker->sentence,
            'start_date' => $start->format('Y-m-d'),
            'end_date' => $end->format('Y-m-d'),
        ];
    }
}
