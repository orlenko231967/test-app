<?php
declare(strict_types=1);

namespace Database\Seeders;

final class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->withoutConstraints(function (): void {
            $this->call(UsersSeeder::class);
            $this->call(GamesPropertySeeder::class);
        });
    }
}
