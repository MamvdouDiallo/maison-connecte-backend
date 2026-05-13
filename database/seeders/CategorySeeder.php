<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('sub_categories')->truncate();
        DB::table('categories')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $now = now();

        DB::table('categories')->insert([
            [
                'slug'        => 'securite',
                'name'        => json_encode(['fr' => 'Sécurité Électronique', 'en' => 'Electronic Security']),
                'description' => null,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'slug'        => 'smart-home',
                'name'        => json_encode(['fr' => 'Domotique', 'en' => 'Smart Home']),
                'description' => null,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'slug'        => 'energie',
                'name'        => json_encode(['fr' => 'Énergie Solaire', 'en' => 'Solar Energy']),
                'description' => null,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'slug'        => 'finitions',
                'name'        => json_encode(['fr' => 'Finitions Premium', 'en' => 'Premium Finishes']),
                'description' => null,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
        ]);

        $ids = DB::table('categories')->pluck('id', 'slug');

        $subCategories = [
            // Sécurité
            ['category_id' => $ids['securite'],   'slug' => 'cameras',            'name' => json_encode(['fr' => 'Caméras IP',              'en' => 'IP Cameras'])],
            ['category_id' => $ids['securite'],   'slug' => 'alarmes',            'name' => json_encode(['fr' => "Systèmes d'alarme",        'en' => 'Alarm Systems'])],
            ['category_id' => $ids['securite'],   'slug' => 'detecteurs',         'name' => json_encode(['fr' => 'Détecteurs',               'en' => 'Detectors'])],

            // Domotique
            ['category_id' => $ids['smart-home'], 'slug' => 'eclairage',          'name' => json_encode(['fr' => 'Éclairage Intelligent',    'en' => 'Smart Lighting'])],
            ['category_id' => $ids['smart-home'], 'slug' => 'capteurs',           'name' => json_encode(['fr' => 'Capteurs & Détecteurs',    'en' => 'Sensors & Detectors'])],
            ['category_id' => $ids['smart-home'], 'slug' => 'automatisation',     'name' => json_encode(['fr' => 'Automatisation',           'en' => 'Automation'])],
            ['category_id' => $ids['smart-home'], 'slug' => 'controle-vocal',     'name' => json_encode(['fr' => 'Contrôle Vocal',           'en' => 'Voice Control'])],

            // Énergie Solaire
            ['category_id' => $ids['energie'],    'slug' => 'panneaux',           'name' => json_encode(['fr' => 'Panneaux Solaires',        'en' => 'Solar Panels'])],
            ['category_id' => $ids['energie'],    'slug' => 'batteries',          'name' => json_encode(['fr' => 'Batteries de Stockage',    'en' => 'Storage Batteries'])],
            ['category_id' => $ids['energie'],    'slug' => 'onduleurs',          'name' => json_encode(['fr' => 'Onduleurs / Convertisseurs', 'en' => 'Inverters'])],
            ['category_id' => $ids['energie'],    'slug' => 'accessoires-solaires', 'name' => json_encode(['fr' => 'Accessoires Solaires',   'en' => 'Solar Accessories'])],

            // Finitions Premium
            ['category_id' => $ids['finitions'],  'slug' => 'peinture',           'name' => json_encode(['fr' => 'Peinture',                 'en' => 'Paint'])],
            ['category_id' => $ids['finitions'],  'slug' => 'carrelage',          'name' => json_encode(['fr' => 'Carrelage',                'en' => 'Tiling'])],
            ['category_id' => $ids['finitions'],  'slug' => 'menuiserie',         'name' => json_encode(['fr' => 'Menuiserie',               'en' => 'Carpentry'])],
            ['category_id' => $ids['finitions'],  'slug' => 'design',             'name' => json_encode(['fr' => "Design d'Intérieur",       'en' => 'Interior Design'])],
            ['category_id' => $ids['finitions'],  'slug' => 'plafonds',           'name' => json_encode(['fr' => 'Plafonds',                 'en' => 'Ceilings'])],
        ];

        DB::table('sub_categories')->insert(
            array_map(fn ($s) => array_merge($s, ['created_at' => $now, 'updated_at' => $now]), $subCategories)
        );
    }
}
