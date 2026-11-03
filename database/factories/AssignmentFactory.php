<?php

namespace Database\Factories;

use App\Models\Assignment;
use App\Models\Report;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Assignment>
 */
class AssignmentFactory extends Factory
{
    protected  = Assignment::class;

    public function definition(): array
    {
        return [
            'report_id' => Report::factory(),
            'team_id' => Team::factory(),
            'assigned_by' => User::factory(),
            'notes' => fake()->sentence(),
            'assigned_at' => now(),
        ];
    }
}
