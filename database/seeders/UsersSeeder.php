<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    $users = [
      [
        'name' => 'User One',
        'email' => 'uone@example.com',
        'pass' => Hash::make('user123456'),
      ],
      [
        'name' => 'User Two',
        'email' => 'utwo@example.com',
        'pass' => Hash::make('user123456'),
      ]
    ];
    foreach ($users as $user) {
      User::firstOrCreate([
        'name' => $user['name'],
        'email' => $user['email'],
        'password' => $user['pass'],
      ]);
    }
  }
}
