# Autoría
Sistema desarrollado la unidad TIC del Servicio de Salud de Iquique.

sistemas.ssi@redsalud.gob.cl

# Instalacion
> Este proyecto está desarrollado en Laravel 7

> Incluye Bootstrap 4, jQuery y Font Awesome

## Prerequisitos
- git
- composer

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
