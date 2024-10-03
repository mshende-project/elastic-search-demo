#docker/php
FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    gnupg \
    g++ \
    procps \
    openssl \
    git \
    unzip \
    zlib1g-dev \
    libzip-dev \
    libfreetype6-dev \
    libpng-dev \
    libjpeg-dev \
    libicu-dev  \
    libonig-dev \
    libxslt1-dev \
    acl \
    cron \
     netcat-openbsd \
    && echo 'alias sf="php bin/console"' >> ~/.bashrc \
    && apt-get clean && rm -rf /var/lib/apt/lists/*  # Clean up to reduce image size

RUN docker-php-ext-configure gd --with-jpeg --with-freetype 

RUN docker-php-ext-install -j$(nproc) mysqli pdo pdo_mysql; \
	docker-php-ext-enable pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Create directories for logs and cache
RUN mkdir -p /app/var/log /app/var/cache

# Set the correct permissions for the log and cache directories
RUN chmod -R 777 /app/var/log /app/var/cache

COPY /app/.env /app/.env

# Copy the crontab file to /etc/cron.d
COPY /app/app-crontab /etc/cron.d/app-crontab

# Set the correct permissions for the cron file
RUN chmod 0644 /etc/cron.d/app-crontab

# Ensure the cron job is registered and the cron service is started
RUN touch /app/var/log/cron.log

WORKDIR /app

COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint
RUN chmod +x /usr/local/bin/docker-entrypoint

ENTRYPOINT ["docker-entrypoint"]
CMD ["php-fpm"]

