<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->streetName(),
            'description' => fake()->text(),
            'image' => fake()->imageUrl(),
            'is_active' => fake()->boolean(),
            'user_id' => \App\Models\User::all()->random()->id,
            'workspace_id' => \App\Models\Workspace::all()->random()->id,
        ];
    }
}
