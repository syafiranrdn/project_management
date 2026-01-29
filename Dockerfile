FROM php:8.4-apache

# Disable other MPMs, enable prefork ONLY
RUN a2dismod mpm_event mpm_worker && a2enmod mpm_prefork

# Install MySQL extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Enable Apache rewrite
RUN a2enmod rewrite

# Copy project files
COPY . /var/www/html/

# Fix permissions
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
