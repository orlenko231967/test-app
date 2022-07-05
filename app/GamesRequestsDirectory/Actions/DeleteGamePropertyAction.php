<?php

namespace App\GamesRequestsDirectory\Actions;

use App\GamesRequestsDirectory\Models\GameProperty;

class DeleteGamePropertyAction
{
    /**
     * @param GameProperty $game
     * @return void
     */
    public function __invoke(GameProperty $game): void
    {
        $game->delete();
    }
}
