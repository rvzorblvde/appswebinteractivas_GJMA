<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $this->crear('Administrador', 'admin@torneos.test', 'admin');
        $this->crear('Jugador Demo', 'jugador@torneos.test', 'jugador');
    }

    private function crear(string $nombre, string $email, string $rol): void
    {
        $user = User::firstOrNew(['email' => $email]);
        $user->forceFill([
            'name' => $nombre,
            'password' => 'password',
            'role' => $rol,
        ])->save();
    }
}
