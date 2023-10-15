<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //\App\Models\Post::factory(50)->create();
        /** @var \App\Models\User $admin */

        $admin = User::factory()->create([
            'email' => 'admin@gmail.com',
            'name' => 'Rana Faisal',
            'password' => bcrypt('12345678')
        ]);

        $role = Role::create([
            'name' => 'admin'
        ]);

        $admin->assignRole($role);
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
