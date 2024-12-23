# Autoría

Sistema desarrollado el Departamento TIC del Servicio de Salud de Tarapacá.

sistemas.sst@redsalud.gob.cl

## Aceptamos contribuciones a través de Pull Request

# Instalacion

> Este proyecto está desarrollado en Laravel 11.

> Incluye Bootstrap 5 jQuery y Font Awesome y Bootstrap Icons.

## Prerequisitos


-   git
-   composer
-   php >= 8.2
-   php extensions: fileinfo, openssl, gd, sodium, zip, mbstring, pdo_mysql

## Ejecutar en un terminal los siguientes comandos

```
git clone http://github.com/cl-ssi/ionline
cd ionline
composer install
cp .env.example .env
php artisan key:generate

# editar archivo .env y setear las variables del sistema y de la base de datos.
php artisan migrate:fresh --seed
```

## Usuario por defecto

Usuario: 12345678-9 clave: admin

### Al cambiar logos o favicons editar archivo `.gitignore` y agregar

```
public/favicon*
public/images/logo*
```

### Otras configuraciones php

Editar php.ini para que se puedan subir archivos más grandes.

```
memory_limit = 128M
upload_max_filesize = 64M
post_max_size = 66M
```

## Contribuir
- Seleccionar issue
- Hacer modificaciones y commits
- Crear el pull request
- Detener issue en el que se estaba trabajando

## Update laravel 11
Update MariaDb Driver
# "require":
"php": "^8.2",
"ext-gd": "*",
"actived/microsoft-teams-notifier": "^1.3",
"barryvdh/laravel-dompdf": "^3.0",
"doctrine/dbal": "^3.0", // eliminar
"filament/filament": "^3.2",
"firebase/php-jwt": "^6.10",
"guzzlehttp/guzzle": "^7.9",
"laminas/laminas-escaper": "^2.13",
"laravel/framework": "^11.0", // actualizar
"laravel/passport": "^12.3", // actualizar
"laravel/tinker": "^2.9",
"laravel/ui": "^4.0",
"livewire/livewire": "^3.4",
"luecano/numero-a-letras": "^3.0",
"maatwebsite/excel": "^3.1",
"owen-it/laravel-auditing": "^13.6",
"phpoffice/phpword": "^1.3",
"setasign/fpdf": "^1.8",
"setasign/fpdi": "^2.6",
"simplesoftwareio/simple-qrcode": "^4.2",
"spatie/laravel-google-cloud-storage": "^2.3",
"spatie/laravel-permission": "^6.0",
"spatie/pdf-to-text": "^1.53",
"stackkit/laravel-google-cloud-scheduler": "^3.0",
"stackkit/laravel-google-cloud-tasks-queue": "^4.0",
"tinymce/tinymce": "^7.1"

# "require-dev"
"barryvdh/laravel-debugbar": "^3.13",
"barryvdh/laravel-ide-helper": "^3.1",
"fakerphp/faker": "^1.23",
"kitloong/laravel-migrations-generator": "^7.0",
"laravel/pint": "^1.17",
"laravel/sail": "^1.31",
"mockery/mockery": "^1.6",
"nunomaduro/collision": "^8.1", // actualizar
"phpunit/phpunit": "^11.0", // actualizar
"spatie/laravel-ignition": "^2.8"

## Prompt para ordenar los modelos
Ordename la clase.
1. Primero las variables $table, $fillable, $casts, $hidden, luego las relaciones, luego los métodos customs y al final del archivo el método boot() si lo tuviera.
2. Los atributos de $fillable, $casts y $hidden, que queden uno debajo del otro cada atributo en vez de juntos en la misma línea.
3. Elimina la variable $dates si es que existe, en incluye los valores que no estén presentes en la variable $casts de tipo 'datetime' por defecto.
4. Deja todas las relaciones en formato laravel 11 y con su tipo de retorno y que hagan referencia a una clase en vez de un string, importa su clase al comienzo si no está importada.
5. Ordena todas las clases importadas alfabéticamente y elimina los que no estén en uso.
6. Si la clase usa SoftDeletes, elimina de $casts "deleted_at".
7. Incluye el comentarios estandares de laravel, para las variables y relaciones.