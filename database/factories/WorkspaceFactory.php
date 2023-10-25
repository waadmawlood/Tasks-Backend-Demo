<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Workspace>
 */
class WorkspaceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'description' => fake()->text(),
            'image' => fake()->imageUrl(),
            'is_active' => fake()->boolean(),
            'storage' => fake()->randomDigit(),
            'user_id' => \App\Models\User::all()->random()->id,
        ];
    }
}
