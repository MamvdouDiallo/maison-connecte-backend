<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // insertOrIgnore : ne touche pas aux valeurs déjà éditées depuis le backoffice
        DB::table('settings')->insertOrIgnore([
            [
                'key'        => 'home_video_url',
                'value'      => null,
                'value_json' => null,
                'type'       => 'url',
                'label'      => 'Vidéo YouTube — page d\'accueil',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'key'        => 'whatsapp_number',
                'value'      => null,
                'value_json' => null,
                'type'       => 'text',
                'label'      => 'Numéro WhatsApp',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'key'        => 'support_email',
                'value'      => null,
                'value_json' => null,
                'type'       => 'text',
                'label'      => 'Email du support / assistance',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'key'        => 'hero_title',
                'value'      => null,
                'value_json' => null,
                'type'       => 'translatable_text',
                'label'      => 'Titre principal — bannière d\'accueil',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'key'        => 'hero_subtitle',
                'value'      => null,
                'value_json' => null,
                'type'       => 'translatable_text',
                'label'      => 'Sous-titre — bannière d\'accueil',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'key'        => 'hero_description',
                'value'      => null,
                'value_json' => null,
                'type'       => 'translatable_text',
                'label'      => 'Description — bannière d\'accueil',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'key'        => 'cta_title',
                'value'      => null,
                'value_json' => null,
                'type'       => 'translatable_text',
                'label'      => 'Titre — bloc "Prêt à démarrer"',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'key'        => 'cta_description',
                'value'      => null,
                'value_json' => null,
                'type'       => 'translatable_text',
                'label'      => 'Description — bloc "Prêt à démarrer"',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
