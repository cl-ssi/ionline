FROM php:7.4.3-fpm-alpine

# Install dependencies for GD and install GD with support for jpeg, png webp and freetype
# Info about installing GD in PHP https://www.php.net/manual/en/image.installation.php
RUN apk add --no-cache \
        libjpeg-turbo-dev \
        libpng-dev \
        libwebp-dev \
        freetype-dev \
        libxml2-dev \
        libzip-dev \
        bash

RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN docker-php-ext-enable pdo_mysql

# As of PHP 7.4 we don't need to add --with-png
RUN docker-php-ext-configure gd --with-jpeg --with-webp --with-freetype

RUN docker-php-ext-install gd

RUN docker-php-ext-install soap

RUN docker-php-ext-install zip

RUN sh -c "wget http://getcomposer.org/composer.phar && chmod a+x composer.phar && mv composer.phar /usr/local/bin/composer"

# Algunos alias
RUN echo "PS1='\[\033[01;35m\]UniSalud\[\033[00m\]@\[\033[01;34m\]\w\[\033[00m\]:\\$ '" >> ~/.bashrc
RUN echo "alias serve='php artisan serve --host=0.0.0.0 --port=8000'" >> ~/.bashrc
RUN echo "alias tinker='php artisan tinker'" >> ~/.bashrc
RUN echo "alias s='cd ..'" >> ~/.bashrc

# Crear el usuario y grupo tic
RUN chmod 666 /root
RUN addgroup -g 1000 tic
RUN adduser -G tic -u 1000 -D -h /root -s /bin/bash tic

##  Algunos Alias para el terminal
# alias dbuild='docker build docker/dev -t `basename "$PWD"`'
# alias drun='docker run --rm -it -v $(pwd):/var/www/html -p 8000:8000 -d --name `basename "$PWD"` `basename "$PWD"`'
# alias dexec='docker exec -it `basename "$PWD"` /bin/bash'
# alias dstop='docker stop `basename "$PWD"`'