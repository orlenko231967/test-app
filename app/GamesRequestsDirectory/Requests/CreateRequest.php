<?php
declare(strict_types=1);

namespace App\GamesRequestsDirectory\Requests;

use App\GamesRequestsDirectory\Enums\Genre;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function rules(): array
    {
        return [
            'name' => ['required', 'min:2', 'max:255', 'string', 'unique:App\GamesRequestsDirectory\Models\GameProperty,name'],
            'developer' => ['required', 'min:2', 'max:255', 'string'],
            'genre' => ['required', 'string', Rule::in(Genre::values())],
        ];
    }
}
