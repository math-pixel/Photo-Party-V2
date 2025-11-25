FROM dunglas/frankenphp:latest-php8.3

# Installer les extensions PHP nécessaires pour Symfony
RUN install-php-extensions \
    pdo_mysql \
    pdo_pgsql \
    pdo_sqlite \
    intl \
    zip \
    opcache \
    apcu \
    gd

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copier les fichiers de dépendances
COPY composer.json composer.lock ./

# Installer les dépendances
RUN composer install --no-scripts --no-autoloader --prefer-dist

# Copier le reste de l'application
COPY . .

# Générer l'autoloader optimisé
RUN composer dump-autoload --optimize

# Permissions
RUN chown -R www-data:www-data /app/var

CMD ["frankenphp", "run", "--config", "/etc/caddy/Caddyfile"]
