<?php
declare(strict_types=1);

namespace App\GamesRequestsDirectory\Repository;

use App\GamesRequestsDirectory\Enums\Genre;
use App\GamesRequestsDirectory\Models\GameProperty;
use Illuminate\Database\Eloquent\Collection;

class GamePropertyRepository
{
    public function __construct(private readonly GameProperty $gameProperty)
    {

    }

    public function getAll(): Collection|null
    {
        return $this->gameProperty->get();
    }

    public function getGenre(Genre $genre): Collection|null
    {
        return $this->gameProperty->ofGenres($genre)->get();
    }

}
