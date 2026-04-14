<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name'        => 'Emote sencillo',
                'description' => 'Emote personalizado en tres tamaños estándar (28×28, 56×56, 112×112 px). Ideal para Twitch y Discord.',
                'price'       => 8.00,
                'is_active'   => true,
                'sort_order'  => 1,
            ],
            [
                'name'        => 'Sub badge',
                'description' => 'Badge de suscriptor para Twitch en tamaños requeridos por la plataforma. Diseño personalizado.',
                'price'       => 5.00,
                'is_active'   => true,
                'sort_order'  => 2,
            ],
            [
                'name'        => 'Panel de Twitch',
                'description' => 'Panel decorativo para el perfil de Twitch. Incluye diseño de cabecera y fondo.',
                'price'       => 8.00,
                'is_active'   => true,
                'sort_order'  => 3,
            ],
            [
                'name'        => 'Overlay de stream',
                'description' => 'Overlay completo para OBS o Streamlabs. Incluye marcos de cámara, barras de alerta y bordes decorativos.',
                'price'       => 20.00,
                'is_active'   => true,
                'sort_order'  => 4,
            ],
            [
                'name'        => 'Pantalla de inicio / fin',
                'description' => 'Pantalla animada o estática de inicio o fin de stream. Entregada en formato estático o GIF.',
                'price'       => 15.00,
                'is_active'   => true,
                'sort_order'  => 5,
            ],
            [
                'name'        => 'VTuber asset',
                'description' => 'Elemento visual para VTubers: expresión, accesorio, efecto o prop. Entregado en PNG con transparencia.',
                'price'       => 25.00,
                'is_active'   => true,
                'sort_order'  => 6,
            ],
            [
                'name'        => 'Banner de canal',
                'description' => 'Banner para el encabezado del canal de Twitch o YouTube. Tamaño optimizado para todas las plataformas.',
                'price'       => 12.00,
                'is_active'   => true,
                'sort_order'  => 7,
            ],
            [
                'name'        => 'Revisión extra',
                'description' => 'Ronda adicional de cambios sobre cualquier entregable ya finalizado.',
                'price'       => 3.00,
                'is_active'   => true,
                'sort_order'  => 8,
            ],
            [
                'name'        => 'Arte de perfil (avatar)',
                'description' => 'Ilustración de avatar personalizada para redes sociales, Discord o Twitch. Estilo chibi o semirealista.',
                'price'       => 18.00,
                'is_active'   => true,
                'sort_order'  => 9,
            ],
            [
                'name'        => 'Sticker pack (x5)',
                'description' => 'Pack de 5 stickers digitales con temática a elección. Formato PNG y WebP.',
                'price'       => 22.00,
                'is_active'   => true,
                'sort_order'  => 10,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
