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
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd mysqli pdo pdo_mysql zip mbstring

# Copy WordPress files into container at the correct path
COPY app/public /var/www/html/app/public

# Set ownership for web files
RUN chown -R www-data:www-data /var/www/html/app/public

# Copy Nginx config template
COPY nignix/default.conf /etc/nginx/conf.d/default.conf.template

# Replace ${PORT} with env var & start php-fpm and nginx together
CMD envsubst '${PORT}' < /etc/nginx/conf.d/default.conf.template > /etc/nginx/conf.d/default.conf && \
    php-fpm & \
    nginx -g 'daemon off;'

# Expose the port from environment variable
EXPOSE $PORT
