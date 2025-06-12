<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\File;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'user@a.a',
            'password' => bcrypt('user'),
        ]);

        User::create([
            'name' => 'Admin User',
            'email' => 'admin@a.a',
            'password' => bcrypt('admin'),
            'role' => 'admin'
        ]);

        $file1 = File::create([
            'filename' => 'fails1',
            'stored_path' => '/somerandom/filepath/file3253232',
            'description' => 'Hello there, this is a sample description.',
            'owner_id' => 1,
            'is_public' => true,
            'password_hash' => 'temp'
        ]);
    }
}
