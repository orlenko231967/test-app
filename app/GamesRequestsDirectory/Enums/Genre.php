<?php

namespace App\GamesRequestsDirectory\Enums;

use App\GamesRequestsDirectory\Traits\HasValues;

enum Genre: string
{
    use HasValues;

    case ACTION = 'action';
    case ADVENTURE = 'adventure';
    case RACING = 'racing';
    case STATEGY = 'strategy';
}
