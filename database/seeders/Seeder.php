<?php
declare(strict_types=1);

namespace Database\Seeders;

use Closure;
use Illuminate\Database\Seeder as BaseSeeder;
use Illuminate\Support\Facades\Schema;

abstract class Seeder extends  BaseSeeder
{
    protected function withoutConstraints(Closure $callback): void
    {
        Schema::disableForeignKeyConstraints();
        $callback();
        Schema::enableForeignKeyConstraints();
    }
}
