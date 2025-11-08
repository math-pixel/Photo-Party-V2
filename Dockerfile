# Dockerfile

FROM php:8.3-cli

# Installer les dépendances système
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libicu-dev \
    sqlite3 \
    libsqlite3-dev \
    curl \
    libmagickwand-dev --no-install-recommends

# Installer les extensions PHP nécessaires
RUN docker-php-ext-install \
    pdo \
    pdo_sqlite \
    intl \
    zip \
    fileinfo

# Activer l'extension fileinfo (pour VichUploader)
RUN docker-php-ext-enable fileinfo

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail
WORKDIR /app

# Copier les fichiers du projet
COPY . /app

# Donner les permissions sur le dossier var
RUN chmod -R 777 /app/var

# Exposer le port 8000
EXPOSE 8000

# Commande par défaut
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
