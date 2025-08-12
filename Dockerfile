FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    nginx \
    curl \
    zip \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    mariadb-client \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd mbstring zip mysqli pdo pdo_mysql

# Copy WordPress files to /var/www/html
COPY . /var/www/html

# Set permissions
RUN chown -R www-data:www-data /var/www/html

# Copy Nginx config
COPY default.conf /etc/nginx/conf.d/default.conf

# Expose Render's port
EXPOSE $PORT

# Start both Nginx & PHP-FPM
CMD service nginx start && php-fpm
