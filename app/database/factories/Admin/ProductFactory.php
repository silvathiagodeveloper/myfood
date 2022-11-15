<?php

namespace Database\Factories\Admin;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'      => fake()->name(),
            'url'       => fake()->unique()->domainName(),
            'price'     => fake()->randomFloat(2,10,50000),
            'description' => fake()->words(4,true),
            'tenant_id' => 1
        ];
    }
}
