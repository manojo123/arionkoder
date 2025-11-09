<?php

namespace Database\Factories;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
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
            'project_id' => Project::factory(),
            'user_id' => User::factory(),
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'priority' => fake()->randomElement(TaskPriority::cases())->value,
            'status' => fake()->randomElement(TaskStatus::cases())->value,
            'due_date' => fake()->date(),
            'created_by' => User::factory(),
            'modified_by' => User::factory(),
        ];
    }

    /**
     * Indicate that the task has low priority.
     */
    public function low(): static
    {
        return $this->state(fn (array $attributes) => [
            'priority' => TaskPriority::Low->value,
        ]);
    }

    /**
     * Indicate that the task has medium priority.
     */
    public function medium(): static
    {
        return $this->state(fn (array $attributes) => [
            'priority' => TaskPriority::Medium->value,
        ]);
    }

    /**
     * Indicate that the task has high priority.
     */
    public function high(): static
    {
        return $this->state(fn (array $attributes) => [
            'priority' => TaskPriority::High->value,
        ]);
    }

    /**
     * Indicate that the task has critical priority.
     */
    public function critical(): static
    {
        return $this->state(fn (array $attributes) => [
            'priority' => TaskPriority::Critical->value,
        ]);
    }

    /**
     * Indicate that the task is in backlog.
     */
    public function backlog(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => TaskStatus::Backlog->value,
        ]);
    }

    /**
     * Indicate that the task is to do.
     */
    public function toDo(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => TaskStatus::ToDo->value,
        ]);
    }

    /**
     * Indicate that the task is in progress.
     */
    public function inProgress(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => TaskStatus::InProgress->value,
        ]);
    }

    /**
     * Indicate that the task is in review.
     */
    public function review(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => TaskStatus::Review->value,
        ]);
    }

    /**
     * Indicate that the task is done.
     */
    public function done(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => TaskStatus::Done->value,
        ]);
    }

    /**
     * Indicate that the task is blocked.
     */
    public function blocked(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => TaskStatus::Blocked->value,
        ]);
    }
}
