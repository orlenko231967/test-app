<?php

namespace App\GamesRequestsDirectory\DataTransferObjects;

use App\GamesRequestsDirectory\Enums\Genre;
use App\GamesRequestsDirectory\Requests\CreateRequest;
use Spatie\DataTransferObject\DataTransferObject;

class CreateDataTransferObjects extends DataTransferObject
{
    public readonly string $name;

    public readonly string $developer;

    public readonly  Genre $genre;

    public static function fromRequest(CreateRequest $request): self
    {
        $data = $request->validated();
        $data['genre'] = Genre::from($data['genre']);
        return new self($data);
    }
}
