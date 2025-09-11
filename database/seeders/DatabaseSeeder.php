<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'VVDongen',
            'email' => 'info@vvdongen.nl',
        ]);

        $categories = [
            'Homepage',
            'Vereniging',
            'Teams',
            'Commissies',
            'Wedstrijden',
            'Sociale veiligheid',
            'Sponsoring',
            'Kantine',
            'Bezoek aan ons sportpark',
            'Webshop',
            'Jubileum 100',
        ];

        foreach ($categories as $index => $name) {
            Category::create([
                'name' => $name,
                'order' => $index + 1,
            ]);
        }
    }
}
