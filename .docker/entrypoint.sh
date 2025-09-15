#!/bin/sh

# Garante que o composer esteja instalado
composer install --no-interaction --prefer-dist --optimize-autoloader

# Aguarda o banco ficar disponível antes de rodar as migrations
until php -r "mysqli_connect('onfly-db','onfly','secret','onfly');" 2>/dev/null; do
  echo "Aguardando banco de dados..."
  sleep 3
done

# Rodar migrations
php artisan migrate --force

# Executa o comando original do container (php-fpm)
exec "$@"
