FROM php:8.4-apache

# Enable required PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Enable Apache rewrite
RUN a2enmod rewrite

# IMPORTANT: Disable all MPMs first
RUN a2dismod mpm_event mpm_worker || true

# Enable ONLY prefork (required for PHP)
RUN a2enmod mpm_prefork

# Copy app files
COPY . /var/www/html/

# Set permissions
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
