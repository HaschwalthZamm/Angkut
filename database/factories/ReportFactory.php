<?php

namespace Database\Factories;

use App\Enums\ReportPriority;
use App\Enums\ReportStatus;
use App\Models\Region;
use App\Models\Report;
use App\Models\ReportCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Report>
 */
class ReportFactory extends Factory
{
    protected  = Report::class;

    public function definition(): array
    {
        return [
            'tracking_code' => 'ANGKUT-' . now()->format('ym') . '-' . Str::upper(Str::random(4)),
            'user_id' => User::factory(),
            'region_id' => Region::factory(),
            'report_category_id' => ReportCategory::factory(),
            'title' => fake()->sentence(4),
            'description' => fake()->paragraph(),
            'address' => fake()->address(),
            'latitude' => fake()->latitude(-3.05, -2.90),
            'longitude' => fake()->longitude(104.70, 104.85),
            'status' => ReportStatus::Pending,
            'priority' => ReportPriority::Medium,
        ];
    }

    public function guest(): static
    {
        return ->state(fn () => [
            'user_id' => null,
            'guest_name' => fake()->name(),
            'guest_phone' => '08' . fake()->numerify('##########'),
            'guest_token' => Str::random(32),
        ]);
    }
}
