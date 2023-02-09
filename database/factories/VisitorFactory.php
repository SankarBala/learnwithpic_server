<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Stevebauman\Location\Facades\Location;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Visitor>
 */
class VisitorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $ip = fake()->ipv4();
        return [
            'ip' => $ip,
            'route' => fake()->url(),
            'user_agent' => fake()->userAgent(),
            'location' => json_encode(Location::get($ip)),
            'refferer' => fake()->url(),
            'created_at' => fake()->dateTimeBetween('-3 years', 'now')
        ];
    }
}
