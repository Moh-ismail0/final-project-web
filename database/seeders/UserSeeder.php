<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Admin;

class UserSeeder extends Seeder
{
public function run()
{
    User::updateOrCreate(
        ['email' => 'user@test.com'],
        ['name' => 'Test User', 'password' => Hash::make('123456')]
    );
    Admin::updateOrCreate(
    ['email' => 'admin@test.com'],
    ['name' => 'Admin User', 'password' => Hash::make('123456')]
);
}
}
