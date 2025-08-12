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

# Copy WordPress files into container
COPY . /var/www/html

# Set ownership
RUN chown -R www-data:www-data /var/www/html

# Copy Nginx config template
COPY default.conf /etc/nginx/conf.d/default.conf.template

# Replace ${PORT} with actual env var at runtime & start services
CMD envsubst '${PORT}' < /etc/nginx/conf.d/default.conf.template > /etc/nginx/conf.d/default.conf \
    && service nginx start \
    && php-fpm

# Render will detect port from EXPOSE
EXPOSE $PORT
