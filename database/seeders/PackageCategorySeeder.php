<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\CommissionPackage;
use Illuminate\Database\Seeder;

class PackageCategorySeeder extends Seeder
{
    public function run(): void
    {
        $starter  = Category::firstOrCreate(
            ['name' => 'Starter'],
            ['icon' => '🌱', 'is_active' => true, 'sort_order' => 10]
        );

        $streaming = Category::firstOrCreate(
            ['name' => 'Streaming'],
            ['icon' => '📡', 'is_active' => true, 'sort_order' => 11]
        );

        $branding = Category::firstOrCreate(
            ['name' => 'Branding'],
            ['icon' => '💎', 'is_active' => true, 'sort_order' => 12]
        );

        $vtuber = Category::firstOrCreate(
            ['name' => 'VTuber'],
            ['icon' => '🎭', 'is_active' => true, 'sort_order' => 4]
        );

        $social = Category::firstOrCreate(
            ['name' => 'Redes Sociales'],
            ['icon' => '🌐', 'is_active' => true, 'sort_order' => 13]
        );

        $map = [
            'Emote sencillo'     => $starter->id,
            'Pack streamer'      => $streaming->id,
            'Branding completo'  => $branding->id,
            'Kit VTuber starter' => $vtuber->id,
            'Pack redes sociales' => $social->id,
        ];

        foreach ($map as $name => $categoryId) {
            CommissionPackage::where('name', $name)->update(['category_id' => $categoryId]);
        }
    }
}
