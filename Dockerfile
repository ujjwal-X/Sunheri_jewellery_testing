# Use PHP-FPM base image
FROM php:8.2-fpm

# Install Nginx and PHP extensions for WordPress
RUN apt-get update && apt-get install -y \
    nginx \
    gettext-base \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    mariadb-client \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd mysqli pdo pdo_mysql zip mbstring

# Set working directory
WORKDIR /var/www/html

# Copy WordPress files
COPY app/public/ /var/www/html/

# Set ownership and permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Copy Nginx config template
COPY conf/default.conf /etc/nginx/conf.d/default.conf.template

# Start Nginx and PHP-FPM
CMD envsubst '${PORT}' < /etc/nginx/conf.d/default.conf.template > /etc/nginx/conf.d/default.conf \
    && nginx -g 'daemon off;' & php-fpm

EXPOSE 80
