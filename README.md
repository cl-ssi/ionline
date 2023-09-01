# Autoría

Sistema desarrollado el Departamento TIC del Servicio de Salud de Iquique.

sistemas.ssi@redsalud.gob.cl

## Cambio de rama de master a main

```
git branch -m master main
git fetch origin
git branch -u origin/main main
git remote set-head origin -a
```

# Instalacion

> Este proyecto está desarrollado en Laravel 8

> Incluye Bootstrap 4, jQuery y Font Awesome

## Prerequisitos

-   git
-   composer
-   php >= 8.1

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

composer update

composer remove and require after update:

barryvdh/laravel-dompdf
firebase/php-jwt
guzzlehttp/guzzle
maatwebsite/excel
owen-it/laravel-auditing
phpoffice/phpword
setasign/fpdf
setasign/fpdi
simplesoftwareio/simple-qrcode
spatie/laravel-permission
stackkit/laravel-google-cloud-scheduler
laravel/passport

stackkit/laravel-google-cloud-tasks-queue:\* depende de monolog 3

/\*_ Actualizar archivo filesystem.php _/
superbalist/laravel-google-cloud-storage => spatie/laravel-google-cloud-storage

actived/microsoft-teams-notifier:\*

--dev
barryvdh/laravel-debugbar
barryvdh/laravel-ide-helper

composer remove fruitcake/laravel-cors
composer remove fideloper/proxy
Update archivo Kernel.php, TrustProxies y AuthServiceProvider
