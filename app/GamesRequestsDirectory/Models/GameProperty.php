<?php

namespace App\GamesRequestsDirectory\Models;

use App\GamesRequestsDirectory\Enums\Genre;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $name
 * @property string $developer
 * @property Genre $genre
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method Builder|self  $ofGenres()
 */
class GameProperty extends Model
{
    protected $table = 'games';

    protected $casts = [
        'genre' => Genre::class,
    ];

    protected $hidden = [
        'updated_at',
        'created_at',
    ];

    /**
     * @param Builder $query
     * @param Genre $genre
     * @return Builder
     */
    public function scopeOfGenres(Builder $query, Genre $genre)
    {
        return $query->where('genre', $genre);
    }

}
