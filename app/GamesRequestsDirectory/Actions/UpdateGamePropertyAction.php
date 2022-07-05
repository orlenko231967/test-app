<?php

namespace App\GamesRequestsDirectory\Actions;

use App\GamesRequestsDirectory\DataTransferObjects\UpdateDataTransferObjects;
use App\GamesRequestsDirectory\Models\GameProperty;

class UpdateGamePropertyAction
{
    /**
     * @param GameProperty $game
     * @param UpdateDataTransferObjects $data
     * @return GameProperty
     */
    public function __invoke(GameProperty $game, UpdateDataTransferObjects $data): GameProperty
    {
       foreach ($data as $key => $value){
           if(!$value){
               continue;
           }
           $game->$key = $value;
       }
       $game->save();
       return $game;
    }
}
