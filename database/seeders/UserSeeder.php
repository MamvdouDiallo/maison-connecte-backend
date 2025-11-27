<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // ← Ajoute cette ligne pour importer le modèle

class UserSeeder extends Seeder
{
    public function run()
    {
        // Admin
        User::factory()->create([
            'email' => 'admin@maison.sn',
            'role' => 'admin',
        ]);

        // Partners
        User::factory(3)->create(['role' => 'partner']);

        // Clients
        User::factory(10)->create(['role' => 'client']);
    }
}
