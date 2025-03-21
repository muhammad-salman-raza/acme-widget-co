FROM php:8.4-fpm

WORKDIR /app

# Install system dependencies and necessary PHP extensions.
RUN apt-get update && apt-get install -y unzip \
    && docker-php-ext-install bcmath

# Install Xdebug (for debugging and code coverage).
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Install Composer globally.
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy composer files and install dependencies.
COPY composer.json composer.lock* ./
RUN composer install --prefer-dist --no-scripts --no-progress --no-interaction

# Copy the rest of the application code.
COPY . .

# PHP-FPM will run as the container's main process.
CMD ["php-fpm"]
