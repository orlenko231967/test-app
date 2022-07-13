<?php
declare(strict_types=1);

namespace App\GamesRequestsDirectory\Actions;

use App\GamesRequestsDirectory\DataTransferObjects\CreateDataTransferObjects;
use App\GamesRequestsDirectory\Models\GameProperty;

class CreateGamePropertyAction
{
    /**
     * @param CreateDataTransferObjects $data
     * @return GameProperty
     */
    public function __invoke(CreateDataTransferObjects $data): GameProperty
    {
        $game = new GameProperty();
        $game->name = $data->name;
        $game->developer = $data->developer;
        $game->genre = $data->genre;
        $game->save();

        return $game;
    }
}
