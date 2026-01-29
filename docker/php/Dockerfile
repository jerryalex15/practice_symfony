# Dockerfile pour PHP 8.5 FPM (développement)
FROM php:8.5-fpm

# Mettre à jour et installer dépendances système nécessaires
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    unzip \
    curl \
    libpq-dev \
    libzip-dev \
    libicu-dev \
    libonig-dev \
    libxml2-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    ca-certificates \
    && rm -rf /var/lib/apt/lists/*

# Extensions PHP nécessaires pour Symfony API
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo_pgsql \
        intl \
        mbstring \
        zip \
        gd

# Installer composer (dernier installateur)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Ajouter un utilisateur non-root si tu veux (ici on utilise www-data)
WORKDIR /var/www/html

# Copier entrypoint si présent
COPY ./docker/php/entrypoint.sh /usr/local/bin/docker-entrypoint
RUN chmod +x /usr/local/bin/docker-entrypoint

# Exposer le port FPM
EXPOSE 9000

# Par défaut on lance php-fpm via l'entrypoint
ENTRYPOINT ["docker-entrypoint"]
CMD ["php-fpm"]