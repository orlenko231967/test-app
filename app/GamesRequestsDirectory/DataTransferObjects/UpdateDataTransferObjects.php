<?php

namespace App\GamesRequestsDirectory\DataTransferObjects;

use App\GamesRequestsDirectory\Enums\Genre;
use App\GamesRequestsDirectory\Requests\UpdateRequest;
use Spatie\DataTransferObject\DataTransferObject;

class UpdateDataTransferObjects extends DataTransferObject
{
    public readonly ?string $name;

    public readonly ?string $developer;

    public readonly  ?Genre $genre;

    public static function fromRequest(UpdateRequest $request): self
    {
        $data = $request->validated();
        if(array_key_exists('genre', $data)){
            $data['genre'] = Genre::from($data['genre']);
        }
        return new self($data);
    }
}
