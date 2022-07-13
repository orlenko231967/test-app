<?php
declare(strict_types=1);

namespace Database\Factories;

use App\GamesRequestsDirectory\Enums\Genre;
use App\GamesRequestsDirectory\Models\GameProperty;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\GamesRequestsDirectory\Models\GameProperty>
 */
class GamesPropertyFactory extends Factory
{
    protected $model = GameProperty::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->firstName,
            'developer' => $this->faker->firstName,
            'genre' => $this->faker->randomElement(Genre::values()),
        ];
    }
}
