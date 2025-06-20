<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Friend;
use App\Models\Language;
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
       User::create([
           'name' => 'Admin User',
           'email' => 'admin@a.a',
           'password' => bcrypt('admin'),
           'role' => 'admin'
       ]);

       User::factory()->create([
           'name' => 'Test User',
           'email' => 'user@a.a',
           'password' => bcrypt('user'),
       ]);

       for ($i = 1; $i <= 10; $i++) {
           User::factory()->create([
               'name' => "User  {$i}",
               'email' => "user{$i}@a.a",
               'password' => bcrypt("user{$i}"),
           ]);
       }

       for ($i = 3; $i <= 6; $i++) {
           Friend::create([
               'user_id' => 2,
               'friend_id' => $i,
           ]);
       }

       for ($i = 3; $i <= 6; $i++) {
           Friend::create([
               'user_id' => $i,
               'friend_id' => 2,
           ]);
       }

       Language::create([
           'name' => 'English',
           'code' => 'en',
       ]);

       Language::create([
           'name' => 'Latviešu',
           'code' => 'lv',
       ]);
   }
}
