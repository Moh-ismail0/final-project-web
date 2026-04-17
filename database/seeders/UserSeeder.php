<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
public function run()
{

    User::updateOrCreate(
        ['email' => 'admin@test.com'],
        [
            'name' => 'Admin',
            'password' => Hash::make('123456')
        ]
    );


    User::factory(10)->create([
    'password' => Hash::make('123456')
]);
}
}
