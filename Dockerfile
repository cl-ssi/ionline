FROM php:8.2-fpm-alpine

# Instalar dependencias y extensiones PHP en una sola capa
RUN apk add --no-cache nginx wget \
        libjpeg-turbo-dev \
        libpng-dev \
        libwebp-dev \
        freetype-dev \
        libxml2-dev \
        icu-dev \
        libzip-dev \
        mdbtools-utils \
        poppler-utils \
    && docker-php-ext-configure gd --with-jpeg --with-webp --with-freetype \
    && docker-php-ext-configure intl \
    && docker-php-ext-install -j$(nproc) \
        mysqli \
        pdo \
        pdo_mysql \
        gd \
        zip \
        bcmath \
        intl \
        opcache \
        ctype \
    && docker-php-ext-enable pdo_mysql intl \
    && mkdir -p /run/nginx /app \
    && chown -R www-data:www-data /app

# Copy configuration files
COPY docker/php.ini /usr/local/etc/php/conf.d/docker-php.ini
COPY docker/nginx.conf /etc/nginx/nginx.conf

# Configurar directorio de trabajo
WORKDIR /app

# Copiar los archivos del proyecto
COPY --chown=www-data:www-data . /app

# Instalar Composer y dependencias
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader \
    && php artisan icons:cache \
    && php artisan filament:cache-components \
    && php artisan route:cache \
    # && php artisan view:cache \
    && php artisan event:cache
    # && php artisan config:cache
    # && php artisan optimize \

    #// No reconoce las variables de entorno para poder ejecutar las migraciones
    # && php artisan migrate --force

# Comando para iniciar la aplicación
CMD sh /app/docker/startup.sh
