<?php

namespace Database\Factories\Admin;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class TenantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'cnpj'    => fake()->randomNumber(8),
            'name'    => fake()->name(),
            'url'     => fake()->unique()->domainName(),
            'email'   => fake()->unique()->email(),
            'plan_id' => '1'
        ];
    }
}
