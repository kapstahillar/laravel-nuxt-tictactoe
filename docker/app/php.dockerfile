FROM php:8.2-fpm

# Set the working directory
WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && \
    apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpq-dev \
    libonig-dev;

# Install php dependencies and get composer
RUN docker-php-ext-install pdo pdo_pgsql && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy the application code
COPY ./api .

# Install Laravel dependencies
RUN composer install

# Generate the Laravel key
RUN php artisan key:generate

# Generate the Composer autoload files
RUN composer dump-autoload

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

CMD [ "php-fpm" ]
EXPOSE 9000