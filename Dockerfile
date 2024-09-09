FROM php:8.2-fpm-alpine

# Install dependencies and tools
RUN apk add --no-cache \
        nginx \
        wget \
        libjpeg-turbo-dev \
        libpng-dev \
        libwebp-dev \
        freetype-dev \
        libxml2-dev \
        libzip-dev \
        mdbtools-utils \
        poppler-utils && \
    docker-php-ext-install mysqli pdo pdo_mysql ctype && \
    docker-php-ext-enable pdo_mysql && \
    docker-php-ext-configure gd --with-jpeg --with-webp --with-freetype && \
    docker-php-ext-configure intl \
    docker-php-ext-install gd soap zip bcmath intl && \
    mkdir -p /run/nginx /app

# Copy configuration files
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/php.ini /usr/local/etc/php/conf.d/docker-php.ini

# Copy application files with ownership
COPY . /app

# Set working directory
WORKDIR /app

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install PHP dependencies
RUN composer install --no-dev

# Set the ownership of the application files
RUN chown -R www-data:www-data /app

# Set the startup command
CMD sh /app/docker/startup.sh