# Dockerfile (version complète)
FROM dunglas/frankenphp:latest-php8.3

# Installer les dépendances système
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libicu-dev \
    sqlite3 \
    libsqlite3-dev \
    libmagickwand-dev --no-install-recommends \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Installer les extensions PHP
RUN install-php-extensions \
    pdo \
    pdo_sqlite \
    intl \
    zip \
    opcache \
    apcu

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail
WORKDIR /app

# ⭐ Copier le Caddyfile personnalisé
COPY Caddyfile /etc/caddy/Caddyfile

# Copier les fichiers du projet
COPY . /app

# Permissions
RUN chmod -R 777 /app/var

# Exposer les ports
EXPOSE 80 443

# Variables d'environnement
ENV SERVER_NAME=":80"

# Commande par défaut
CMD ["frankenphp", "run", "--config", "/etc/caddy/Caddyfile"]
