<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // AdminSeeder doit toujours être en premier — crée le super admin de la plateforme
        $this->call([
            AdminSeeder::class,
            UserSeeder::class,
            CategorySeeder::class, // insère aussi les sous-catégories
            ProductSeeder::class,
            PackSeeder::class,
            ServiceSeeder::class,
            OrderSeeder::class,
            SettingSeeder::class,
        ]);
    }
}
