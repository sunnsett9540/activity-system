<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            FieldSeeder::class,
        ]);

        User::create([
            'name' => 'Test User',
            'student_id' => '6531100001',
            'email' => 'test@example.com',
            'password' => bcrypt('12345678'),
            'field_id' => 1
        ]);
    }
}