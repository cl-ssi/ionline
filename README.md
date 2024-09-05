# Autoría

Sistema desarrollado el Departamento TIC del Servicio de Salud de Tarapacá.

sistemas.sst@redsalud.gob.cl

## Aceptamos contribuciones a través de Pull Request

# Instalacion

> Este proyecto está desarrollado en Laravel 9

> Incluye Bootstrap 5 jQuery y Font Awesome

## Prerequisitos

-   git
-   composer
-   php >= 8.2
-   php extensions: fileinfo, gd, sodium, zip, mbstring, pdo_mysql

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

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

# Update to Laravel 9.0

- composer update

- composer remove and require after update:

- barryvdh/laravel-dompdf
- firebase/php-jwt
- guzzlehttp/guzzle
- maatwebsite/excel
- owen-it/laravel-auditing
- phpoffice/phpword
- setasign/fpdf
- setasign/fpdi
- simplesoftwareio/simple-qrcode
- spatie/laravel-permission
- stackkit/laravel-google-cloud-scheduler
- laravel/passport

- stackkit/laravel-google-cloud-tasks-queue:\* depende de monolog 3

- /\*_ Actualizar archivo filesystem.php _/
- superbalist/laravel-google-cloud-storage => spatie/laravel-google-cloud-storage

- actived/microsoft-teams-notifier:\*

- --dev
- barryvdh/laravel-debugbar
- barryvdh/laravel-ide-helper

- composer remove fruitcake/laravel-cors
- composer remove fideloper/proxy
- Update archivo Kernel.php, TrustProxies y AuthServiceProvider

## Contribuir
- Seleccionar issue
- Hacer modificaciones y commits
- Crear el pull request
- Detener issue en el que se estaba trabajando

## Update livewire 3
- Merge


## Prompt para ordenar los modelos
Ordename la clase.
1. Primero las variables $table, $fillable, $casts, $hidden, luego las relaciones, luego los métodos customs y al final del archivo el método boot() si lo tuviera.
2. Los atributos de $fillable, $casts y $hidden, que queden uno debajo del otro cada atributo en vez de juntos en la misma línea.
3. Elimina la variable $dates si es que existe, en incluye los valores que no estén presentes en la variable $casts de tipo 'datetime' por defecto.
4. Deja todas las relaciones en formato laravel 11 y con su tipo de retorno y que hagan referencia a una clase en vez de un string, importa su clase al comienzo si no está importada.
5. Ordena todas las clases importadas alfabéticamente y elimina los que no estén en uso.
6. Si la clase usa SoftDeletes, elimina de $casts "deleted_at".
7. Incluye el comentarios estandares de laravel, para las variables y relaciones.