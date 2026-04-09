<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\SocialLink;
use App\Models\PageSetting;
use App\Models\CommissionPackage;
use App\Models\ProcessStep;
use App\Models\Faq;

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
            'contact_email'      => env('CONTACT_MAIL_TO', 'admin@bagasan.com'),
            'happy_clients'      => '0',
            'years_experience'   => '1',
            'default_theme'      => 'dark',
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

        // Pasos del proceso
        $steps = [
            ['icon' => '📝', 'title' => 'Solicita tu comisión', 'description' => 'Llena el formulario con tu idea, referencias y el tipo de trabajo que necesitas. Cuantos más detalles, mejor el resultado.', 'sort_order' => 1],
            ['icon' => '🎨', 'title' => 'Creamos juntos', 'description' => 'Me pongo a trabajar en tu pedido y te envío avances para que puedas sugerir ajustes. Tu visión guía el proceso.', 'sort_order' => 2],
            ['icon' => '✦', 'title' => 'Entrega y listo', 'description' => 'Recibes los archivos finales en alta calidad, listos para usar en Twitch, Discord o donde los necesites.', 'sort_order' => 3],
        ];
        foreach ($steps as $step) {
            ProcessStep::create(array_merge($step, ['is_active' => true]));
        }

        // FAQs
        $faqs = [
            ['question' => '¿Cuánto tarda una comisión?', 'answer' => 'El tiempo de entrega varía según el tipo de trabajo. Los emotes sencillos suelen estar listos en 5–7 días. Los packs y proyectos de branding pueden tardar de 10 a 21 días.', 'sort_order' => 1],
            ['question' => '¿Cómo pago mi comisión?', 'answer' => 'Puedes pagar a través de PayPal. Solicito el 50% al inicio y el 50% restante al entregar el trabajo final.', 'sort_order' => 2],
            ['question' => '¿Cuántas revisiones incluye?', 'answer' => 'Cada paquete tiene revisiones incluidas. Los emotes sencillos incluyen 2 revisiones, los packs incluyen 3 por emote, y el branding completo tiene revisiones ilimitadas.', 'sort_order' => 3],
            ['question' => '¿Puedo usar los emotes en cualquier plataforma?', 'answer' => 'Sí. Recibes los archivos en los formatos y tamaños necesarios para Twitch (28x28, 56x56, 112x112) y Discord. Los derechos de uso son completamente tuyos.', 'sort_order' => 4],
            ['question' => '¿Aceptas todo tipo de comisiones?', 'answer' => 'Me especializo en emotes, badges, paneles de Twitch y assets para streamers. Si tienes un proyecto diferente, ¡escríbeme y lo evaluamos!', 'sort_order' => 5],
        ];
        foreach ($faqs as $faq) {
            Faq::create(array_merge($faq, ['is_active' => true]));
        }
    }
}