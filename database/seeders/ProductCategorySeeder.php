<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        // Crear categorías para los productos
        $emotes = Category::firstOrCreate(
            ['name' => 'Emotes'],
            ['icon' => '😄', 'is_active' => true, 'sort_order' => 1]
        );

        $badges = Category::firstOrCreate(
            ['name' => 'Badges & Paneles'],
            ['icon' => '🏅', 'is_active' => true, 'sort_order' => 2]
        );

        $stream = Category::firstOrCreate(
            ['name' => 'Assets de Stream'],
            ['icon' => '🎮', 'is_active' => true, 'sort_order' => 3]
        );

        $vtuber = Category::firstOrCreate(
            ['name' => 'VTuber'],
            ['icon' => '🎭', 'is_active' => true, 'sort_order' => 4]
        );

        $arte = Category::firstOrCreate(
            ['name' => 'Arte & Ilustración'],
            ['icon' => '🎨', 'is_active' => true, 'sort_order' => 5]
        );

        $extras = Category::firstOrCreate(
            ['name' => 'Extras'],
            ['icon' => '✨', 'is_active' => true, 'sort_order' => 6]
        );

        // Asignar categorías a los productos existentes
        $map = [
            'Emote sencillo'           => $emotes->id,
            'Sub badge'                => $badges->id,
            'Panel de Twitch'          => $badges->id,
            'Overlay de stream'        => $stream->id,
            'Pantalla de inicio / fin' => $stream->id,
            'VTuber asset'             => $vtuber->id,
            'Banner de canal'          => $stream->id,
            'Revisión extra'           => $extras->id,
            'Arte de perfil (avatar)'  => $arte->id,
            'Sticker pack (x5)'        => $arte->id,
        ];

        foreach ($map as $productName => $categoryId) {
            Product::where('name', $productName)->update(['category_id' => $categoryId]);
        }
    }
}
