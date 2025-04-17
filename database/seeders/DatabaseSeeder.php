<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create roles without using a factory
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);

        // Create admin user and assign role
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('MyAdminPassword')
        ])->assignRole('admin');
    }
}
