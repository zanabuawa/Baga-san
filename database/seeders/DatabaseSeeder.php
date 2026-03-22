<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\SocialLink;
use App\Models\PageSetting;
use App\Models\CommissionPackage;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Usuario admin
        User::create([
            'name'     => 'Baga San',
            'email'    => 'admin@bagasan.com',
            'password' => Hash::make('password'),
        ]);

        // Links sociales
        $platforms = ['x', 'instagram', 'discord', 'paypal'];
        foreach ($platforms as $platform) {
            SocialLink::create([
                'platform'  => $platform,
                'url'       => null,
                'is_active' => false,
            ]);
        }

        // Configuración de la página
        $settings = [
            'artist_name'        => 'Baga San',
            'hero_title'         => 'Ilustraciones que cobran vida en tu pantalla',
            'hero_subtitle'      => 'Emotes personalizados, VTuber assets, badges y arte digital para streamers y creadores de contenido.',
            'bio'                => 'Hola, soy Baga San, artista digital especializada en emotes para Twitch y Discord.',
            'commissions_open'   => 'true',
            'commissions_status' => 'Comisiones abiertas',
            'delivery_time'      => '5–7 días',
        ];

        foreach ($settings as $key => $value) {
            PageSetting::create(['key' => $key, 'value' => $value]);
        }

        // Paquetes de comisiones
        CommissionPackage::create([
            'name'        => 'Emote sencillo',
            'description' => 'Perfecto para streamers que están comenzando.',
            'price'       => 8.00,
            'features'    => [
                '1 emote (28×28 / 56×56 / 112×112)',
                '2 revisiones incluidas',
                'Entrega en 5–7 días',
                'Archivo PNG transparente',
            ],
            'is_featured' => false,
            'is_active'   => true,
            'sort_order'  => 1,
        ]);

        CommissionPackage::create([
            'name'        => 'Pack streamer',
            'description' => 'El favorito de mis clientes. Ahorra más por emote.',
            'price'       => 35.00,
            'features'    => [
                '5 emotes personalizados',
                '3 revisiones por emote',
                'Entrega en 10–14 días',
                'PNG + PSD (archivos fuente)',
                '1 sub badge de regalo',
            ],
            'is_featured' => true,
            'is_active'   => true,
            'sort_order'  => 2,
        ]);

        CommissionPackage::create([
            'name'        => 'Branding completo',
            'description' => 'Para streamers que quieren una identidad visual sólida.',
            'price'       => 80.00,
            'features'    => [
                '10 emotes + 5 badges',
                'Overlay de stream',
                'Pantallas de inicio/fin',
                'Revisiones ilimitadas',
                'Soporte post-entrega',
            ],
            'is_featured' => false,
            'is_active'   => true,
            'sort_order'  => 3,
        ]);
    }
}