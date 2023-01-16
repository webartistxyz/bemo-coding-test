<?php

namespace Database\Seeders;

use App\Models\BoardColumn;
use App\Models\Card;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        \App\Models\Board::factory()
            ->has(
                BoardColumn::factory()
                    ->has(Card::factory()->count(random_int(2, 4)))
                    ->count(3),
                'columns'
            )
            ->create();
    }
}
