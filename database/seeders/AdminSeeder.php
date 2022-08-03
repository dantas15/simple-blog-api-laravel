<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'id' => Str::uuid(),
            'name' => env('ADMIN_NAME') ?? 'Admin',
            'email' => env('ADMIN_EMAIL') ?? 'admin@test.com',
            'password' => bcrypt(env('ADMIN_PASSWORD') ?? 'password'),
            'is_admin' => true,
        ]);
    }
}
