<?php

namespace Database\Seeders;

use App\Models\CommissionPackage;
use App\Models\Product;
use Illuminate\Database\Seeder;

class CommissionPackageSeeder extends Seeder
{
    public function run(): void
    {
        $emote    = Product::where('name', 'Emote sencillo')->first();
        $badge    = Product::where('name', 'Sub badge')->first();
        $overlay  = Product::where('name', 'Overlay de stream')->first();
        $screen   = Product::where('name', 'Pantalla de inicio / fin')->first();
        $revision = Product::where('name', 'Revisión extra')->first();
        $avatar   = Product::where('name', 'Arte de perfil (avatar)')->first();
        $panel    = Product::where('name', 'Panel de Twitch')->first();
        $sticker  = Product::where('name', 'Sticker pack (x5)')->first();

        // ── Paquete 1: Emote sencillo ───────────────────────────────────────
        $basic = CommissionPackage::create([
            'name'        => 'Emote sencillo',
            'description' => 'Perfecto para streamers que están comenzando.',
            'price'       => 8.00,
            'features'    => ['2 revisiones incluidas', 'Entrega en 5–7 días', 'Archivo PNG transparente'],
            'is_featured' => false,
            'is_active'   => true,
            'sort_order'  => 1,
        ]);
        $basic->products()->attach([
            $emote->id => ['quantity' => 1],
        ]);

        // ── Paquete 2: Pack streamer ────────────────────────────────────────
        $streamer = CommissionPackage::create([
            'name'        => 'Pack streamer',
            'description' => 'El favorito de mis clientes. Ahorra más por emote.',
            'price'       => 35.00,
            'features'    => ['3 revisiones por emote', 'Entrega en 10–14 días', 'PNG + PSD (archivos fuente)'],
            'is_featured' => true,
            'is_active'   => true,
            'sort_order'  => 2,
        ]);
        $streamer->products()->attach([
            $emote->id => ['quantity' => 5],
            $badge->id => ['quantity' => 1],
        ]);

        // ── Paquete 3: Branding completo ────────────────────────────────────
        $branding = CommissionPackage::create([
            'name'        => 'Branding completo',
            'description' => 'Para streamers que quieren una identidad visual sólida.',
            'price'       => 80.00,
            'features'    => ['Revisiones ilimitadas', 'Soporte post-entrega', 'Entrega en 18–25 días'],
            'is_featured' => false,
            'is_active'   => true,
            'sort_order'  => 3,
        ]);
        $branding->products()->attach([
            $emote->id   => ['quantity' => 10],
            $badge->id   => ['quantity' => 5],
            $overlay->id => ['quantity' => 1],
            $screen->id  => ['quantity' => 2],
        ]);

        // ── Paquete 4: Kit VTuber ───────────────────────────────────────────
        $vtuber = CommissionPackage::create([
            'name'        => 'Kit VTuber starter',
            'description' => 'Todo lo que necesitas para arrancar como VTuber.',
            'price'       => 55.00,
            'features'    => ['2 revisiones por ítem', 'Entrega en 14–21 días', 'Archivos listos para OBS'],
            'is_featured' => false,
            'is_active'   => true,
            'sort_order'  => 4,
        ]);
        $vtuber->products()->attach([
            $avatar->id  => ['quantity' => 1],
            $emote->id   => ['quantity' => 3],
            $overlay->id => ['quantity' => 1],
            $panel->id   => ['quantity' => 2],
        ]);

        // ── Paquete 5: Pack redes sociales ──────────────────────────────────
        $social = CommissionPackage::create([
            'name'        => 'Pack redes sociales',
            'description' => 'Presencia visual consistente en todas tus plataformas.',
            'price'       => 42.00,
            'features'    => ['2 revisiones por ítem', 'Entrega en 7–10 días', 'Formatos para todas las plataformas'],
            'is_featured' => false,
            'is_active'   => true,
            'sort_order'  => 5,
        ]);
        $social->products()->attach([
            $avatar->id  => ['quantity' => 1],
            $sticker->id => ['quantity' => 1],
            $badge->id   => ['quantity' => 3],
        ]);
    }
}
