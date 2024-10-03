#!/bin/bash
set -e

echo "Starting entrypoint script..."

# Ensure working directory is correct
cd /app

# Check if composer.json exists
if [ -f /app/composer.json ]; then
    echo "Found composer.json in /app. Installing Composer dependencies..."

    # Log current directory contents for debugging
    echo "Current directory contents:"
    ls -l /app

    # Install Composer dependencies with verbose output for debugging
    composer install --prefer-dist --no-progress --no-interaction --verbose || {
        echo "Composer install failed"
        exit 1
    }
else
    echo "composer.json not found in /app. Skipping Composer install."
fi

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
