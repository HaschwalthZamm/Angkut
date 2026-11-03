<?php

namespace Database\Factories;

use App\Enums\TeamStatus;
use App\Models\Region;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Team>
 */
class TeamFactory extends Factory
{
    protected  = Team::class;

    public function definition(): array
    {
        return [
            'name' => 'Tim ' . fake()->company(),
            'region_id' => Region::factory(),
            'status' => TeamStatus::Active,
            'description' => fake()->sentence(),
        ];
    }
}
