# Recetario

Aplicación web donde cada usuario guarda, consulta, edita y elimina sus propias
recetas de cocina. Hecha con **Laravel 12**, **Tailwind CSS 4**, **Alpine.js** y **SQLite**.

## Características

- Registro e inicio de sesión (sin roles ni permisos especiales).
- Cada receta pertenece al usuario que la creó; nadie más puede verla ni modificarla.
- CRUD completo de recetas con ingredientes y pasos guardados como texto (uno por línea).
- Validaciones en español con errores junto a cada campo.
- Buscador por título combinable con filtro por categoría.
- Confirmación antes de eliminar y mensajes de éxito en cada operación.

## Requisitos

- PHP 8.2 o superior con extensiones `pdo_sqlite`, `sqlite3`, `mbstring`, `openssl`
- Composer 2
- Node.js 20 o superior y npm

## Instalación

```bash
git clone <url poner luego> recetario
cd recetario

composer install
npm install

cp .env.example .env
php artisan key:generate
```

En el archivo `.env` verifica:

```env
APP_LOCALE=es
APP_FALLBACK_LOCALE=es
APP_TIMEZONE=America/Mexico_City
DB_CONNECTION=sqlite
```

## Crear la base de datos

SQLite usa un archivo; solo hay que crearlo vacío y ejecutar las migraciones:

```bash
touch database/database.sqlite        # Windows: type nul > database\database.sqlite
php artisan migrate
```

Para cargar datos de prueba (2 usuarios y 4 recetas):

```bash
php artisan db:seed
```

Para reiniciar todo desde cero: `php artisan migrate:fresh --seed`

### Usuarios de prueba

| Nombre       | Correo              | Contraseña |
|--------------|---------------------|------------|
| Ana López    | ana@example.com     | password   |
| Carlos Pérez | carlos@example.com  | password   |

## Ejecutar la aplicación

```bash
npm run dev            # terminal 1: compila Tailwind y Alpine con Vite
php artisan serve      # terminal 2: servidor en http://localhost:8000
```

Alternativa en una sola terminal: `composer run dev`.

Para producción: `npm run build`.

## Cómo probar cada fase

### Fase 1. Registrar un nuevo usuario
1. Abre `http://localhost:8000/registro`.
2. Envía el formulario vacío: aparecen errores bajo cada campo.
3. Registra a "Luis Gómez", `luis@example.com`, contraseña `12345678` y confirmación igual.
4. Quedas autenticado, ves el mensaje "¡Cuenta creada!…" y el listado vacío.

### Fase 2. Crear una receta válida y una con datos inválidos
1. Haz clic en **Nueva receta**.
2. **Inválida:** deja el título vacío, no elijas categoría, escribe `0` en el tiempo y pulsa **Guardar**.
   Verás los errores junto a cada campo ("El título es obligatorio.", "Debes seleccionar una categoría.",
   "El tiempo debe ser mayor a 0 minutos.") y los datos escritos se conservan.
   (El formulario usa `novalidate` para que se vea la validación del servidor.)
3. **Válida:** título "Huevos revueltos", categoría Desayuno, 10 minutos, dificultad Fácil,
   ingredientes y pasos (uno por línea) y, opcionalmente, una nota personal.
4. Se muestra "Receta creada correctamente."

### Fase 3. Abrir el detalle de una receta
1. En el listado pulsa **Ver** sobre una receta.
2. Verifica que los ingredientes salen como lista, los pasos como lista numerada y la nota personal en un recuadro.

### Fase 4. Editar y guardar / eliminar con confirmación
1. Pulsa **Editar**, cambia el tiempo y guarda: aparece "Receta actualizada correctamente."
2. Prueba guardar con el título vacío: se muestra el error y no se modifica nada.
3. Pulsa **Eliminar**: aparece un diálogo de confirmación.
    - **Cancelar** (o la tecla Esc) cierra el diálogo y no borra nada.
    - **Sí, eliminar** borra la receta y muestra "Receta eliminada correctamente."

### Fase 5. Buscar por título y filtrar por categoría
Con los datos del seeder, inicia sesión como `ana@example.com`:
1. Escribe `tarta` y pulsa **Buscar**: solo aparece "Tarta de manzana".
2. Limpia y elige la categoría **Desayuno**: solo aparecen los chilaquiles.
3. Combina título `tarta` + categoría **Desayuno**: no hay resultados y se muestra
   "No se encontraron recetas con los filtros aplicados."
4. Pulsa **Limpiar** para volver al listado completo.

### Fase 6. Entrar con otro usuario
1. Cierra sesión con **Cerrar sesión**.
2. Inicia sesión con `carlos@example.com` / `password`.
3. Solo ves "Pasta carbonara" y "Agua de jamaica"; las recetas de Ana no aparecen.
4. Copia la URL de una receta de Ana (por ejemplo `/recetas/1`) y ábrela como Carlos:
   obtienes un 404 en español.

## Estructura principal

```
app/Http/Controllers/AuthController.php
app/Http/Controllers/RecipeController.php
app/Http/Requests/RecipeRequest.php
app/Models/Recipe.php
database/migrations/xxxx_create_recipes_table.php
database/seeders/DatabaseSeeder.php
resources/views/layouts/app.blade.php
resources/views/auth/{login,register}.blade.php
resources/views/recipes/{index,create,edit,show,_form}.blade.php
resources/views/components/delete-recipe.blade.php
routes/web.php
```

## Notas

- Los ingredientes y pasos se guardan como texto plano; la vista los separa por línea.
- La búsqueda por título usa `LIKE` de SQLite (no distingue mayúsculas en ASCII).
- Todas las consultas de recetas pasan por `auth()->user()->recipes()`, por lo que es imposible acceder a recetas ajenas.
