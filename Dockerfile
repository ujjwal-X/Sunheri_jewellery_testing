# Use official PHP image with FPM
FROM php:8.2-fpm

# Install required PHP extensions
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    curl \
    libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy all WordPress files into container (mounted via docker-compose)
# In production, you might COPY instead of mount
COPY ./app/public/ /var/www/html/

# Set permissions
RUN chown -R www-data:www-data /var/www/html

# Expose port for FPM (used internally with NGINX)
EXPOSE 9000

# Start PHP-FPM server
CMD ["php-fpm"]
