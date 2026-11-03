<?php

namespace Database\Factories;

use App\Models\Region;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Region>
 */
class RegionFactory extends Factory
{
    protected  = Region::class;

    public function definition(): array
    {
         = fake()->city();
        return [
            'code' => Str::upper(Str::slug()),
            'name' => ,
            'is_active' => true,
        ];
    }
}
