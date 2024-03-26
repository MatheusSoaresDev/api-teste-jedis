<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Produto;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        /*Produto::factory(50)->create();
        User::factory(50)->create();

        Role::factory()->create([
            'role' => 'admin',
        ]);

        Role::factory()->create([
            'role' => 'user',
        ]);*/

        User::factory()->create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'password',
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Jenna Doe',
            'email' => 'jennadoe@example.com',
            'password' => 'password',
            'role' => 'user',
        ]);
    }
}
