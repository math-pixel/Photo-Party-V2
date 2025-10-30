# Dockerfile
FROM php:8.3-cli

WORKDIR /app

# Installe les extensions utilisées par Symfony
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libzip-dev \
    libicu-dev \
    libjpeg-dev \
    libpng-dev \
    && docker-php-ext-install pdo pdo_pgsql intl zip gd

# Installe Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
