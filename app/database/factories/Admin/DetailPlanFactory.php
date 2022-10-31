<?php

namespace Database\Factories\Admin;

use App\Models\Admin\Plan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin\DetailPlan>
 */
class DetailPlanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'plan_id' => Plan::first()->id,
            'name' => fake()->name(),
        ];
    }
}
