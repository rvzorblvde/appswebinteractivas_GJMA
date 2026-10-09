<?php

namespace Database\Seeders;

use App\Models\Torneo;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TorneoSeeder extends Seeder
{
    public function run(): void
    {
        $nombres = [
            'James Harden', 'LeBron James', 'Shai Gilgeous-Alexander', 'Tyrese Haliburton',
            'Jimmy Butler', 'Giannis Antetokounmpo', 'Kevin Durant', 'Stephen Curry',
            'Luka Dončić', 'Nikola Jokić', 'Jayson Tatum', 'Anthony Edwards',
            'Damian Lillard', 'Devin Booker', 'Victor Wembanyama', 'Ja Morant',
            'Kawhi Leonard', 'Paul George', 'Donovan Mitchell', 'Jaylen Brown',
        ];

        $jugadores = collect($nombres)->map(function ($nombre) {
            $user = User::firstOrNew(['email' => Str::slug($nombre, '.') . '@torneos.test']);
            $user->forceFill([
                'name' => $nombre,
                'password' => 'password',
                'role' => 'jugador',
            ])->save();
            return $user;
        });

        // [nombre, juego, días desde hoy, hora, cupo, abierto, inscritos, descripción]
        $torneos = [
            ['Copa Relámpago 3x3', 'Básquetbol 3x3', 7, '10:00', 16, true, 6, 'Torneo rápido de media cancha, equipos de 3.'],
            ['Liga Intercolegial 5x5', 'Básquetbol 5x5', 14, '16:00', 8, true, 4, 'Fase de grupos y eliminación directa.'],
            ['Concurso de Triples', 'Tiro de tres puntos', 10, '18:30', 20, true, 5, 'Quien enceste más triples en 60 segundos.'],
            ['Slam Dunk Night', 'Concurso de clavadas', 21, '20:00', 12, true, 3, 'Noche de clavadas con jurado.'],
            ['Final Four Express', 'Básquetbol 5x5', 3, '19:00', 2, true, 2, 'Cupo lleno para probar el bloqueo.'],
            ['Clásico de Veteranos', 'Básquetbol 5x5', 5, '09:00', 10, false, 2, 'Cerrado por el administrador.'],
            ['Torneo Apertura', 'Básquetbol 5x5', -10, '12:00', 16, true, 8, 'Torneo que ya se jugó.'],
            ['Copa Navideña 3x3', 'Básquetbol 3x3', 30, '11:00', 24, true, 10, 'Torneo de temporada con premios sorpresa.'],
            ['Reto Handles & Crossovers', 'Habilidades de manejo', 12, '17:00', 15, true, 0, 'Circuito de manejo de balón contra reloj.'],
            ['Liga Nocturna Libre', 'Básquetbol 5x5', 18, '21:00', 10, true, 9, 'Casi lleno: queda una sola plaza.'],
            ['Torneo Universitario', 'Básquetbol 5x5', 25, '10:30', 32, true, 12, 'Participan equipos de distintas facultades.'],
            ['Tiros Libres Challenge', 'Tiro libre', 8, '13:00', 30, true, 7, 'Gana quien anote más tiros libres seguidos.'],
            ['Copa Jóvenes Promesas', 'Básquetbol 3x3', 16, '09:30', 12, true, 1, 'Categoría libre para nuevos jugadores.'],
            ['Superliga Élite', 'Básquetbol 5x5', 40, '19:30', 16, true, 11, 'Para jugadores con experiencia en ligas locales.'],
            ['Open de Verano (pasado)', 'Básquetbol 3x3', -30, '15:00', 20, true, 5, 'Edición anterior, ya finalizada.'],
            ['Noche de Bandazos', 'Concurso de clavadas', 28, '22:00', 6, false, 0, 'Aún en preparación, cerrado por el admin.'],
        ];

        foreach ($torneos as [$nombre, $juego, $dias, $hora, $cupo, $abierto, $inscritos, $desc]) {
            [$h, $m] = explode(':', $hora);

            $torneo = Torneo::create([
                'nombre' => $nombre,
                'juego' => $juego,
                'fecha' => now()->addDays($dias)->setTime((int) $h, (int) $m),
                'cupo' => $cupo,
                'descripcion' => $desc,
                'abierto' => $abierto,
            ]);

            foreach ($jugadores->shuffle()->take(min($inscritos, $cupo)) as $jugador) {
                $torneo->inscripciones()->create(['user_id' => $jugador->id]);
            }
        }
    }
}
