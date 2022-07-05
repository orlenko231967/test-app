<?php

namespace App\GamesRequestsDirectory\Controllers;

use App\GamesRequestsDirectory\Actions\CreateGamePropertyAction;
use App\GamesRequestsDirectory\Actions\DeleteGamePropertyAction;
use App\GamesRequestsDirectory\Actions\UpdateGamePropertyAction;
use App\GamesRequestsDirectory\DataTransferObjects\CreateDataTransferObjects;
use App\GamesRequestsDirectory\DataTransferObjects\UpdateDataTransferObjects;
use App\GamesRequestsDirectory\Enums\Genre;
use App\GamesRequestsDirectory\Models\GameProperty;
use App\GamesRequestsDirectory\Repository\GamePropertyRepository;
use App\GamesRequestsDirectory\Requests\CreateRequest;
use App\GamesRequestsDirectory\Requests\UpdateRequest;
use App\GamesRequestsDirectory\Responses\JsonResponse;
use App\Http\Controllers\Controller;

class GamePrepareController extends Controller
{
    /**
     * @param GamePropertyRepository $repository
     * @return JsonResponse
     */
    public function getAll(GamePropertyRepository $repository): JsonResponse
    {
        return JsonResponse::success($repository->getAll());
    }

    /**
     * @param GameProperty $game
     * @return JsonResponse
     */
    public function getOne(GameProperty $game): JsonResponse
    {
        return JsonResponse::success($game);
    }

    /**
     * @param string $genre
     * @param GamePropertyRepository $repository
     * @return JsonResponse
     */
    public function getGenre(string $genre, GamePropertyRepository $repository): JsonResponse
    {
        return JsonResponse::success($repository->getGenre(Genre::from($genre)));
    }

    /**
     * @param CreateRequest $request
     * @return JsonResponse
     */
    public function create(CreateRequest $request): JsonResponse
    {
        $data = CreateDataTransferObjects::fromRequest($request);
        $game = app(CreateGamePropertyAction::class)($data);

        return JsonResponse::success($game);
    }

    /**
     * @param GameProperty $game
     * @param UpdateRequest $request
     * @return JsonResponse
     */
    public function update(GameProperty $game, UpdateRequest $request): JsonResponse
    {
        $data = UpdateDataTransferObjects::fromRequest($request);
        $game = app(UpdateGamePropertyAction::class)($game, $data);

        return JsonResponse::success($game);
    }

    /**
     * @param GameProperty $game
     * @return JsonResponse
     */
    public function delete(GameProperty $game): JsonResponse
    {
        app(DeleteGamePropertyAction::class)($game);
        return JsonResponse::success();
    }
}
