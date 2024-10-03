#!/bin/bash
set -e

# Wait for the database to become available
echo "Waiting for database to become available..."
until nc -z mysql8-service 3306; do
    sleep 1
done
echo "Database is up!"

# Run migrations
if [ -f /app/bin/console ]; then
    echo "Running migrations..."
    php /app/bin/console doctrine:migrations:migrate --no-interaction
else
    echo "Migration file not found. Skipping migrations."
fi

# Start the cron service
service cron start

# Start the PHP-FPM service
exec php-fpm
