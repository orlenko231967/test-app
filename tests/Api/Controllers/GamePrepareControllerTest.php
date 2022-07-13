<?php
declare(strict_types=1);

namespace Tests\Api\Controllers;

use App\GamesRequestsDirectory\Enums\Genre;
use App\GamesRequestsDirectory\Models\GameProperty;
use Tests\FeatureTestCase;

class GamePrepareControllerTest extends FeatureTestCase
{
    public function testGetAll(): void
    {
        GameProperty::truncate();
        GameProperty::factory(3)->create();
        $games = GameProperty::all();

        $response = $this->getJson(route('api.v1.show'))
            ->assertOk()
            ->assertJsonStructure($this->structureGetAll());

        $data = $response->json('payload');
        foreach ($games as $key => $game) {
            $fields = $data[$key];
            $this->assertSame($game->id, $fields['id']);
            $this->assertSame($game->name, $fields['name']);
            $this->assertSame($game->developer, $fields['developer']);
            $this->assertSame($game->genre, Genre::from($fields['genre']));
        }
    }

    public function testCreate(): void
    {
        $params = [
            'name' => fake()->unique()->firstName,
            'developer' => fake()->firstName,
            'genre' => fake()->randomElement(Genre::values()),
        ];
        $this->postJson(route('api.v1.create'), $params)
            ->assertOk();
        $this->assertTrue(
            GameProperty::where([
                'name' => $params['name'],
                'developer' => $params['developer'],
                'genre' => $params['genre'],
            ])->exists()
        );
    }

    public function testErrorValidateCreate(): void
    {
        $params = [
            'name' => fake()->unique()->firstName,
            'developer' => '',
            'genre' => fake()->randomElement(Genre::values()),
        ];
        $this->postJson(route('api.v1.create'), $params)
            ->assertUnprocessable();
    }

    public function testShowOne(): void
    {
        $game = GameProperty::factory()->create();

        $response = $this->getJson(route('api.v1.show_one', ['game' => $game->id]))
            ->assertOk()
            ->assertJsonStructure($this->structureShowOne());
        $data = $response->json('payload');
        $this->assertSame($game->id, $data['id']);
        $this->assertSame($game->name, $data['name']);
        $this->assertSame($game->developer, $data['developer']);
        $this->assertSame($game->genre, Genre::from($data['genre']));
    }

    public function testUpdate(): void
    {
        $game = GameProperty::factory()->create();

        $params = [
            'name' => fake()->unique()->firstName,
            'developer' => fake()->firstName,
            'genre' => fake()->randomElement(Genre::values()),
        ];

        $this->putJson(route('api.v1.update', ['game' => $game->id]), $params)
            ->assertOk();

        $this->assertTrue(
            GameProperty::where([
                'id' => $game->id,
                'name' => $params['name'],
                'developer' => $params['developer'],
                'genre' => $params['genre'],
            ])->exists()
        );
    }

    public function testDelete(): void
    {
        $game = GameProperty::factory()->create();

        $this->deleteJson(route('api.v1.delete', ['game' => $game->id]))
            ->assertOk();

        $this->assertTrue(
            GameProperty::where(['id' => $game->id])->doesntExist()
        );
    }

    public function testGenre(): void
    {
        GameProperty::truncate();
        GameProperty::factory(3)->create(['genre' => Genre::ACTION->value]);
        GameProperty::factory(3)->create(['genre' => Genre::STATEGY->value]);

        $response = $this->getJson(route('api.v1.genre', ['genre' => Genre::ACTION->value]))
            ->assertOk()
            ->assertJsonStructure($this->structureGetAll());

        $data = $response->json('payload');
        foreach ($data as $game) {
            $this->assertSame($game['genre'], Genre::ACTION->value);
        }

    }
    private function structureGetAll(): array
    {
        return [
            'description',
            'payload' => [
                '*' => [
                    'id',
                    'name',
                    'developer',
                    'genre',
                ],
            ],
        ];
    }

    private function structureShowOne(): array
    {
        return [
            'description',
            'payload' => [
                'id',
                'name',
                'developer',
                'genre',
            ],
        ];
    }
}
