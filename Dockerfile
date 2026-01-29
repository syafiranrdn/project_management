FROM php:8.2-apache

# Install required extensions for MySQL PDO
RUN docker-php-ext-install pdo pdo_mysql

# Enable Apache rewrite (optional but good)
RUN a2enmod rewrite

# Copy project files into Apache web root
COPY . /var/www/html/

# Permissions (optional safe)
RUN chown -R www-data:www-data /var/www/html
