<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class GuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */


    public function run()
    {
        User::create([
            'name' => 'Admin Guru',
            'email' => 'admin@guru.test',
            'password' => Hash::make('password123'),
            'role' => 'guru',
            'is_verified' => true,
        ]);
    }
}
