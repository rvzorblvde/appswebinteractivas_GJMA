<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $ana = User::create([
            'name' => 'Ana López',
            'email' => 'ana@example.com',
            'password' => 'password',
        ]);

        $carlos = User::create([
            'name' => 'Carlos Pérez',
            'email' => 'carlos@example.com',
            'password' => 'password',
        ]);

        $ana->recipes()->create([
            'title' => 'Chilaquiles verdes',
            'category' => 'desayuno',
            'minutes' => 25,
            'difficulty' => 'facil',
            'ingredients' => "Totopos\nSalsa verde\nPollo deshebrado\nCrema\nQueso fresco\nCebolla",
            'steps' => "Calienta la salsa verde en una sartén.\nAgrega los totopos y mezcla durante 2 minutos.\nSirve con pollo, crema, queso y cebolla.",
            'personal_note' => 'A mi familia le gustan con huevo estrellado encima.',
        ]);

        $ana->recipes()->create([
            'title' => 'Tarta de manzana',
            'category' => 'postre',
            'minutes' => 60,
            'difficulty' => 'medio',
            'ingredients' => "4 manzanas\n200 g de harina\n100 g de mantequilla\n80 g de azúcar\n1 cucharadita de canela",
            'steps' => "Mezcla harina, mantequilla y azúcar hasta formar la masa.\nExtiéndela en un molde.\nColoca las manzanas en rodajas con canela.\nHornea a 180 °C durante 40 minutos.",
            'personal_note' => null,
        ]);

        $carlos->recipes()->create([
            'title' => 'Pasta carbonara',
            'category' => 'cena',
            'minutes' => 30,
            'difficulty' => 'medio',
            'ingredients' => "250 g de espagueti\n100 g de tocino\n2 yemas\n1 huevo\n50 g de queso parmesano\nPimienta negra",
            'steps' => "Cuece la pasta en agua con sal.\nFríe el tocino hasta que esté crujiente.\nMezcla yemas, huevo y queso.\nUne todo fuera del fuego y sirve de inmediato.",
            'personal_note' => 'No agregar crema.',
        ]);

        $carlos->recipes()->create([
            'title' => 'Agua de jamaica',
            'category' => 'bebida',
            'minutes' => 15,
            'difficulty' => 'facil',
            'ingredients' => "1 taza de flor de jamaica\n2 litros de agua\nAzúcar al gusto\nHielo",
            'steps' => "Hierve la jamaica en un litro de agua durante 10 minutos.\nCuela y agrega el azúcar.\nAñade el otro litro de agua fría y hielo.",
            'personal_note' => null,
        ]);
    }
}
