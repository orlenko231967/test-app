<?php

namespace App\GamesRequestsDirectory\Requests;

use App\GamesRequestsDirectory\Enums\Genre;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function rules(): array
    {
        return[
            'name' => ['sometimes', 'min:2', 'max:255', 'string', Rule::unique('games')->ignore($this->route('game'))],
            'developer' => ['sometimes', 'min:2', 'max:255', 'string'],
            'genre' => ['sometimes', 'string', Rule::in(Genre::values())],
        ];
    }

}
