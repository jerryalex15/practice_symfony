#!/usr/bin/env bash
set -e

# Script d'entrée minimal : corriger droits/permissions si besoin puis exécuter la commande passée
# Usage: ENTRYPOINT ["docker-entrypoint"] CMD ["php-fpm"]

# S'assurer que le répertoire var existe et appartient à www-data
mkdir -p var var/cache var/log
chown -R www-data:www-data var

# Si composer.lock existe mais vendor est vide, on peut lancer composer install (optionnel)
if [ -f composer.json ] && [ ! -d vendor ]; then
    echo "vendor absent — exécution de composer install..."
    composer install --no-interaction --prefer-dist
fi

# Exécuter la commande fournie
exec "$@"