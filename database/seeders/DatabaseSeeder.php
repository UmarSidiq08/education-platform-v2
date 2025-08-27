<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Jalankan RoleSeeder dulu, baru GuruSeeder
        $this->call([
            RoleSeeder::class,
            GuruSeeder::class,
        ]);
    }
}
