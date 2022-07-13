<?php
declare(strict_types=1);

namespace App\GamesRequestsDirectory\Models;

use App\GamesRequestsDirectory\Enums\Genre;
use Carbon\Carbon;
use Database\Factories\GamesPropertyFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $name
 * @property string $developer
 * @property Genre $genre
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|self  $ofGenres()
 * @method static GamesPropertyFactory factory(...$parameters)
 */
class GameProperty extends Model
{
    use HasFactory;

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

    protected static function newFactory(): GamesPropertyFactory
    {
        return GamesPropertyFactory::new();
    }

}
