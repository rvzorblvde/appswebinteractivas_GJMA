# Hoop Arena — Sistema de Torneos de Básquetbol

Aplicación web hecha con Laravel donde un **administrador** crea torneos de básquetbol
y los **jugadores** se inscriben. Los visitantes sin cuenta solo consultan.

**Segundo Parcial — Aplicaciones Web Interactivas**

**Guillermo Jair Muñoz Amaro -332508**

## Tecnologías
- Laravel 12 · PHP 8.2+
- SQLite
- Tailwind CSS 4 (Vite)
- Alpine.js (modales, menú, transiciones) y GSAP (animaciones)
- Autenticación manual con roles (`admin` / `jugador`)

## Requisitos
PHP 8.2+, Composer, Node.js 18+ y npm. La extensión `pdo_sqlite` de PHP debe estar activa.

## Instalación
```bash
git clone <URL-DEL-REPOSITORIO>
cd torneos-basquet
composer install
npm install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite      # Windows: type nul > database\database.sqlite
php artisan migrate:fresh --seed
composer run dev                    # o: php artisan serve + npm run dev
```
Abrir: http://localhost:8000

## Cuentas demo
| Rol | Correo | Contraseña |
|---|---|---|
| Administrador | admin@torneos.test | password |
| Jugador | jugador@torneos.test | password |
| Jugadores NBA (12) | lebron.james@torneos.test, james.harden@torneos.test, etc. | password |

### ¿Cómo se crea el administrador?
Con el seeder `UsuariosSeeder` (`php artisan migrate:fresh --seed`).
El registro público **siempre** crea usuarios con rol `jugador`.
Alternativa manual: registrar una cuenta y ejecutar
`php artisan tinker` → `User::where('email','tu@correo.com')->update(['role'=>'admin']);`

## Reglas de sistema
- Un torneo está **cerrado** si el admin lo marca cerrado, si su fecha ya pasó o si se llenó el cupo.
- El listado público solo muestra torneos abiertos, con fecha futura y cupo libre, ordenados por fecha próxima.
  Los torneos cerrados/llenos solo se ven por URL directa (`/torneos/{id}`).
- Cupo entre 2 y 100 (por defecto 16). No se puede bajar por debajo de los jugadores ya inscritos.
- Un jugador no puede inscribirse dos veces (validación en controlador + índice único en BD).
- Cancelar una inscripción libera la plaza; solo se permite hasta la fecha del evento.
- Al eliminar un torneo se eliminan sus inscripciones (cascada).

## Cómo probar cada punto
1. **Registro / login / logout con roles**
   Ir a `/registro`, crear cuenta (queda como jugador), cerrar sesión y entrar con `admin@torneos.test`.
   El menú cambia según el rol (Mis torneos / Panel admin).
2. **CRUD de torneos (admin)**
   En `/admin/torneos` crear un torneo. Probar errores: nombre vacío, fecha pasada, cupo 1 o 101.
   Editar y bajar el cupo por debajo de los inscritos (ej. "Liga Intercolegial 5x5" con cupo 1 →
   error). Eliminar un torneo con inscritos (pide confirmación).
3. **Listado y detalle público**
   En `/torneos` (sin sesión) se ven solo los torneos disponibles, ordenados por fecha.
   No aparecen "Clásico de Veteranos" (cerrado), "Torneo Apertura" (pasado) ni "Final Four Express" (lleno),
   pero sí por URL directa. Si no hay torneos, se muestra un mensaje. Usar el buscador.
4. **Inscripciones (jugador)**
   Con `jugador@torneos.test`: abrir un torneo → "Inscribirme". Intentar inscribirse de nuevo (aviso de duplicado).
   Abrir "Final Four Express" (lleno) y el "Clásico de Veteranos" (cerrado): no se puede inscribir.
   Ver "Mis torneos" y cancelar una inscripción: la plaza se libera.
5. **Gestión de inscritos (admin)**
   En el panel, botón "Inscritos" → "Dar de baja" a un jugador.
6. **Permisos**
   Sin sesión o como jugador, entrar a `/admin/torneos` → redirige con aviso.
   Como admin, `/mis-torneos` también redirige con aviso.
7. **Mensajes**
   Éxitos y errores aparecen en español como avisos y debajo de cada campo.

## Estructura relevante
```
app/Http/Controllers/        AuthController, TorneoController, InscripcionController
app/Http/Controllers/Admin/  TorneoController, InscripcionController
app/Http/Middleware/         RolMiddleware (alias "rol")
app/Http/Requests/           TorneoRequest
app/Models/                  User, Torneo, Inscripcion
database/migrations/         users.role, torneos, inscripciones
database/seeders/            UsuariosSeeder, TorneoSeeder
resources/views/             layouts, auth, torneos, admin, components
```

## Extras implementados
Diseño responsive con Tailwind, animaciones con GSAP/Alpine, buscador, contador y barra de plazas,
badges de estado (abierto, lleno, cerrado, finalizado, inscrito), modales de confirmación al eliminar/cancelar
y pantalla "Mis torneos" con historial.
