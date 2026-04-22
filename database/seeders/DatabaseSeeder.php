<?php

namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
{
    $this->call([
    UserSeeder::class,
    AdminSeeder::class,
]);

    Category::insertOrIgnore([
        ['name' => 'Study',    'created_at' => now(), 'updated_at' => now()],
        ['name' => 'Work',     'created_at' => now(), 'updated_at' => now()],
        ['name' => 'Personal', 'created_at' => now(), 'updated_at' => now()],
    ]);
}
}

