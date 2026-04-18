FROM php:8.3-cli

# install system dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip libzip-dev libpng-dev libonig-dev

# install php extensions
RUN docker-php-ext-install pdo pdo_mysql zip mbstring

# install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

# install dependencies
RUN composer install --no-dev --optimize-autoloader

# fix permission
RUN chmod -R 777 storage bootstrap/cache

EXPOSE 10000

CMD php artisan serve --host=0.0.0.0 --port=10000