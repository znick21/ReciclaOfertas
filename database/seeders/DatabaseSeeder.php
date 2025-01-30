<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Llamar otros seeders aquí si los tienes
        $this->call([
            AdminSeeder::class, // Asegúrate de que este seeder existe
        ]);
    }
}
