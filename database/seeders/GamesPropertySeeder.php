<?php
declare(strict_types=1);

namespace Database\Seeders;

use App\GamesRequestsDirectory\Models\GameProperty;
use Illuminate\Database\Seeder;

class GamesPropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GameProperty::truncate();

        GameProperty::factory(20)->create();
    }
}
