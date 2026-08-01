<?php

namespace Database\Factories;

use App\Models\Model;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Model>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'status' => fake()->randomElement(['draft', 'in_progress', 'done']),
            'due_date' => fake()->dateTimeBetween('now', '+1 year'),
            'project_id' => Project::factory(),
        ];
    }
}
